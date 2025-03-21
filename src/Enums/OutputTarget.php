<?php

namespace ameax\DatevExtf\Enums;

final class OutputTarget
{
    public const PRINT = '1';
    public const FAX = '2';
    public const EMAIL = '3';

    /**
     * Get all valid values
     *
     * @return array Valid output targets
     */
    public static function getValidValues(): array
    {
        return [self::PRINT, self::FAX, self::EMAIL];
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