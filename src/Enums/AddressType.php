<?php

namespace ameax\DatevExtf\Enums;

final class AddressType
{
    public const STREET = 'STR';     // Street address
    public const PO_BOX = 'PF';       // Post office box
    public const LARGE_CUSTOMER = 'GK'; // Large customer

    /**
     * Get all valid values
     *
     * @return array Valid address types
     */
    public static function getValidValues(): array
    {
        return [self::STREET, self::PO_BOX, self::LARGE_CUSTOMER];
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