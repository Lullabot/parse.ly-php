<?php

namespace Lullabot\Parsely\Encoder;

use Symfony\Component\Serializer\Encoder\JsonEncoder as SymfonyJsonEncoder;

/**
 * Encoder for JSON-formatted data with NULL properties.
 */
class JsonEncoder extends SymfonyJsonEncoder
{
    /**
     * {@inheritdoc}
     */
    public function decode($data, $format, array $context = []): mixed
    {
        $decoded = parent::decode($data, $format, $context);
        $this->cleanup($decoded);

        return $decoded;
    }

    /**
     * Recursively filter an array, removing null and empty string values.
     *
     * @param array &$data The data to filter.
     */
    protected function cleanup(array & $data): void
    {
        foreach ($data as &$value) {
            if (\is_array($value)) {
                $this->cleanup($value);
            }
        }

        $data = array_filter($data, function ($value) {
            return null !== $value;
        });
    }
}
