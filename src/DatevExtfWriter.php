<?php

namespace ameax\DatevExtf;

use ameax\DatevExtf\Enums\FormatName;
use ameax\DatevExtf\Enums\FormatCategory;
use ameax\DatevExtf\Enums\FormatVersion;
use ameax\DatevExtf\Enums\FormatIdentifier;
use ameax\DatevExtf\Enums\BookingType;

class DatevExtfWriter
{
    protected DatevExtfHeader $header;
    protected array $entries = [];
    protected string $formatName;

    /**
     * Statische Factory-Methode für Fluent Interface
     * 
     * @param string $formatName Type of data (e.g., 'Buchungsstapel', 'Debitoren/Kreditoren')
     * @return self
     */
    public static function make(string $formatName = FormatName::BUCHUNGSSTAPEL): self
    {
        return new self($formatName);
    }

    /**
     * Constructor
     *
     * @param string $formatName Type of data (e.g., 'Buchungsstapel', 'Debitoren/Kreditoren')
     */
    public function __construct(string $formatName = FormatName::BUCHUNGSSTAPEL)
    {
        if (!FormatName::isValid($formatName)) {
            throw new \InvalidArgumentException("Unsupported format name: $formatName");
        }

        $this->formatName = $formatName;
        $this->header = new DatevExtfHeader();
        $this->initializeHeader();
    }

    /**
     * Initialize the header with default values specific to dataType
     */
    protected function initializeHeader(): void
    {
        // Set format name, which automatically sets the appropriate format category and version
        $this->header->setFormatName($this->formatName);

        // Set origin
        $this->header->fromArray([
            'origin' => 'RE',  // API/Service Source
            'exported_by' => 'DatevExtfWriter'
        ]);
    }

    /**
     * Get access to the header object
     *
     * @return DatevExtfHeader The header object
     */
    public function getHeader(): DatevExtfHeader
    {
        return $this->header;
    }

    /**
     * Add an entry to the export
     *
     * @param object $entry Entry object (DatevExtfWriterEntry or DatevExtfWriterParty)
     * @return $this For chaining
     */
    public function addEntry(object $entry): self
    {
        // Type checking based on format name
        if ($this->formatName === FormatName::BUCHUNGSSTAPEL && !($entry instanceof DatevExtfWriterEntry)) {
            throw new \InvalidArgumentException('For Buchungsstapel, entries must be DatevExtfWriterEntry objects');
        }

        if ($this->formatName === FormatName::DEBITOREN_KREDITOREN && !($entry instanceof DatevExtfWriterParty)) {
            throw new \InvalidArgumentException('For Debitoren/Kreditoren, entries must be DatevExtfWriterParty objects');
        }

        $this->entries[] = $entry;
        return $this;
    }

    /**
     * Add multiple entries at once
     *
     * @param array $entries Array of entry objects
     * @return $this For chaining
     */
    public function addEntries(array $entries): self
    {
        foreach ($entries as $entry) {
            $this->addEntry($entry);
        }
        return $this;
    }

