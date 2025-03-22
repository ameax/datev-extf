<?php

use ameax\DatevExtf\DatevExtfWriter;
use ameax\DatevExtf\DatevExtfWriterEntry;
use ameax\DatevExtf\Enums\AccountFramework;
use ameax\DatevExtf\Enums\BookingType;
use ameax\DatevExtf\Enums\Currency;
use ameax\DatevExtf\Enums\DebitCreditIndicator;
use ameax\DatevExtf\Enums\FormatName;

it('returns generates a string', function () {
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

    $string = $writer->build();

    expect($string)->toBeString();
});