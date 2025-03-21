<?php

namespace ameax\DatevExtf\Enums;

final class PostingType
{
    public const REQUESTED_ADVANCE = 'AA'; // Angeforderte Anzahlung / Abschlagsrechnung
    public const RECEIVED_ADVANCE_MONEY = 'AG'; // Erhaltene Anzahlung (Geldeingang)
    public const RECEIVED_ADVANCE_LIABILITY = 'AV'; // Erhaltene Anzahlung (Verbindlichkeit)
    public const FINAL_INVOICE = 'SR'; // Schlussrechnung
    public const FINAL_INVOICE_REBOOKING = 'SU'; // Schlussrechnung (Umbuchung)
    public const FINAL_INVOICE_MONEY = 'SG'; // Schlussrechnung (Geldeingang)
    public const OTHER = 'SO'; // Sonstige

    /**
     * Get all valid values
     *
     * @return array Valid posting types
     */
    public static function getValidValues(): array
    {
        return [
            self::REQUESTED_ADVANCE,
            self::RECEIVED_ADVANCE_MONEY,
            self::RECEIVED_ADVANCE_LIABILITY,
            self::FINAL_INVOICE,
            self::FINAL_INVOICE_REBOOKING,
            self::FINAL_INVOICE_MONEY,
            self::OTHER
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