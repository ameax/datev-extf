<?php

namespace ameax\DatevExtf\Enums;

/**
 * Enum for DATEV BVV positions (Betriebsvermögensvergleich)
 */
final class BvvPosition
{
    public const CAPITAL_ADJUSTMENT = '1'; // Kapitalanpassung
    public const WITHDRAWAL_DISTRIBUTION = '2'; // Entnahme / Ausschüttung lfd. WJ
    public const DEPOSIT_CAPITAL_INFUSION = '3'; // Einlage / Kapitalzuführung lfd. WJ
    public const TRANSFER_RESERVE = '4'; // Übertragung § 6b Rücklage
    public const REBOOKING = '5'; // Umbuchung (keine Zuordnung)

    /**
     * Map of BVV positions to their descriptions
     *
     * @return array Map of BVV position to description
     */
    public static function getDescriptionMap(): array
    {
        return [
            self::CAPITAL_ADJUSTMENT => 'Kapitalanpassung',
            self::WITHDRAWAL_DISTRIBUTION => 'Entnahme / Ausschüttung lfd. WJ',
            self::DEPOSIT_CAPITAL_INFUSION => 'Einlage / Kapitalzuführung lfd. WJ',
            self::TRANSFER_RESERVE => 'Übertragung § 6b Rücklage',
            self::REBOOKING => 'Umbuchung (keine Zuordnung)'
        ];
    }

    /**
     * Get all valid values
     *
     * @return array Valid BVV positions
     */
    public static function getValidValues(): array
    {
        return array_keys(self::getDescriptionMap());
    }

    /**
     * Get the description for a BVV position
     *
     * @param string $position The BVV position
     * @return string|null The description or null if not found
     */
    public static function getDescription(string $position): ?string
    {
        return self::getDescriptionMap()[$position] ?? null;
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