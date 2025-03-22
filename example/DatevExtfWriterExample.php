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

/**
 * Hinweis: Um dieses Beispiel mit statischen make()-Methoden zu nutzen,
 * müssten die folgenden Methoden zu den jeweiligen Klassen hinzugefügt werden:
 *
 * In der DatevExtfWriterEntry-Klasse:
 * ```php
 * public static function make(): self
 * {
 *     return new self();
 * }
 * ```
 *
 * In der DatevExtfWriterParty-Klasse:
 * ```php
 * public static function make(): self
 * {
 *     return new self();
 * }
 * ```
 */

// Example 1: Creating a transaction batch file (Buchungsstapel)
function createTransactionBatchExample()
{
    // Create the main writer with static factory method
    $writer = DatevExtfWriter::make(FormatName::BUCHUNGSSTAPEL);

    // Get the header object and configure it
    $writer->getHeader()
        ->setConsultantNumber(12345)       // Beraternummer
        ->setClientNumber(67890)           // Mandantennummer
        ->setFiscalYearStart(new \DateTime('2025-01-01')) // WJ-Beginn
        ->setAccountLength(4)              // Sachkontenlänge
        ->setDateFrom(new \DateTime('2025-01-01'))  // Datum von
        ->setDateTo(new \DateTime('2025-12-31'))    // Datum bis
        ->setDescription('API Export')     // Bezeichnung
        ->setCurrency(Currency::EUR)       // Währung
        ->setBookingType(BookingType::FIBU) // Buchungstyp (Standard)
        ->setAccountFramework(AccountFramework::SKR03); // Kontenrahmen

    // Add entries with a fluent interface using make() static factory method
    $writer->addEntry(DatevExtfWriterEntry::make()
        ->setAmount(1200.00)
        ->setDebitCreditIndicator(DebitCreditIndicator::DEBIT)
        ->setAccount('10123')
        ->setContraAccount('8400')
        ->setDocumentDate(new \DateTime('2025-05-03'))
        ->setDocumentField1('RE-2025-123')
        ->setPostingText('Software Verkauf')
        ->setTaxRate(19.00)
        ->setCountry('DE')
    );

    $writer->addEntry(DatevExtfWriterEntry::make()
        ->setAmount(500.00)
        ->setDebitCreditIndicator(DebitCreditIndicator::DEBIT)
        ->setAccount('10124')
        ->setContraAccount('8400')
        ->setDocumentDate(new \DateTime('2025-05-10'))
        ->setDocumentField1('RE-2025-124')
        ->setPostingText('Büromaterial Verkauf')
        ->setTaxRate(19.00)
        ->setCountry('DE')
    );

    $writer->addEntry(DatevExtfWriterEntry::make()
        ->setAmount(750.00)
        ->setDebitCreditIndicator(DebitCreditIndicator::DEBIT)
        ->setAccount('10125')
        ->setContraAccount('8400')
        ->setDocumentDate(new \DateTime('2025-06-15'))
        ->setDocumentField1('RE-2025-125')
        ->setPostingText('Raumvermietung')
        ->setTaxRate(19.00)
        ->setAssignedDueDate(new \DateTime('2025-07-15'))
        ->setServiceDate(new \DateTime('2025-06-01'))
        ->setDueDate(new \DateTime('2025-07-01'))
        ->setCountry('DE')
    );

    // Generate the file
    $writer->generateFile('buchungsstapel_export.csv');

    echo "Transaction batch file created: buchungsstapel_export.csv\n";
}

// Example 2: Creating a party file (Debitoren/Kreditoren)
function createPartyExample()
{
    // Create the main writer for parties with fluent interface
    $writer = DatevExtfWriter::make(FormatName::DEBITOREN_KREDITOREN);

    // Configure header with fluent interface
    $writer->getHeader()
        ->setConsultantNumber(12345)
        ->setClientNumber(67890)
        ->setFiscalYearStart(new \DateTime('2025-01-01'))
        ->setAccountLength(4)
        ->setDateFrom(new \DateTime('2025-01-01'))
        ->setDateTo(new \DateTime('2025-12-31'))
        ->setDescription('Kontakte Export')
        ->setAccountFramework(AccountFramework::SKR03);

    // Add parties with fluent interface
    $writer->addEntry(DatevExtfWriterParty::make()
        ->setAccountNumber('10126')
        ->setCompanyName('ACME Software GmbH')
        ->setBusinessPurpose('Software Development')
        ->setPartyType(PartyType::COMPANY)
        ->setShortName('ACME')
        ->setAddressType(AddressType::STREET)
        ->setStreet('Hauptstraße 123')
        ->setPostalCode('10115')
        ->setCity('Berlin')
        ->setCountry('DE')
        ->setEmail('info@acme-software.de')
        ->setPhone('030 123456789')
        ->setWebsite('www.acme-software.de')
        ->setEuCountry('DE')
        ->setEuVatId('123456789')
    );

    $writer->addEntry(DatevExtfWriterParty::make()
        ->setAccountNumber('10127')
        ->setPersonLastName('Schmidt')
        ->setPersonFirstName('Thomas')
        ->setPartyType(PartyType::NATURAL_PERSON)
        ->setSalutation('Herr')
        ->setTitle('Dr.')
        ->setAddressType(AddressType::STREET)
        ->setStreet('Musterstraße 45')
        ->setPostalCode('80331')
        ->setCity('München')
        ->setCountry('DE')
        ->setEmail('thomas.schmidt@example.com')
        ->setPhone('089 987654321')
        ->setLanguage(Language::GERMAN)
    );

    $writer->addEntry(DatevExtfWriterParty::make()
        ->setAccountNumber('10128')
        ->setCompanyName('Float Test GmbH')
        ->setPartyType(PartyType::COMPANY)
        ->setAddressType(AddressType::STREET)
        ->setStreet('Teststraße 123')
        ->setPostalCode('40123')
        ->setCity('Düsseldorf')
        ->setCountry('DE')
        // Float values example
        ->setCreditLimit(5000.00)
        ->setDebtorDiscountPercent(2.5)
        ->setCreditorDiscount1Percent(3.0)
        ->setInterestRate1(5.75)
        // Date values example
        ->setAddressValidFrom(new \DateTime('2025-01-01'))
        ->setAddressValidUntil(new \DateTime('2029-12-31'))
        ->setBankValidFrom1(new \DateTime('2025-01-01'))
        ->setBankValidUntil1(new \DateTime('2029-12-31'))
        ->setReminderBlockUntil(new \DateTime('2025-12-31'))
    );

    // Generate the file
    $writer->generateFile('debitoren_kreditoren_export.csv');

    echo "Party file created: debitoren_kreditoren_export.csv\n";
}

// Run the examples
createTransactionBatchExample();
createPartyExample();