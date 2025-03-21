<?php

namespace ameax\DatevExtf\Enums;

final class DebitCreditIndicator
{
    public const DEBIT = 'S';  // SOLL (Debit)
    public const CREDIT = 'H'; // HABEN (Credit)

    /**
     * Get all valid values
     *
     * @return array Valid indicators
     */
    public static function getValidValues(): array
    {
        return [self::DEBIT, self::CREDIT];
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