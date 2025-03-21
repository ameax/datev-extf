<?php

namespace ameax\DatevExtf\Enums;

final class PartyType
{
    public const NONE = '0';          // No specification
    public const NATURAL_PERSON = '1'; // Natural person
    public const COMPANY = '2';        // Company

    /**
     * Get all valid values
     *
     * @return array Valid party types
     */
    public static function getValidValues(): array
    {
        return [self::NONE, self::NATURAL_PERSON, self::COMPANY];
    }

    /**
     * Check if a value is valid
     *
     * @param string $value Value to check
     * @return bool True if valid
     */
    public static function isValid(string $value): bool
    {
        return in_array($value, self::getValidValues(), true);
    }
}