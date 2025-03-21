<?php

namespace ameax\DatevExtf\Enums;

final class FormatVersion
{
    public const VERSION_2 = 2;
    public const VERSION_4 = 4;
    public const VERSION_5 = 5;
    public const VERSION_13 = 13;

    /**
     * Get all valid values
     *
     * @return array Valid format versions
     */
    public static function getValidValues(): array
    {
        return [
            self::VERSION_2,
            self::VERSION_4,
            self::VERSION_5,
            self::VERSION_13
        ];
    }

    /**
     * Check if a value is valid
     *
     * @param int $value Value to check
     * @return bool True if valid
     */
    public static function isValid(int $value): bool
    {
        return in_array($value, self::getValidValues(), true);
    }
}
