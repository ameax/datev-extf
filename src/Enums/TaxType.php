<?php

namespace ameax\DatevExtf\Enums;

final class TaxType
{
    public const IST = 'I';   // Actual taxation
    public const KEINE = 'K';  // No VAT
    public const PAUSCHAL = 'P'; // Flat rate (e.g., for agriculture and forestry)
    public const SOLL = 'S';   // Standard taxation

    /**
     * Get all valid values
     *
     * @return array Valid tax types
     */
    public static function getValidValues(): array
    {
        return [self::IST, self::KEINE, self::PAUSCHAL, self::SOLL];
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
