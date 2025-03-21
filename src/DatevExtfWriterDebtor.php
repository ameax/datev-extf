<?php

namespace ameax\DatevExtf;

class DatevExtfWriterDebtor extends DatevExtfWriterPartiesAbstract
{
    public function __construct()
    {
        // Default values for relevant fields
        $this->fields = [
            'account_number' => '',         // Konto
            'company_name' => '',           // Name (Unternehmen)
            'first_name' => '',             // Vorname (nat. Person)
            'last_name' => '',              // Name (nat. Person)
            'address_type' => 'STR',        // Adressart
            'street' => '',                 // Straße
            'postal_code' => '',           // PLZ
            'city' => '',                   // Ort
            'country' => 'DE',             // Land
            'email' => '',                 // E-Mail
            'iban_1' => '',                // IBAN 1
            'bank_code_1' => '',           // BLZ 1
            'bank_account_1' => '',        // Konto-Nr. 1
            'main_bank_1' => '',           // Hauptbank 1
            'credit_limit' => '',          // Kreditlimit
            'payment_terms' => '',         // Zahlungsbedingung
            'due_days' => '',              // Fälligkeit in Tagen
            'discount_percent' => '',      // Skonto in Prozent
            'status' => '0',               // Status
        ];
    }

    public function setFromArray(array $data): self
    {
        foreach ($data as $key => $value) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($this, $method)) {
                $this->$method($value);
            } elseif (array_key_exists($key, $this->fields)) {
                $this->fields[$key] = $value;
            }
        }
        return $this;
    }

    public function setAccountNumber(string $number): self
    {
        $this->fields['account_number'] = $number;
        return $this;
    }

    public function setCompanyName(string $name): self
    {
        $this->fields['company_name'] = $name;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->fields['email'] = $email;
        return $this;
    }

    public function setStreet(string $street): self
    {
        $this->fields['street'] = $street;
        return $this;
    }

    public function setPostalCode(string $postal): self
    {
        $this->fields['postal_code'] = $postal;
        return $this;
    }

    public function setCity(string $city): self
    {
        $this->fields['city'] = $city;
        return $this;
    }

    public function setCountry(string $code): self
    {
        $this->fields['country'] = $code;
        return $this;
    }

    public function setIban1(string $iban): self
    {
        $this->fields['iban_1'] = $iban;
        return $this;
    }

    public function setBankCode1(string $blz): self
    {
        $this->fields['bank_code_1'] = $blz;
        return $this;
    }

    public function setBankAccount1(string $account): self
    {
        $this->fields['bank_account_1'] = $account;
        return $this;
    }

    public function setMainBank1(string $flag): self
    {
        $this->fields['main_bank_1'] = $flag;
        return $this;
    }

    public function setCreditLimit(string $amount): self
    {
        $this->fields['credit_limit'] = $amount;
        return $this;
    }

    public function setPaymentTerms(string $code): self
    {
        $this->fields['payment_terms'] = $code;
        return $this;
    }

    public function setDueDays(string $days): self
    {
        $this->fields['due_days'] = $days;
        return $this;
    }

    public function setDiscountPercent(string $percent): self
    {
        $this->fields['discount_percent'] = $percent;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->fields['status'] = $status;
        return $this;
    }

}
