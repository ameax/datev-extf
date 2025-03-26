# DATEV Export-Format (EXTF) PHP Library

Eine PHP-Bibliothek für die Erstellung von Datendateien im DATEV Export-Format (EXTF).

[English version below](#datev-export-format-extf-php-library-english)

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
$writer = DatevExtfWriter::make(FormatName::BUCHUNGSSTAPEL);

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

// Verschiedene Ausgabemöglichkeiten:

// 1. Als String erhalten
$content = $writer->toString();

// 2. In Datei speichern
try {
    $writer->saveTo('buchungsstapel_export.csv');
} catch (\RuntimeException $e) {
    // Fehlerbehandlung
    echo "Fehler beim Speichern: " . $e->getMessage();
}

// 3. Datei herunterladen
$writer->download('buchungsstapel_export.csv');

// 4. Inhalt streamen
$writer->stream();
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
$writer = DatevExtfWriter::make(FormatName::DEBITOREN_KREDITOREN);

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

// Verschiedene Ausgabemöglichkeiten:

// 1. Als String erhalten
$content = $writer->toString();

// 2. In Datei speichern
try {
    $writer->saveTo('debitoren_kreditoren_export.csv');
} catch (\RuntimeException $e) {
    // Fehlerbehandlung
    echo "Fehler beim Speichern: " . $e->getMessage();
}

// 3. Datei herunterladen
$writer->download('debitoren_kreditoren_export.csv');

// 4. Inhalt streamen
$writer->stream();
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

## Verwandte Projekte

### DATEV XML Format

Wir bieten auch eine Bibliothek zur Erstellung von DATEV XML-Dokumenten an: [ameax/datev-xml](https://github.com/ameax/datev-xml)

Diese Bibliothek ermöglicht:
- Generierung von DATEV XML-Dateien nach DATEV-Standard
- Erstellung von Forderungsbuchungssätzen
- Erstellen von ZIP-Dateien für den direkten Import in DATEV
- Hinzufügen von SEPA-Dateien zu Dokumenten

#### Beispiel: DATEV XML

```php
use Ameax\Datev\DataObjects\DatevAccountLedgerData;
use Ameax\Datev\DataObjects\DatevDocumentData;
use Ameax\Datev\DataObjects\DatevRepositoryData;
use Ameax\Datev\Zip;
use Carbon\Carbon;

$datevDocumentData = new DatevDocumentData();

$ledgerData = new DatevAccountLedgerData(
    consolidatedDate: new Carbon('2023-06-14'),
    consolidatedDeliveryDate: new Carbon('2023-06-14'),
    consolidatedInvoiceId: 'RE12345',
    customerName: 'ARANES',
    customerCity: 'Aufhausen',
    shipFromCountry: 'DE',
    accountName: 'ARANES Aufhausen',
    dueDate: new Carbon('2023-07-01'),
    bpAccountNo: '12345'
);
$ledgerData->addAccountsReceivableLedger(
    amount: 119.00,
    accountNo: '8400',
    information: 'Software',
    bookingText: 'Umsatz 19%'
);
$ledgerData->addAccountsReceivableLedger(
    amount: 214.00,
    accountNo: '8300',
    information: 'Bücher',
    bookingText: 'Umsatz 7%'
);

$datevDocumentData->buildAccountsReceivableLedger(
    datevAccountLedgerData: $ledgerData,
    filePaths: ['path-to-invoice.pdf']
);

$datevRepositoryData = new DatevRepositoryData();

$datevDocumentData->addSEPAFile(
    nameWithExtension: 'sepa-2023-12345.xml',
    filePath: 'path-to-sepafile.xml',
    date: new Carbon('2023-05-01'),
    datevRepositoryData: $datevRepositoryData
);

$zipPath = $datevDocumentData->generateZip();
```

---

<a name="datev-export-format-extf-php-library-english"></a>
# DATEV Export-Format (EXTF) PHP Library (English)

A PHP library for creating data files in DATEV Export-Format (EXTF).

## Features

- Support for booking batches (transactions)
- Support for debtors/creditors (master data)
- Type-appropriate data conversion according to DATEV format
- PHP 7.x compatible
- Support for floating point numbers (float)
- Support for DateTime objects for all date fields

## Installation

```bash
composer require ameax/datev-extf
```

## Example: Booking Batch

```php
<?php
use ameax\DatevExtf\DatevExtfWriter;
use ameax\DatevExtf\DatevExtfWriterEntry;
use ameax\DatevExtf\Enums\DebitCreditIndicator;
use ameax\DatevExtf\Enums\FormatName;

// Initialize writer with format type
$writer = DatevExtfWriter::make(FormatName::BUCHUNGSSTAPEL);

// Configure header
$writer->getHeader()->fromArray([
    'consultant_number' => 12345,
    'client_number' => 67890,
    'fiscal_year_start' => new \DateTime('2023-01-01'),
    'date_from' => new \DateTime('2023-01-01'),
    'date_to' => new \DateTime('2023-12-31'),
    'description' => 'Monthly Bookings'
]);

// Create booking entry
$entry = new DatevExtfWriterEntry();
$entry->fromArray([
    'amount' => 1200.00,                              // Floating point number
    'debit_credit_indicator' => DebitCreditIndicator::DEBIT,
    'account' => '8400',
    'contra_account' => '1800',
    'document_date' => new \DateTime('2023-05-15'),   // DateTime object
    'document_field_1' => 'RE-2023-123',
    'posting_text' => 'Software Purchase',
    'tax_rate' => 19.00,                              // Floating point number
    'due_date' => new \DateTime('2023-06-15')         // DateTime object
]);

// Add entry to writer
$writer->addEntry($entry);

// Different output options:

// 1. Get as string
$content = $writer->toString();

// 2. Save to file
try {
    $writer->saveTo('booking_batch_export.csv');
} catch (\RuntimeException $e) {
    // Error handling
    echo "Error saving file: " . $e->getMessage();
}

// 3. Download file
$writer->download('booking_batch_export.csv');

// 4. Stream content
$writer->stream();
```

## Example: Debtors/Creditors

```php
<?php
use ameax\DatevExtf\DatevExtfWriter;
use ameax\DatevExtf\DatevExtfWriterParty;
use ameax\DatevExtf\Enums\PartyType;
use ameax\DatevExtf\Enums\AddressType;
use ameax\DatevExtf\Enums\FormatName;

// Initialize writer for debtors/creditors
$writer = DatevExtfWriter::make(FormatName::DEBITOREN_KREDITOREN);

// Configure header
$writer->getHeader()->fromArray([
    'consultant_number' => 12345,
    'client_number' => 67890,
    'description' => 'Master Data Export'
]);

// Create contact
$party = new DatevExtfWriterParty();
$party->fromArray([
    'account_number' => '10000',
    'company_name' => 'Sample Ltd',
    'party_type' => PartyType::COMPANY,
    'address_type' => AddressType::STREET,
    'street' => 'Sample Street 123',
    'postal_code' => '12345',
    'city' => 'Berlin',
    'country' => 'DE',
    'credit_limit' => 5000.50,                           // Floating point number
    'address_valid_from' => new \DateTime('2023-01-01'), // DateTime object
    'address_valid_until' => new \DateTime('2027-12-31') // DateTime object
]);

// Add contact to writer
$writer->addEntry($party);

// Different output options:

// 1. Get as string
$content = $writer->toString();

// 2. Save to file
try {
    $writer->saveTo('debtors_creditors_export.csv');
} catch (\RuntimeException $e) {
    // Error handling
    echo "Error saving file: " . $e->getMessage();
}

// 3. Download file
$writer->download('debtors_creditors_export.csv');

// 4. Stream content
$writer->stream();
```

## Date Fields (DateTime)

All date fields now accept `DateTime` objects and are automatically converted to the corresponding DATEV format:

### Booking Batch (DatevExtfWriterEntry)
- document_date (Format: DDMM)
- assigned_due_date (Format: DDMMYYYY)
- cost_date (Format: DDMMYYYY)
- posting_lock_until (Format: DDMMYYYY)
- service_date (Format: DDMMYYYY)
- tax_period_date (Format: DDMMYYYY)
- due_date (Format: DDMMYYYY)

### Debtors/Creditors (DatevExtfWriterParty)
- address_valid_from (Format: DDMMYYYY)
- address_valid_until (Format: DDMMYYYY)
- reminder_block_until (Format: DDMMYYYY)
- bank_valid_from_1 to bank_valid_from_10 (Format: DDMMYYYY)
- bank_valid_until_1 to bank_valid_until_10 (Format: DDMMYYYY)
- direct_debit_block_until (Format: DDMMYYYY)
- payment_block_until (Format: DDMMYYYY)

### Header (DatevExtfHeader)
- created_at (Format: YYYYMMDDHHMMSSFFF)
- fiscal_year_start (Format: YYYYMMDD)
- date_from (Format: YYYYMMDD)
- date_to (Format: YYYYMMDD)

## Floating Point Numbers (Float)

Numerous numeric fields now accept `float` values and are automatically converted to the corresponding DATEV format with comma as decimal separator.

## Related Projects

### DATEV XML Format

We also offer a library for creating DATEV XML documents: [ameax/datev-xml](https://github.com/ameax/datev-xml)

This library enables:
- Generation of DATEV XML files according to DATEV standard
- Creation of accounts receivable ledger entries
- Creation of ZIP files for direct import into DATEV
- Adding SEPA files to documents

#### Example: DATEV XML

```php
use Ameax\Datev\DataObjects\DatevAccountLedgerData;
use Ameax\Datev\DataObjects\DatevDocumentData;
use Ameax\Datev\DataObjects\DatevRepositoryData;
use Ameax\Datev\Zip;
use Carbon\Carbon;

$datevDocumentData = new DatevDocumentData();

$ledgerData = new DatevAccountLedgerData(
    consolidatedDate: new Carbon('2023-06-14'),
    consolidatedDeliveryDate: new Carbon('2023-06-14'),
    consolidatedInvoiceId: 'RE12345',
    customerName: 'ARANES',
    customerCity: 'Aufhausen',
    shipFromCountry: 'DE',
    accountName: 'ARANES Aufhausen',
    dueDate: new Carbon('2023-07-01'),
    bpAccountNo: '12345'
);
$ledgerData->addAccountsReceivableLedger(
    amount: 119.00,
    accountNo: '8400',
    information: 'Software',
    bookingText: 'Revenue 19%'
);
$ledgerData->addAccountsReceivableLedger(
    amount: 214.00,
    accountNo: '8300',
    information: 'Books',
    bookingText: 'Revenue 7%'
);

$datevDocumentData->buildAccountsReceivableLedger(
    datevAccountLedgerData: $ledgerData,
    filePaths: ['path-to-invoice.pdf']
);

$datevRepositoryData = new DatevRepositoryData();

$datevDocumentData->addSEPAFile(
    nameWithExtension: 'sepa-2023-12345.xml',
    filePath: 'path-to-sepafile.xml',
    date: new Carbon('2023-05-01'),
    datevRepositoryData: $datevRepositoryData
);

$zipPath = $datevDocumentData->generateZip();
```

---

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Michael Schmidt](https://github.com/ameax)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
