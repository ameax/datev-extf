<?php

namespace ameax\DatevExtf\Enums;

final class BookingType
{
    public const FIBU = 1;     // Finanzbuchhaltung
    public const FINANZAMT = 2; // Finanzamtmeldungen (EÜR/UStVA)

    /**
     * Map of booking types to their descriptions
     *
     * @return array Map of booking type to description
     */
    public static function getDescriptionMap(): array
    {
        return [
            self::FIBU => 'Finanzbuchhaltung',
            self::FINANZAMT => 'Finanzamtmeldungen (EÜR/UStVA)'
        ];
    }

    /**
     * Get all valid values
     *
     * @return array Valid booking types
     */
    public static function getValidValues(): array
    {
        return array_keys(self::getDescriptionMap());
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
     * Get the description for a booking type
     *
     * @param int $bookingType The booking type
     * @return string|null The description or null if not found
     */
    public static function getDescription(int $bookingType): ?string
    {
        return self::getDescriptionMap()[$bookingType] ?? null;
    }
}