<?php

require_once 'vendor/autoload.php';

use ameax\DatevExtf\DatevExtfWriter;
use ameax\DatevExtf\DatevExtfWriterEntry;
use ameax\DatevExtf\DatevExtfWriterParty;
use ameax\DatevExtf\Enums\FormatName;
use ameax\DatevExtf\Enums\AccountFramework;
use ameax\DatevExtf\Enums\BookingType;
use ameax\DatevExtf\Enums\Currency;
use ameax\DatevExtf\Enums\PartyType;
use ameax\DatevExtf\Enums\AddressType;
use ameax\DatevExtf\Enums\DebitCreditIndicator;
use ameax\DatevExtf\Enums\Language;

// Example 1: Creating a transaction batch file (Buchungsstapel)
function createTransactionBatchExample()
{
    // Create the main writer
    $writer = new DatevExtfWriter(FormatName::BUCHUNGSSTAPEL);

    // Get the header object and configure it
    $header = $writer->getHeader();
    $header->fromArray([
        'consultant_number' => 12345,        // Beraternummer
        'client_number' => 67890,            // Mandantennummer
        'fiscal_year_start' => new \DateTime('2025-01-01'), // WJ-Beginn
        'account_length' => 4,               // Sachkontenlänge
        'date_from' => new \DateTime('2025-01-01'),  // Datum von
        'date_to' => new \DateTime('2025-12-31'),    // Datum bis
        'description' => 'API Export',        // Bezeichnung
        'currency' => Currency::EUR,          // Währung
        'booking_type' => BookingType::FIBU,  // Buchungstyp (Standard)
        'account_framework' => AccountFramework::SKR04 // Kontenrahmen
    ]);

    // Create and add the first transaction entry
    $entry1 = new DatevExtfWriterEntry();
    $entry1->fromArray([
        'amount' => 1200.00,
        'debit_credit_indicator' => DebitCreditIndicator::DEBIT,
        'account' => '8400',
        'contra_account' => '1800',
        'document_date' => new \DateTime('2025-05-03'),      // May 3rd 
        'document_field_1' => 'RE-2025-123',
        'posting_text' => 'Software purchase',
        'tax_rate' => 19.00,
        'country' => 'DE'
    ]);
    $writer->addEntry($entry1);

    // Create and add the second transaction entry
    $entry2 = new DatevExtfWriterEntry();
    $entry2->fromArray([
        'amount' => 500.00,
        'debit_credit_indicator' => DebitCreditIndicator::DEBIT,
        'account' => '4400',
        'contra_account' => '1800',
        'document_date' => new \DateTime('2025-05-10'),      // May 10th
        'document_field_1' => 'RE-2025-124',
        'posting_text' => 'Office supplies',
        'tax_rate' => 19.00,
        'country' => 'DE'
    ]);
    $writer->addEntry($entry2);

    // Create an entry with additional date fields
    $entryWithDates = new DatevExtfWriterEntry();
    $entryWithDates->fromArray([
        'amount' => 750.00,
        'debit_credit_indicator' => DebitCreditIndicator::DEBIT,
        'account' => '6300',
        'contra_account' => '1800',
        'document_date' => new \DateTime('2025-06-15'),
        'document_field_1' => 'RE-2025-125',
        'posting_text' => 'Office rent',
        'tax_rate' => 19.00,
        'assigned_due_date' => new \DateTime('2025-07-15'),
        'service_date' => new \DateTime('2025-06-01'),
        'due_date' => new \DateTime('2025-07-01'),
        'country' => 'DE'
    ]);
    $writer->addEntry($entryWithDates);

    // Generate the file
    $writer->generateFile('buchungsstapel_export.csv');

    echo "Transaction batch file created: buchungsstapel_export.csv\n";
}

// Example 2: Creating a party file (Debitoren/Kreditoren)
function createPartyExample()
{
    // Create the main writer for parties
    $writer = new DatevExtfWriter(FormatName::DEBITOREN_KREDITOREN);

    // Get the header object and configure it
    $header = $writer->getHeader();
    $header->fromArray([
        'consultant_number' => 12345,        // Beraternummer
        'client_number' => 67890,            // Mandantennummer
        'fiscal_year_start' => new \DateTime('2025-01-01'), // WJ-Beginn
        'account_length' => 4,               // Sachkontenlänge
        'date_from' => new \DateTime('2025-01-01'),  // Datum von
        'date_to' => new \DateTime('2025-12-31'),    // Datum bis
        'description' => 'Kontakte Export',   // Bezeichnung
        'account_framework' => AccountFramework::SKR04 // Kontenrahmen
    ]);

    // Create and add the first party (a company)
    $party1 = new DatevExtfWriterParty();
    $party1->fromArray([
        'account_number' => '10000',
        'company_name' => 'ACME Software GmbH',
        'business_purpose' => 'Software Development',
        'party_type' => PartyType::COMPANY,    // Company
        'short_name' => 'ACME',
        'address_type' => AddressType::STREET, // Street address
        'street' => 'Hauptstraße 123',
        'postal_code' => '10115',
        'city' => 'Berlin',
        'country' => 'DE',                     // Germany
        'email' => 'info@acme-software.de',
        'phone' => '030 123456789',
        'website' => 'www.acme-software.de',
        'eu_country' => 'DE',
        'eu_vat_id' => '123456789'
    ]);
    $writer->addEntry($party1);

    // Create and add the second party (a person)
    $party2 = new DatevExtfWriterParty();
    $party2->fromArray([
        'account_number' => '70001',
        'person_last_name' => 'Schmidt',
        'person_first_name' => 'Thomas',
        'party_type' => PartyType::NATURAL_PERSON, // Natural person
        'salutation' => 'Herr',
        'title' => 'Dr.',
        'address_type' => AddressType::STREET,     // Street address
        'street' => 'Musterstraße 45',
        'postal_code' => '80331',
        'city' => 'München',
        'country' => 'DE',                         // Germany
        'email' => 'thomas.schmidt@example.com',
        'phone' => '089 987654321',
        'language' => Language::GERMAN
    ]);
    $writer->addEntry($party2);

    // Create and add examples with float values and dates
    $partyWithFloats = new DatevExtfWriterParty();
    $partyWithFloats->fromArray([
        'account_number' => '80001',
        'company_name' => 'Float Test GmbH',
        'party_type' => PartyType::COMPANY,
        'address_type' => AddressType::STREET,
        'street' => 'Teststraße 123',
        'postal_code' => '40123',
        'city' => 'Düsseldorf',
        'country' => 'DE',
        // Float values example
        'credit_limit' => 5000.00,
        'debtor_discount_percent' => 2.5,
        'creditor_discount_1_percent' => 3.0,
        'interest_rate_1' => 5.75,
        // Date values example
        'address_valid_from' => new \DateTime('2025-01-01'),
        'address_valid_until' => new \DateTime('2029-12-31'),
        'bank_valid_from_1' => new \DateTime('2025-01-01'),
        'bank_valid_until_1' => new \DateTime('2029-12-31'),
        'reminder_block_until' => new \DateTime('2025-12-31')
    ]);
    $writer->addEntry($partyWithFloats);

    // Generate the file
    $writer->generateFile('debitoren_kreditoren_export.csv');

    echo "Party file created: debitoren_kreditoren_export.csv\n";
}

// Run the examples
createTransactionBatchExample();
createPartyExample();