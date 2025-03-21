<?php

namespace ameax\DatevExtf\Enums;

final class FormatCategory
{
    public const DEBITOREN_KREDITOREN = 16;     // Debitoren/Kreditoren
    public const WIEDERKEHRENDE_BUCHUNGEN = 20; // Wiederkehrende Buchungen
    public const BUCHUNGSSTAPEL = 21;           // Buchungsstapel
    public const ZAHLUNGSBEDINGUNGEN = 46;      // Zahlungsbedingungen
    public const DIVERSE_ADRESSEN = 48;         // Diverse Adressen
    public const KONTENBESCHRIFTUNGEN = 65;     // Kontenbeschriftungen

    /**
     * Map of format categories to their descriptions
     *
     * @return array Map of category ID to description
     */
    public static function getDescriptionMap(): array
    {
        return [
            self::DEBITOREN_KREDITOREN => 'Debitoren/Kreditoren',
            self::WIEDERKEHRENDE_BUCHUNGEN => 'Wiederkehrende Buchungen',
            self::BUCHUNGSSTAPEL => 'Buchungsstapel',
            self::ZAHLUNGSBEDINGUNGEN => 'Zahlungsbedingungen',
            self::DIVERSE_ADRESSEN => 'Diverse Adressen',
            self::KONTENBESCHRIFTUNGEN => 'Kontenbeschriftungen'
        ];
    }

    /**
     * Get all valid values
     *
     * @return array Valid categories
     */
    public static function getValidValues(): array
    {
        return array_keys(self::getDescriptionMap());
    }

    /**
     * Get the description for a category ID
     *
     * @param int $categoryId The category ID
     * @return string|null The description or null if not found
     */
    public static function getDescription(int $categoryId): ?string
    {
        return self::getDescriptionMap()[$categoryId] ?? null;
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

    /**
     * Get category ID from format name
     *
     * @param string $formatName Format name
     * @return int|null Category ID or null if not found
     */
    public static function getFromFormatName(string $formatName): ?int
    {
        $map = array_flip(self::getDescriptionMap());
        return $map[$formatName] ?? null;
    }
}