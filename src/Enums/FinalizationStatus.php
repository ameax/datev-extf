<?php

namespace ameax\DatevExtf\Enums;

final class FinalizationStatus
{
    public const NOT_FINALIZED = 0;
    public const FINALIZED = 1;

    /**
     * Get all valid values
     *
     * @return array Valid finalization statuses
     */
    public static function getValidValues(): array
    {
        return [self::NOT_FINALIZED, self::FINALIZED];
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