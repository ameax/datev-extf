<?php

namespace ameax\DatevExtf;

final class AccountingPurpose
{
    public const HGB = 0;             // Jahresabschluss (Handelsbilanz)
    public const EUER = 1;            // EÜR-Rechnung
    public const HGB_AND_HGB_ERW = 50; // Handelsrechtliche Bilanzierung mit IFRS-Anpassungen
    public const ESTG = 30;           // Einkommenssteuerrecht
    public const IFRS = 64;           // IFRS-Bilanzierung
    public const IFRS_AND_HGB = 40;   // IFRS-Bilanzierung mit HGB-Anpassungen

    /**
     * Get all valid values
     *
     * @return array Valid accounting purposes
     */
    public static function getValidValues(): array
    {
        return [
            self::HGB,
            self::EUER,
            self::HGB_AND_HGB_ERW,
            self::ESTG,
            self::IFRS,
            self::IFRS_AND_HGB
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