    /**
     * Build the column header line for the export
     *
     * @return string Formatted column header line
     */
    protected function buildColumnHeader(): string
    {
        // Get the column headers based on format name
        if ($this->formatName === FormatName::BUCHUNGSSTAPEL) {
            return "Umsatz (ohne Soll/Haben-Kz);Soll/Haben-Kennzeichen;WKZ Umsatz;Kurs;Basis-Umsatz;WKZ Basis-Umsatz;Konto;Gegenkonto (ohne BU-Schlüssel);BU-Schlüssel;Belegdatum;Belegfeld 1;Belegfeld 2;Skonto;Buchungstext;Postensperre;Diverse Adressnummer;Geschäftspartnerbank;Sachverhalt;Zinssperre;Beleglink;Beleginfo - Art 1;Beleginfo - Inhalt 1;Beleginfo - Art 2;Beleginfo - Inhalt 2;Beleginfo - Art 3;Beleginfo - Inhalt 3;Beleginfo - Art 4;Beleginfo - Inhalt 4;Beleginfo - Art 5;Beleginfo - Inhalt 5;Beleginfo - Art 6;Beleginfo - Inhalt 6;Beleginfo - Art 7;Beleginfo - Inhalt 7;Beleginfo - Art 8;Beleginfo - Inhalt 8;KOST1 - Kostenstelle;KOST2 - Kostenstelle;Kost-Menge;EU-Land u. UStID;EU-Steuersatz;Abw. Versteuerungsart;Sachverhalt L+L;Funktionsergänzung L+L;BU 49 Hauptfunktionstyp;BU 49 Hauptfunktionsnummer;BU 49 Funktionsergänzung;Zusatzinformation - Art 1;Zusatzinformation - Inhalt 1;Zusatzinformation - Art 2;Zusatzinformation - Inhalt 2;Zusatzinformation - Art 3;Zusatzinformation - Inhalt 3;Zusatzinformation - Art 4;Zusatzinformation - Inhalt 4;Zusatzinformation - Art 5;Zusatzinformation - Inhalt 5;Zusatzinformation - Art 6;Zusatzinformation - Inhalt 6;Zusatzinformation - Art 7;Zusatzinformation - Inhalt 7;Zusatzinformation - Art 8;Zusatzinformation - Inhalt 8;Zusatzinformation - Art 9;Zusatzinformation - Inhalt 9;Zusatzinformation - Art 10;Zusatzinformation - Inhalt 10;Zusatzinformation - Art 11;Zusatzinformation - Inhalt 11;Zusatzinformation - Art 12;Zusatzinformation - Inhalt 12;Zusatzinformation - Art 13;Zusatzinformation - Inhalt 13;Zusatzinformation - Art 14;Zusatzinformation - Inhalt 14;Zusatzinformation - Art 15;Zusatzinformation - Inhalt 15;Zusatzinformation - Art 16;Zusatzinformation - Inhalt 16;Zusatzinformation - Art 17;Zusatzinformation - Inhalt 17;Zusatzinformation - Art 18;Zusatzinformation - Inhalt 18;Zusatzinformation - Art 19;Zusatzinformation - Inhalt 19;Zusatzinformation - Art 20;Zusatzinformation - Inhalt 20;Stück;Gewicht;Zahlweise;Forderungsart;Veranlagungsjahr;Zugeordnete Fälligkeit;Skontotyp;Auftragsnummer;Buchungstyp;USt-Schlüssel (Anzahlungen);EU-Land (Anzahlungen);Sachverhalt L+L (Anzahlungen);EU-Steuersatz (Anzahlungen);Erlöskonto (Anzahlungen);Herkunft-Kz;Leerfeld;KOST-Datum;SEPA-Mandatsreferenz;Skontosperre;Gesellschaftername;Beteiligtennummer;Identifikationsnummer;Zeichnernummer;Postensperre bis;Bezeichnung SoBil-Sachverhalt;Kennzeichen SoBil-Buchung;Festschreibung;Leistungsdatum;Datum Zuord. Steuerperiode;Fälligkeit;Generalumkehr;Steuersatz;Land;Abrechnungsreferenz;BVV-Position (Betriebsvermögensvergleich);EU-Mitgliedstaat u. UStID (Ursprung);EU-Steuersatz (Ursprung);Abw. Skontokonto";
        } elseif ($this->formatName === FormatName::DEBITOREN_KREDITOREN) {
            return "Konto;Name (Adressatentyp Unternehmen);Unternehmensgegenstand;Name (Adressatentyp natürl. Person);Vorname (Adressatentyp natürl. Person);Name (Adressatentyp keine Angabe);Adressatentyp;Kurzbezeichnung;EU-Mitgliedstaat;EU-USt-IdNr.;Anrede;Titel/Akad.Grad;Adelstitel;Namensvorsatz;Adressart;Straße;Postfach;Postleitzahl;Ort;Land;Versandzusatz;Adresszusatz;Abweichende Anrede;Abw. Zustellbezeichnung 1;Abw. Zustellbezeichnung 2;Kennz. Korrespondenzadresse;Adresse Gültig von;Adresse Gültig bis;Telefon;Bemerkung (Telefon);Telefon Geschäftsleitung;Bemerkung (Telefon GL);E-Mail;Bemerkung (E-Mail);Internet;Bemerkung (Internet);Fax;Bemerkung (Fax);Sonstige;Bemerkung (Sonstige);Bankleitzahl 1;Bankbezeichnung 1;Bank-Kontonummer 1;Länderkennzeichen 1;IBAN-Nr. 1;Leerfeld;SWIFT-Code 1;Abw. Kontoinhaber 1;Kennz. Hauptbankverb. 1;Bankverbindung 1 Gültig von;Bankverbindung 1 Gültig bis;Bankleitzahl 2;Bankbezeichnung 2;Bank-Kontonummer 2;Länderkennzeichen 2;IBAN-Nr. 2;Leerfeld;SWIFT-Code 2;Abw. Kontoinhaber 2;Kennz. Hauptbankverb. 2;Bankverbindung 2 Gültig von;Bankverbindung 2 Gültig bis;Bankleitzahl 3;Bankbezeichnung 3;Bank-Kontonummer 3;Länderkennzeichen 3;IBAN-Nr. 3;Leerfeld;SWIFT-Code 3;Abw. Kontoinhaber 3;Kennz. Hauptbankverb. 3;Bankverbindung 3 Gültig von;Bankverbindung 3 Gültig bis;Bankleitzahl 4;Bankbezeichnung 4;Bank-Kontonummer 4;Länderkennzeichen 4;IBAN-Nr. 4;Leerfeld;SWIFT-Code 4;Abw. Kontoinhaber 4;Kennz. Hauptbankverb. 4;Bankverbindung 4 Gültig von;Bankverbindung 4 Gültig bis;Bankleitzahl 5;Bankbezeichnung 5;Bank-Kontonummer 5;Länderkennzeichen 5;IBAN-Nr. 5;Leerfeld;SWIFT-Code 5;Abw. Kontoinhaber 5;Kennz. Hauptbankverb. 5;Bankverbindung 5 Gültig von;Bankverbindung 5 Gültig bis;Leerfeld;Briefanrede;Grußformel;Kundennummer;Steuernummer;Sprache;Ansprechpartner;Vertreter;Sachbearbeiter;Diverse-Konto;Ausgabeziel;Währungssteuerung;Kreditlimit (Debitor);Zahlungsbedingung;Fälligkeit in Tagen (Debitor);Skonto in Prozent (Debitor);Kreditoren-Ziel 1 (Tage);Kreditoren-Skonto 1 (%);Kreditoren-Ziel 2 (Tage);Kreditoren-Skonto 2 (%);Kreditoren-Ziel 3 Brutto (Tage);Kreditoren-Ziel 4 (Tage);Kreditoren-Skonto 4 (%);Kreditoren-Ziel 5 (Tage);Kreditoren-Skonto 5 (%);Mahnung;Kontoauszug;Mahntext 1;Mahntext 2;Mahntext 3;Kontoauszugstext;Mahnlimit Betrag;Mahnlimit %;Zinsberechnung;Mahnzinssatz 1;Mahnzinssatz 2;Mahnzinssatz 3;Lastschrift;Leerfeld;Mandantenbank;Zahlungsträger;Indiv. Feld 1;Indiv. Feld 2;Indiv. Feld 3;Indiv. Feld 4;Indiv. Feld 5;Indiv. Feld 6;Indiv. Feld 7;Indiv. Feld 8;Indiv. Feld 9;Indiv. Feld 10;Indiv. Feld 11;Indiv. Feld 12;Indiv. Feld 13;Indiv. Feld 14;Indiv. Feld 15;Abweichende Anrede (Rechnungsadresse);Adressart (Rechnungsadresse);Straße (Rechnungsadresse);Postfach (Rechnungsadresse);Postleitzahl (Rechnungsadresse);Ort (Rechnungsadresse);Land (Rechnungsadresse);Versandzusatz (Rechnungsadresse);Adresszusatz (Rechnungsadresse);Abw. Zustellbezeichnung 1 (Rechnungsadresse);Abw. Zustellbezeichnung 2 (Rechnungsadresse);Adresse Gültig von (Rechnungsadresse);Adresse Gültig bis (Rechnungsadresse);Bankleitzahl 6;Bankbezeichnung 6;Bank-Kontonummer 6;Länderkennzeichen 6;IBAN-Nr. 6;Leerfeld;SWIFT-Code 6;Abw. Kontoinhaber 6;Kennz. Hauptbankverb. 6;Bankverbindung 6 Gültig von;Bankverbindung 6 Gültig bis;Bankleitzahl 7;Bankbezeichnung 7;Bank-Kontonummer 7;Länderkennzeichen 7;IBAN-Nr. 7;Leerfeld;SWIFT-Code 7;Abw. Kontoinhaber 7;Kennz. Hauptbankverb. 7;Bankverbindung 7 Gültig von;Bankverbindung 7 Gültig bis;Bankleitzahl 8;Bankbezeichnung 8;Bank-Kontonummer 8;Länderkennzeichen 8;IBAN-Nr. 8;Leerfeld;SWIFT-Code 8;Abw. Kontoinhaber 8;Kennz. Hauptbankverb. 8;Bankverbindung 8 Gültig von;Bankverbindung 8 Gültig bis;Bankleitzahl 9;Bankbezeichnung 9;Bank-Kontonummer 9;Länderkennzeichen 9;IBAN-Nr. 9;Leerfeld;SWIFT-Code 9;Abw. Kontoinhaber 9;Kennz. Hauptbankverb. 9;Bankverbindung 9 Gültig von;Bankverbindung 9 Gültig bis;Bankleitzahl 10;Bankbezeichnung 10;Bank-Kontonummer 10;Länderkennzeichen 10;IBAN-Nr. 10;Leerfeld;SWIFT-Code 10;Abw. Kontoinhaber 10;Kennz. Hauptbankverb. 10;Bankverbindung 10 Gültig von;Bankverbindung 10 Gültig bis;Nummer Fremdsystem;Insolvent;SEPA-Mandatsreferenz 1;SEPA-Mandatsreferenz 2;SEPA-Mandatsreferenz 3;SEPA-Mandatsreferenz 4;SEPA-Mandatsreferenz 5;SEPA-Mandatsreferenz 6;SEPA-Mandatsreferenz 7;SEPA-Mandatsreferenz 8;SEPA-Mandatsreferenz 9;SEPA-Mandatsreferenz 10;Verknüpftes OPOS-Konto;Mahnsperre bis;Lastschriftsperre bis;Zahlungssperre bis;Gebührenberechnung;Mahngebühr 1;Mahngebühr 2;Mahngebühr 3;Pauschalenberechnung;Verzugspauschale 1;Verzugspauschale 2;Verzugspauschale 3;Alternativer Suchname;Status;Anschrift manuell geändert (Korrespondenzadresse);Anschrift individuell (Korrespondenzadresse);Anschrift manuell geändert (Rechnungsadresse);Anschrift individuell (Rechnungsadresse);Fristberechnung bei Debitor;Mahnfrist 1;Mahnfrist 2;Mahnfrist 3;Letzte Frist";
        } else {
            throw new \InvalidArgumentException('Unsupported format name: ' . $this->formatName);
        }
    }

    /**
     * Build the complete CSV content
     *
     * @return string The complete CSV content
     */
    public function build(): string
    {
        $lines = [];

        // Add header
        $lines[] = $this->header->build();

        // Add column headers
        $lines[] = $this->buildColumnHeader();

        // Add entries
        foreach ($this->entries as $entry) {
            $lines[] = $entry->build();
        }

        return implode("\r\n", $lines);
    }

    /**
     * Generate the output file
     *
     * @param string $filePath Path to the output file
     * @return bool Success of the file operation
     */
    public function generateFile(string $filePath): bool
    {
        $content = $this->build();
        return file_put_contents($filePath, $content) !== false;
    }
}