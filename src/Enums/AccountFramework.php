<?php

namespace ameax\DatevExtf\Enums;

final class AccountFramework
{
    public const SKR03 = 'SKR03';
    public const SKR04 = 'SKR04';
    public const SKR07 = 'SKR07';
    public const SKR14 = 'SKR14';
    public const SKREU = 'SKREU';
    public const SKR49 = 'SKR49';

    /**
     * Get all valid values
     *
     * @return array Valid account frameworks
     */
    public static function getValidValues(): array
    {
        return [
            self::SKR03,
            self::SKR04,
            self::SKR07,
            self::SKR14,
            self::SKREU,
            self::SKR49
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
