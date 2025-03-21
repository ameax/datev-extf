<?php

namespace ameax\DatevExtf\Enums;

final class FormatName
{
    public const BUCHUNGSSTAPEL = 'Buchungsstapel';
    public const WIEDERKEHRENDE_BUCHUNGEN = 'Wiederkehrende Buchungen';
    public const DEBITOREN_KREDITOREN = 'Debitoren/Kreditoren';
    public const KONTENBESCHRIFTUNGEN = 'Kontenbeschriftungen';
    public const ZAHLUNGSBEDINGUNGEN = 'Zahlungsbedingungen';
    public const DIVERSE_ADRESSEN = 'Diverse Adressen';

    /**
     * Get all valid values
     *
     * @return array Valid format names
     */
    public static function getValidValues(): array
    {
        return [
            self::BUCHUNGSSTAPEL,
            self::WIEDERKEHRENDE_BUCHUNGEN,
            self::DEBITOREN_KREDITOREN,
            self::KONTENBESCHRIFTUNGEN,
            self::ZAHLUNGSBEDINGUNGEN,
            self::DIVERSE_ADRESSEN
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

    /**
     * Get default format version for a format name
     *
     * @param string $formatName Format name
     * @return int Default format version
     */
    public static function getDefaultFormatVersion(string $formatName): int
    {
        $map = [
            self::BUCHUNGSSTAPEL => 13,
            self::WIEDERKEHRENDE_BUCHUNGEN => 2,
            self::DEBITOREN_KREDITOREN => 5,
            self::KONTENBESCHRIFTUNGEN => 2,
            self::ZAHLUNGSBEDINGUNGEN => 2,
            self::DIVERSE_ADRESSEN => 4
        ];

        return $map[$formatName] ?? 0;
    }

    /**
     * Get default format category for a format name
     *
     * @param string $formatName Format name
     * @return int Default format category
     */
    public static function getDefaultFormatCategory(string $formatName): int
    {
        return FormatCategory::getFromFormatName($formatName) ?? 0;
    }
}