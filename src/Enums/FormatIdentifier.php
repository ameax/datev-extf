<?php

namespace ameax\DatevExtf\Enums;

final class FormatIdentifier
{
    public const EXTF = 'EXTF';
    public const DTVF = 'DTVF';

    /**
     * Get all valid values
     *
     * @return array Valid identifiers
     */
    public static function getValidValues(): array
    {
        return [self::EXTF, self::DTVF];
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
