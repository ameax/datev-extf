<?php

namespace ameax\DatevExtf;

class DatevExtfHeader
{
    private array $header = [];

    public static function make(): self {
        return new DatevExtfHeader();
    }

    public function fromArray(array $data): self
    {
        foreach ($data as $key => $value) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function __construct()
    {
        // Default values for all fields
        $this->header = [
            'identifier' => 'EXTF', // Kennzeichen
            'version' => 700, // Versionsnummer
            'format_category' => 21, // Formatkategorie
            'format_name' => 'Buchungsstapel', // Formatname
            'format_version' => 13, // Formatversion
            'created_at' => (new \DateTime())->format('YmdHis0000'), // Erzeugt am (YYYYMMDDHHMMSSFFF)
            'imported' => '', // Importiert
            'origin' => '', // Herkunft
            'exported_by' => '', // Exportiert von
            'imported_by' => '', // Importiert von
            'consultant_number' => 1001, // Beraternummer
            'client_number' => 1, // Mandantennummer
            'fiscal_year_start' => (new \DateTime('first day of January'))->format('Ymd'), // WJ-Beginn
            'account_length' => 4, // Sachkontenlänge
            'date_from' => (new \DateTime())->format('Ymd'), // Datum von
            'date_to' => (new \DateTime())->format('Ymd'), // Datum bis
            'description' => '', // Bezeichnung
            'dictation_code' => '', // Diktatkürzel
            'booking_type' => 1, // Buchungstyp
            'accounting_purpose' => 0, // Rechnungslegungszweck
            'finalization' => 0, // Festschreibung
            'currency' => 'EUR', // WKZ
            'reserved_1' => '', // Reserviert
            'derivate_indicator' => '', // Derivatskennzeichen
            'reserved_2' => '', // Reserviert
            'reserved_3' => '', // Reserviert
            'account_framework' => '', // Sachkontenrahmen
            'industry_solution_id' => '', // ID der Branchenlösung
            'reserved_4' => '', // Reserviert
            'reserved_5' => '', // Reserviert
            'application_info' => '' // Anwendungsinformation
        ];
    }

    public function setIdentifier(string $identifier): self
    {
        if (!in_array($identifier, ['EXTF', 'DTVF'], true)) {
            throw new \InvalidArgumentException("Invalid identifier: $identifier");
        }
        $this->header['identifier'] = $identifier;
        return $this;
    }

    public function setVersion(int $version): self
    {
        if ($version !== 700) {
            throw new \InvalidArgumentException("Only version 700 is allowed.");
        }
        $this->header['version'] = $version;
        return $this;
    }

    public function setFormatCategory(int $category): self
    {
        $valid = [16, 20, 21, 46, 48, 65];
        if (!in_array($category, $valid, true)) {
            throw new \InvalidArgumentException("Invalid format category: $category");
        }
        $this->header['format_category'] = $category;
        return $this;
    }

    public function setFormatName(string $name): self
    {
        $valid = [
            'Buchungsstapel', 'Wiederkehrende Buchungen', 'Debitoren/Kreditoren',
            'Kontenbeschriftungen', 'Zahlungsbedingungen', 'Diverse Adressen'
        ];
        if (!in_array($name, $valid, true)) {
            throw new \InvalidArgumentException("Invalid format name: $name");
        }
        $this->header['format_name'] = $name;
        return $this;
    }

    public function setFormatVersion(int $version): self
    {
        $valid = [2, 4, 5, 13];
        if (!in_array($version, $valid, true)) {
            throw new \InvalidArgumentException("Invalid format version: $version");
        }
        $this->header['format_version'] = $version;
        return $this;
    }

    public function setCreatedAt(\DateTime $datetime): self
    {
        $this->header['created_at'] = $datetime->format('YmdHis0000');
        return $this;
    }

    public function setExportedBy(string $name): self
    {
        if (strlen($name) > 25) {
            throw new \InvalidArgumentException("Name must be max. 25 characters.");
        }
        $this->header['exported_by'] = $name;
        return $this;
    }

    public function setImportedBy(string $name): self
    {
        if (strlen($name) > 25) {
            throw new \InvalidArgumentException("Name must be max. 25 characters.");
        }
        $this->header['imported_by'] = $name;
        return $this;
    }

    public function setConsultantNumber(int $number): self
    {
        if ($number < 1001 || $number > 9999999) {
            throw new \InvalidArgumentException("Consultant number must be between 1001 and 9999999.");
        }
        $this->header['consultant_number'] = $number;
        return $this;
    }

    public function setClientNumber(int $number): self
    {
        if ($number < 1 || $number > 99999) {
            throw new \InvalidArgumentException("Client number must be between 1 and 99999.");
        }
        $this->header['client_number'] = $number;
        return $this;
    }

    public function setFiscalYearStart(\DateTime $date): self
    {
        $this->header['fiscal_year_start'] = $date->format('Ymd');
        return $this;
    }

    public function setDescription(string $description): self
    {
        if (strlen($description) > 30) {
            throw new \InvalidArgumentException("Description must be max. 30 characters.");
        }
        $this->header['description'] = $description;
        return $this;
    }

    private function getFieldOrder(): array
    {
        return [
            'identifier', 'version', 'format_category', 'format_name', 'format_version',
            'created_at', 'imported', 'origin', 'exported_by', 'imported_by',
            'consultant_number', 'client_number', 'fiscal_year_start', 'account_length',
            'date_from', 'date_to', 'description', 'dictation_code', 'booking_type',
            'accounting_purpose', 'finalization', 'currency', 'reserved_1',
            'derivate_indicator', 'reserved_2', 'reserved_3', 'account_framework',
            'industry_solution_id', 'reserved_4', 'reserved_5', 'application_info'
        ];
    }

    public function build(): string
    {
        $orderedFields = array_map(function ($key) {
            $value = $this->header[$key];

            // Quote strings but not numbers
            return is_numeric($value) ? $value : "\"$value\"";
        }, $this->getFieldOrder());

        return implode(';', $orderedFields);
    }
}




namespace ameax\DatevExtf;

class DatevHeaderBuilder
{

}
