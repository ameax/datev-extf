<?php

namespace ameax\DatevExtf\Enums;

final class Language
{
    public const GERMAN = '1';
    public const FRENCH = '4';
    public const ENGLISH = '5';
    public const SPANISH = '10';
    public const ITALIAN = '19';

    /**
     * Get all valid values
     *
     * @return array Valid language codes
     */
    public static function getValidValues(): array
    {
        return [
            self::GERMAN,
            self::FRENCH,
            self::ENGLISH,
            self::SPANISH,
            self::ITALIAN
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
