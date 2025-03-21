<?php

namespace ameax\DatevExtf;

use ameax\DatevExtf\Enums\AccountingPurpose;
use ameax\DatevExtf\Enums\AccountFramework;
use ameax\DatevExtf\Enums\BookingType;
use ameax\DatevExtf\Enums\Currency;
use ameax\DatevExtf\Enums\FinalizationStatus;
use ameax\DatevExtf\Enums\FormatCategory;
use ameax\DatevExtf\Enums\FormatIdentifier;
use ameax\DatevExtf\Enums\FormatName;
use ameax\DatevExtf\Enums\FormatVersion;

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
            'identifier' => FormatIdentifier::EXTF, // Kennzeichen
            'version' => 700, // Versionsnummer
            'format_category' => FormatCategory::BUCHUNGSSTAPEL, // Formatkategorie
            'format_name' => FormatName::BUCHUNGSSTAPEL, // Formatname
            'format_version' => FormatVersion::VERSION_13, // Formatversion
            'created_at' => new \DateTime(), // Erzeugt am (YYYYMMDDHHMMSSFFF)
            'imported' => '', // Importiert
            'origin' => '', // Herkunft
            'exported_by' => '', // Exportiert von
            'imported_by' => '', // Importiert von
            'consultant_number' => 1001, // Beraternummer
            'client_number' => 1, // Mandantennummer
            'fiscal_year_start' => new \DateTime('first day of January'), // WJ-Beginn
            'account_length' => 4, // Sachkontenlänge
            'date_from' => new \DateTime(), // Datum von
            'date_to' => new \DateTime(), // Datum bis
            'description' => '', // Bezeichnung
            'dictation_code' => '', // Diktatkürzel
            'booking_type' => BookingType::FIBU, // Buchungstyp
            'accounting_purpose' => AccountingPurpose::HGB, // Rechnungslegungszweck
            'finalization' => FinalizationStatus::NOT_FINALIZED, // Festschreibung
            'currency' => Currency::EUR, // WKZ
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
        if (!FormatIdentifier::isValid($identifier)) {
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
        if (!FormatCategory::isValid($category)) {
            throw new \InvalidArgumentException("Invalid format category: $category");
        }
        $this->header['format_category'] = $category;
        return $this;
    }

    public function setFormatName(string $name): self
    {
        if (!FormatName::isValid($name)) {
            throw new \InvalidArgumentException("Invalid format name: $name");
        }

        // Automatically update format category and version based on format name
        $this->header['format_name'] = $name;
        $this->header['format_category'] = FormatName::getDefaultFormatCategory($name);
        $this->header['format_version'] = FormatName::getDefaultFormatVersion($name);

        return $this;
    }

    public function setFormatVersion(int $version): self
    {
        if (!FormatVersion::isValid($version)) {
            throw new \InvalidArgumentException("Invalid format version: $version");
        }
        $this->header['format_version'] = $version;
        return $this;
    }

    public function setCreatedAt(\DateTime $date): self
    {
        $this->header['created_at'] = $date;
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
        $this->header['fiscal_year_start'] = $date;
        return $this;
    }

    public function setAccountLength(int $length): self
    {
        if ($length < 4 || $length > 8) {
            throw new \InvalidArgumentException("Account length must be between 4 and 8.");
        }
        $this->header['account_length'] = $length;
        return $this;
    }

    public function setDateFrom(\DateTime $date): self
    {
        $this->header['date_from'] = $date;
        return $this;
    }

    public function setDateTo(\DateTime $date): self
    {
        $this->header['date_to'] = $date;
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

    public function setDictationCode(string $code): self
    {
        if (strlen($code) > 2) {
            throw new \InvalidArgumentException("Dictation code must be max. 2 characters.");
        }
        $this->header['dictation_code'] = $code;
        return $this;
    }

    public function setBookingType(int $type): self
    {
        if (!BookingType::isValid($type)) {
            throw new \InvalidArgumentException("Invalid booking type: $type");
        }
        $this->header['booking_type'] = $type;
        return $this;
    }

    public function setAccountingPurpose(int $purpose): self
    {
        if (!AccountingPurpose::isValid($purpose)) {
            throw new \InvalidArgumentException("Invalid accounting purpose: $purpose");
        }
        $this->header['accounting_purpose'] = $purpose;
        return $this;
    }

    public function setFinalization(int $status): self
    {
        if (!FinalizationStatus::isValid($status)) {
            throw new \InvalidArgumentException("Invalid finalization status: $status");
        }
        $this->header['finalization'] = $status;
        return $this;
    }

    public function setCurrency(string $currency): self
    {
        if (!Currency::isValid($currency)) {
            throw new \InvalidArgumentException("Invalid currency: $currency");
        }
        $this->header['currency'] = $currency;
        return $this;
    }

    public function setAccountFramework(string $framework): self
    {
        if (!empty($framework) && !AccountFramework::isValid($framework)) {
            throw new \InvalidArgumentException("Invalid account framework: $framework");
        }
        $this->header['account_framework'] = $framework;
        return $this;
    }

    public function setIndustrySolutionId(string $id): self
    {
        if (strlen($id) > 2) {
            throw new \InvalidArgumentException("Industry solution ID must be max. 2 characters.");
        }
        $this->header['industry_solution_id'] = $id;
        return $this;
    }

    public function setApplicationInfo(string $info): self
    {
        if (strlen($info) > 16) {
            throw new \InvalidArgumentException("Application info must be max. 16 characters.");
        }
        $this->header['application_info'] = $info;
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

            // Format DateTime objects based on field type
            if ($value instanceof \DateTime) {
                if ($key === 'created_at') {
                    $value = $value->format('YmdHis0000'); // YYYYMMDDHHMMSSFFF
                } else {
                    $value = $value->format('Ymd'); // YYYYMMDD
                }
            }

            // Quote strings but not numbers
            return is_numeric($value) ? $value : "\"$value\"";
        }, $this->getFieldOrder());

        return implode(';', $orderedFields);
    }
}