<?php

namespace ameax\DatevExtf\Enums;

final class Currency
{
    public const EUR = 'EUR';
    public const USD = 'USD';
    public const GBP = 'GBP';
    public const CHF = 'CHF';
    public const JPY = 'JPY';
    public const CNY = 'CNY';
    // Add more currencies as needed

    /**
     * Get all valid values
     *
     * @return array Valid currencies
     */
    public static function getValidValues(): array
    {
        return [
            self::EUR,
            self::USD,
            self::GBP,
            self::CHF,
            self::JPY,
            self::CNY
            // Add more currencies as needed
        ];
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