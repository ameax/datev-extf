# DATEV Export-Format (EXTF) PHP Library

Eine PHP-Bibliothek für die Erstellung von Datendateien im DATEV Export-Format (EXTF).

## Features

- Unterstützung für Buchungsstapel (Transaktionen)
- Unterstützung für Debitoren/Kreditoren (Stammdaten)
- Typgerechte Datenkonvertierung gemäß DATEV-Format
- PHP 7.x kompatibel
- Unterstützung für Gleitkommazahlen (float)
- Unterstützung für DateTime-Objekte für alle Datumsfelder

## Installation

```bash
composer require ameax/datev-extf
```

## Beispiel: Buchungsstapel

```php
<?php
use ameax\DatevExtf\DatevExtfWriter;
use ameax\DatevExtf\DatevExtfWriterEntry;
use ameax\DatevExtf\Enums\DebitCreditIndicator;
use ameax\DatevExtf\Enums\FormatName;

// Writer mit Formattyp initialisieren
$writer = new DatevExtfWriter(FormatName::BUCHUNGSSTAPEL);

// Header konfigurieren
$writer->getHeader()->fromArray([
    'consultant_number' => 12345,
    'client_number' => 67890,
    'fiscal_year_start' => new \DateTime('2023-01-01'),
    'date_from' => new \DateTime('2023-01-01'),
    'date_to' => new \DateTime('2023-12-31'),
    'description' => 'Monatliche Buchungen'
]);

// Buchungseintrag erstellen 
$entry = new DatevExtfWriterEntry();
$entry->fromArray([
    'amount' => 1200.00,                              // Gleitkommazahl
    'debit_credit_indicator' => DebitCreditIndicator::DEBIT,
    'account' => '8400',
    'contra_account' => '1800',
    'document_date' => new \DateTime('2023-05-15'),   // DateTime-Objekt
    'document_field_1' => 'RE-2023-123',
    'posting_text' => 'Software Einkauf',
    'tax_rate' => 19.00,                              // Gleitkommazahl
    'due_date' => new \DateTime('2023-06-15')         // DateTime-Objekt
]);

// Eintrag zum Writer hinzufügen
$writer->addEntry($entry);

// Datei generieren
$writer->generateFile('buchungsstapel_export.csv');
```

## Beispiel: Debitoren/Kreditoren

```php
<?php
use ameax\DatevExtf\DatevExtfWriter;
use ameax\DatevExtf\DatevExtfWriterParty;
use ameax\DatevExtf\Enums\PartyType;
use ameax\DatevExtf\Enums\AddressType;
use ameax\DatevExtf\Enums\FormatName;

// Writer für Debitoren/Kreditoren initialisieren
$writer = new DatevExtfWriter(FormatName::DEBITOREN_KREDITOREN);

// Header konfigurieren
$writer->getHeader()->fromArray([
    'consultant_number' => 12345,
    'client_number' => 67890,
    'description' => 'Stammdaten Export'
]);

// Kontakt erstellen
$party = new DatevExtfWriterParty();
$party->fromArray([
    'account_number' => '10000',
    'company_name' => 'Muster GmbH',
    'party_type' => PartyType::COMPANY,
    'address_type' => AddressType::STREET,
    'street' => 'Musterstraße 123',
    'postal_code' => '12345',
    'city' => 'Berlin',
    'country' => 'DE',
    'credit_limit' => 5000.50,                           // Gleitkommazahl
    'address_valid_from' => new \DateTime('2023-01-01'), // DateTime-Objekt
    'address_valid_until' => new \DateTime('2027-12-31') // DateTime-Objekt
]);

// Kontakt zum Writer hinzufügen
$writer->addEntry($party);

// Datei generieren
$writer->generateFile('debitoren_kreditoren_export.csv');
```

## Datumsfelder (DateTime)

Alle Datumsfelder akzeptieren jetzt `DateTime`-Objekte und werden automatisch in das entsprechende DATEV-Format konvertiert:

### Buchungsstapel (DatevExtfWriterEntry)
- document_date (Format: TTMM)
- assigned_due_date (Format: TTMMJJJJ)
- cost_date (Format: TTMMJJJJ)
- posting_lock_until (Format: TTMMJJJJ)
- service_date (Format: TTMMJJJJ)
- tax_period_date (Format: TTMMJJJJ)
- due_date (Format: TTMMJJJJ)

### Debitoren/Kreditoren (DatevExtfWriterParty)
- address_valid_from (Format: TTMMJJJJ)
- address_valid_until (Format: TTMMJJJJ)
- reminder_block_until (Format: TTMMJJJJ)
- bank_valid_from_1 bis bank_valid_from_10 (Format: TTMMJJJJ)
- bank_valid_until_1 bis bank_valid_until_10 (Format: TTMMJJJJ)
- direct_debit_block_until (Format: TTMMJJJJ)
- payment_block_until (Format: TTMMJJJJ)

### Header (DatevExtfHeader)
- created_at (Format: YYYYMMDDHHMMSSFFF)
- fiscal_year_start (Format: YYYYMMDD)
- date_from (Format: YYYYMMDD)
- date_to (Format: YYYYMMDD)

## Gleitkommazahlen (Float)

Zahlreiche numerische Felder akzeptieren jetzt `float`-Werte und werden automatisch in das entsprechende DATEV-Format mit Komma als Dezimaltrennzeichen konvertiert.

## Lizenz

MIT 