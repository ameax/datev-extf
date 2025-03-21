<?php

namespace ameax\DatevExtf;

<?php

namespace ameax\DatevExtf;

class DatevExtfWriterEntry
{
    protected array $fields = [];

    public function __construct()
    {
        $this->applyDefaults();
    }

    public function applyDefaults(): self
    {
        $this->fields = array_fill_keys($this->getFieldOrder(), '');
        $this->fields['debit_credit_indicator'] = 'S'; // Default: SOLL
        $this->fields['posting_lock'] = '0'; // Default: No lock
        $this->fields['interest_lock'] = '0'; // Default: No lock
        return $this;
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

    public function build(): string
    {
        $orderedFields = $this->getFieldOrder();
        $values = [];

        foreach ($orderedFields as $key) {
            $value = $this->fields[$key] ?? '';
            $values[] = is_numeric($value) ? $value : '"' . $value . '"';
        }

        return implode(';', $values);
    }

    protected function getFieldOrder(): array
    {
        return [
            'amount',                            // 1. Umsatz
            'debit_credit_indicator',            // 2. Soll-/Haben-Kennzeichen
            'currency_code',                     // 3. WKZ Umsatz
            'exchange_rate',                     // 4. Kurs
            'base_amount',                       // 5. Basisumsatz
            'base_currency_code',                // 6. WKZ Basisumsatz
            'account',                           // 7. Konto
            'contra_account',                    // 8. Gegenkonto (ohne BU-Schlüssel)
            'bu_code',                           // 9. BU-Schlüssel
            'document_date',                     // 10. Belegdatum
            'document_field_1',                  // 11. Belegfeld 1
            'document_field_2',                  // 12. Belegfeld 2
            'discount',                          // 13. Skonto
            'posting_text',                      // 14. Buchungstext
            'posting_lock',                      // 15. Postensperre
            'diverse_address_number',            // 16. Diverse Adressnummer
            'business_partner_bank',             // 17. Geschäftspartnerbank
            'transaction_type',                  // 18. Sachverhalt
            'interest_lock',                     // 19. Zinssperre
            'document_link',                     // 20. Beleglink
            'document_info_type_1',              // 21. Beleginfo-Art 1
            'document_info_content_1',           // 22. Beleginfo-Inhalt 1
            'document_info_type_2',              // 23. Beleginfo-Art 2
            'document_info_content_2',           // 24. Beleginfo-Inhalt 2
            'document_info_type_3',              // 25. Beleginfo-Art 3
            'document_info_content_3',           // 26. Beleginfo-Inhalt 3
            'document_info_type_4',              // 27. Beleginfo-Art 4
            'document_info_content_4',           // 28. Beleginfo-Inhalt 4
            'document_info_type_5',              // 29. Beleginfo-Art 5
            'document_info_content_5',           // 30. Beleginfo-Inhalt 5
            'document_info_type_6',              // 31. Beleginfo-Art 6
            'document_info_content_6',           // 32. Beleginfo-Inhalt 6
            'document_info_type_7',              // 33. Beleginfo-Art 7
            'document_info_content_7',           // 34. Beleginfo-Inhalt 7
            'document_info_type_8',              // 35. Beleginfo-Art 8
            'document_info_content_8',           // 36. Beleginfo-Inhalt 8
            'cost_center_1',                     // 37. KOST1-Kostenstelle
            'cost_center_2',                     // 38. KOST2-Kostenstelle
            'cost_quantity',                     // 39. KOST-Menge
            'eu_state_and_vat_id_destination',   // 40. EU-Mitgliedstaat u. UStID (Bestimmung)
            'eu_tax_rate_destination',           // 41. EU-Steuersatz (Bestimmung)
            'alternative_tax_type',              // 42. Abw. Versteuerungsart
            'l_and_l_transaction_type',          // 43. Sachverhalt L+L
            'l_and_l_function_addition',         // 44. Funktionsergänzung L+L
            'bu_49_main_function_type',          // 45. BU 49 Hauptfunktiontyp
            'bu_49_main_function_number',        // 46. BU 49 Hauptfunktionsnummer
            'bu_49_function_addition',           // 47. BU 49 Funktionsergänzung
            'additional_info_type_1',            // 48. Zusatzinformation – Art 1
            'additional_info_content_1',         // 49. Zusatzinformation – Inhalt 1
            'additional_info_type_2',            // 50. Zusatzinformation – Art 2
            'additional_info_content_2',         // 51. Zusatzinformation – Inhalt 2
            'additional_info_type_3',            // 52. Zusatzinformation – Art 3
            'additional_info_content_3',         // 53. Zusatzinformation – Inhalt 3
            'additional_info_type_4',            // 54. Zusatzinformation – Art 4
            'additional_info_content_4',         // 55. Zusatzinformation – Inhalt 4
            'additional_info_type_5',            // 56. Zusatzinformation – Art 5
            'additional_info_content_5',         // 57. Zusatzinformation – Inhalt 5
            'additional_info_type_6',            // 58. Zusatzinformation – Art 6
            'additional_info_content_6',         // 59. Zusatzinformation – Inhalt 6
            'additional_info_type_7',            // 60. Zusatzinformation – Art 7
            'additional_info_content_7',         // 61. Zusatzinformation – Inhalt 7
            'additional_info_type_8',            // 62. Zusatzinformation – Art 8
            'additional_info_content_8',         // 63. Zusatzinformation – Inhalt 8
            'additional_info_type_9',            // 64. Zusatzinformation – Art 9
            'additional_info_content_9',         // 65. Zusatzinformation – Inhalt 9
            'additional_info_type_10',           // 66. Zusatzinformation – Art 10
            'additional_info_content_10',        // 67. Zusatzinformation – Inhalt 10
            'additional_info_type_11',           // 68. Zusatzinformation – Art 11
            'additional_info_content_11',        // 69. Zusatzinformation – Inhalt 11
            'additional_info_type_12',           // 70. Zusatzinformation – Art 12
            'additional_info_content_12',        // 71. Zusatzinformation – Inhalt 12
            'additional_info_type_13',           // 72. Zusatzinformation – Art 13
            'additional_info_content_13',        // 73. Zusatzinformation – Inhalt 13
            'additional_info_type_14',           // 74. Zusatzinformation – Art 14
            'additional_info_content_14',        // 75. Zusatzinformation – Inhalt 14
            'additional_info_type_15',           // 76. Zusatzinformation – Art 15
            'additional_info_content_15',        // 77. Zusatzinformation – Inhalt 15
            'additional_info_type_16',           // 78. Zusatzinformation – Art 16
            'additional_info_content_16',        // 79. Zusatzinformation – Inhalt 16
            'additional_info_type_17',           // 80. Zusatzinformation – Art 17
            'additional_info_content_17',        // 81. Zusatzinformation – Inhalt 17
            'additional_info_type_18',           // 82. Zusatzinformation – Art 18
            'additional_info_content_18',        // 83. Zusatzinformation – Inhalt 18
            'additional_info_type_19',           // 84. Zusatzinformation – Art 19
            'additional_info_content_19',        // 85. Zusatzinformation – Inhalt 19
            'additional_info_type_20',           // 86. Zusatzinformation – Art 20
            'additional_info_content_20',        // 87. Zusatzinformation – Inhalt 20
            'item_count',                        // 88. Stück
            'weight',                            // 89. Gewicht
            'payment_method',                    // 90. Zahlweise
            'claim_type',                        // 91. Forderungsart
            'assessment_year',                   // 92. Veranlagungsjahr
            'assigned_due_date',                 // 93. Zugeordnete Fälligkeit
            'discount_type',                     // 94. Skontotyp
            'order_number',                      // 95. Auftragsnummer
            'posting_type',                      // 96. Buchungstyp
            'vat_code_advance_payments',         // 97. USt-Schlüssel (Anzahlungen)
            'eu_state_advance_payments',         // 98. EU-Mitgliedstaat (Anzahlungen)
            'l_and_l_transaction_type_advance',  // 99. Sachverhalt L+L (Anzahlungen)
            'eu_tax_rate_advance_payments',      // 100. EU-Steuersatz (Anzahlungen)
            'revenue_account_advance_payments',  // 101. Erlöskonto (Anzahlungen)
            'source_code',                       // 102. Herkunft-Kz
            'empty_field',                       // 103. Leerfeld
            'cost_date',                         // 104. KOST-Datum
            'sepa_mandate_reference',            // 105. SEPA-Mandatsreferenz
            'discount_lock',                     // 106. Skontosperre
            'partner_name',                      // 107. Gesellschaftername
            'participant_number',                // 108. Beteiligtennummer
            'identification_number',             // 109. Identifikationsnummer
            'subscriber_number',                 // 110. Zeichnernummer
            'posting_lock_until',                // 111. Postensperre bis
            'special_balance_description',       // 112. Bezeichnung SoBil-Sachverhalt
            'special_balance_indicator',         // 113. Kennzeichen SoBil-Buchung
            'finalization',                      // 114. Festschreibung
            'service_date',                      // 115. Leistungsdatum
            'tax_period_date',                   // 116. Datum Zuord. Steuerperiode
            'due_date',                          // 117. Fälligkeit
            'general_reversal',                  // 118. Generalumkehr
            'tax_rate',                          // 119. Steuersatz
            'country',                           // 120. Land
            'billing_reference',                 // 121. Abrechnungsreferenz
            'bvv_position',                      // 122. BVV-Position (Betriebsvermögensvergleich)
            'eu_state_and_vat_id_origin',        // 123. EU-Mitgliedstaat u. UStID (Ursprung)
            'eu_tax_rate_origin',                // 124. EU-Steuersatz (Ursprung)
            'alternative_discount_account'       // 125. Abw. Skontokonto
        ];
    }

    // Basic data setters
    public function setAmount(string $value): self { $this->fields['amount'] = $value; return $this; }
    public function setDebitCreditIndicator(string $value): self { $this->fields['debit_credit_indicator'] = $value; return $this; }
    public function setCurrencyCode(string $value): self { $this->fields['currency_code'] = $value; return $this; }
    public function setExchangeRate(string $value): self { $this->fields['exchange_rate'] = $value; return $this; }
    public function setBaseAmount(string $value): self { $this->fields['base_amount'] = $value; return $this; }
    public function setBaseCurrencyCode(string $value): self { $this->fields['base_currency_code'] = $value; return $this; }
    public function setAccount(string $value): self { $this->fields['account'] = $value; return $this; }
    public function setContraAccount(string $value): self { $this->fields['contra_account'] = $value; return $this; }
    public function setBuCode(string $value): self { $this->fields['bu_code'] = $value; return $this; }
    public function setDocumentDate(string $value): self { $this->fields['document_date'] = $value; return $this; }
    public function setDocumentField1(string $value): self { $this->fields['document_field_1'] = $value; return $this; }
    public function setDocumentField2(string $value): self { $this->fields['document_field_2'] = $value; return $this; }
    public function setDiscount(string $value): self { $this->fields['discount'] = $value; return $this; }
    public function setPostingText(string $value): self { $this->fields['posting_text'] = $value; return $this; }
    public function setPostingLock(string $value): self { $this->fields['posting_lock'] = $value; return $this; }
    public function setDiverseAddressNumber(string $value): self { $this->fields['diverse_address_number'] = $value; return $this; }
    public function setBusinessPartnerBank(string $value): self { $this->fields['business_partner_bank'] = $value; return $this; }
    public function setTransactionType(string $value): self { $this->fields['transaction_type'] = $value; return $this; }
    public function setInterestLock(string $value): self { $this->fields['interest_lock'] = $value; return $this; }
    public function setDocumentLink(string $value): self { $this->fields['document_link'] = $value; return $this; }

    // Document info setters
    public function setDocumentInfoType1(string $value): self { $this->fields['document_info_type_1'] = $value; return $this; }
    public function setDocumentInfoContent1(string $value): self { $this->fields['document_info_content_1'] = $value; return $this; }
    public function setDocumentInfoType2(string $value): self { $this->fields['document_info_type_2'] = $value; return $this; }
    public function setDocumentInfoContent2(string $value): self { $this->fields['document_info_content_2'] = $value; return $this; }
    public function setDocumentInfoType3(string $value): self { $this->fields['document_info_type_3'] = $value; return $this; }
    public function setDocumentInfoContent3(string $value): self { $this->fields['document_info_content_3'] = $value; return $this; }
    public function setDocumentInfoType4(string $value): self { $this->fields['document_info_type_4'] = $value; return $this; }
    public function setDocumentInfoContent4(string $value): self { $this->fields['document_info_content_4'] = $value; return $this; }
    public function setDocumentInfoType5(string $value): self { $this->fields['document_info_type_5'] = $value; return $this; }
    public function setDocumentInfoContent5(string $value): self { $this->fields['document_info_content_5'] = $value; return $this; }
    public function setDocumentInfoType6(string $value): self { $this->fields['document_info_type_6'] = $value; return $this; }
    public function setDocumentInfoContent6(string $value): self { $this->fields['document_info_content_6'] = $value; return $this; }
    public function setDocumentInfoType7(string $value): self { $this->fields['document_info_type_7'] = $value; return $this; }
    public function setDocumentInfoContent7(string $value): self { $this->fields['document_info_content_7'] = $value; return $this; }
    public function setDocumentInfoType8(string $value): self { $this->fields['document_info_type_8'] = $value; return $this; }
    public function setDocumentInfoContent8(string $value): self { $this->fields['document_info_content_8'] = $value; return $this; }

    // Cost centers
    public function setCostCenter1(string $value): self { $this->fields['cost_center_1'] = $value; return $this; }
    public function setCostCenter2(string $value): self { $this->fields['cost_center_2'] = $value; return $this; }
    public function setCostQuantity(string $value): self { $this->fields['cost_quantity'] = $value; return $this; }

    // EU VAT data
    public function setEuStateAndVatIdDestination(string $value): self { $this->fields['eu_state_and_vat_id_destination'] = $value; return $this; }
    public function setEuTaxRateDestination(string $value): self { $this->fields['eu_tax_rate_destination'] = $value; return $this; }
    public function setAlternativeTaxType(string $value): self { $this->fields['alternative_tax_type'] = $value; return $this; }

    // L+L and BU49 data
    public function setLAndLTransactionType(string $value): self { $this->fields['l_and_l_transaction_type'] = $value; return $this; }
    public function setLAndLFunctionAddition(string $value): self { $this->fields['l_and_l_function_addition'] = $value; return $this; }
    public function setBu49MainFunctionType(string $value): self { $this->fields['bu_49_main_function_type'] = $value; return $this; }
    public function setBu49MainFunctionNumber(string $value): self { $this->fields['bu_49_main_function_number'] = $value; return $this; }
    public function setBu49FunctionAddition(string $value): self { $this->fields['bu_49_function_addition'] = $value; return $this; }

    // Additional information setters (first group 1-5)
    public function setAdditionalInfoType1(string $value): self { $this->fields['additional_info_type_1'] = $value; return $this; }
    public function setAdditionalInfoContent1(string $value): self { $this->fields['additional_info_content_1'] = $value; return $this; }
    public function setAdditionalInfoType2(string $value): self { $this->fields['additional_info_type_2'] = $value; return $this; }
    public function setAdditionalInfoContent2(string $value): self { $this->fields['additional_info_content_2'] = $value; return $this; }
    public function setAdditionalInfoType3(string $value): self { $this->fields['additional_info_type_3'] = $value; return $this; }
    public function setAdditionalInfoContent3(string $value): self { $this->fields['additional_info_content_3'] = $value; return $this; }
    public function setAdditionalInfoType4(string $value): self { $this->fields['additional_info_type_4'] = $value; return $this; }
    public function setAdditionalInfoContent4(string $value): self { $this->fields['additional_info_content_4'] = $value; return $this; }
    public function setAdditionalInfoType5(string $value): self { $this->fields['additional_info_type_5'] = $value; return $this; }
    public function setAdditionalInfoContent5(string $value): self { $this->fields['additional_info_content_5'] = $value; return $this; }

    // Additional information setters (second group 6-10)
    public function setAdditionalInfoType6(string $value): self { $this->fields['additional_info_type_6'] = $value; return $this; }
    public function setAdditionalInfoContent6(string $value): self { $this->fields['additional_info_content_6'] = $value; return $this; }
    public function setAdditionalInfoType7(string $value): self { $this->fields['additional_info_type_7'] = $value; return $this; }
    public function setAdditionalInfoContent7(string $value): self { $this->fields['additional_info_content_7'] = $value; return $this; }
    public function setAdditionalInfoType8(string $value): self { $this->fields['additional_info_type_8'] = $value; return $this; }
    public function setAdditionalInfoContent8(string $value): self { $this->fields['additional_info_content_8'] = $value; return $this; }
    public function setAdditionalInfoType9(string $value): self { $this->fields['additional_info_type_9'] = $value; return $this; }
    public function setAdditionalInfoContent9(string $value): self { $this->fields['additional_info_content_9'] = $value; return $this; }
    public function setAdditionalInfoType10(string $value): self { $this->fields['additional_info_type_10'] = $value; return $this; }
    public function setAdditionalInfoContent10(string $value): self { $this->fields['additional_info_content_10'] = $value; return $this; }

    // Additional information setters (third group 11-15)
    public function setAdditionalInfoType11(string $value): self { $this->fields['additional_info_type_11'] = $value; return $this; }
    public function setAdditionalInfoContent11(string $value): self { $this->fields['additional_info_content_11'] = $value; return $this; }
    public function setAdditionalInfoType12(string $value): self { $this->fields['additional_info_type_12'] = $value; return $this; }
    public function setAdditionalInfoContent12(string $value): self { $this->fields['additional_info_content_12'] = $value; return $this; }
    public function setAdditionalInfoType13(string $value): self { $this->fields['additional_info_type_13'] = $value; return $this; }
    public function setAdditionalInfoContent13(string $value): self { $this->fields['additional_info_content_13'] = $value; return $this; }
    public function setAdditionalInfoType14(string $value): self { $this->fields['additional_info_type_14'] = $value; return $this; }
    public function setAdditionalInfoContent14(string $value): self { $this->fields['additional_info_content_14'] = $value; return $this; }
    public function setAdditionalInfoType15(string $value): self { $this->fields['additional_info_type_15'] = $value; return $this; }
    public function setAdditionalInfoContent15(string $value): self { $this->fields['additional_info_content_15'] = $value; return $this; }

    // Additional information setters (fourth group 16-20)
    public function setAdditionalInfoType16(string $value): self { $this->fields['additional_info_type_16'] = $value; return $this; }
    public function setAdditionalInfoContent16(string $value): self { $this->fields['additional_info_content_16'] = $value; return $this; }
    public function setAdditionalInfoType17(string $value): self { $this->fields['additional_info_type_17'] = $value; return $this; }
    public function setAdditionalInfoContent17(string $value): self { $this->fields['additional_info_content_17'] = $value; return $this; }
    public function setAdditionalInfoType18(string $value): self { $this->fields['additional_info_type_18'] = $value; return $this; }
    public function setAdditionalInfoContent18(string $value): self { $this->fields['additional_info_content_18'] = $value; return $this; }
    public function setAdditionalInfoType19(string $value): self { $this->fields['additional_info_type_19'] = $value; return $this; }
    public function setAdditionalInfoContent19(string $value): self { $this->fields['additional_info_content_19'] = $value; return $this; }
    public function setAdditionalInfoType20(string $value): self { $this->fields['additional_info_type_20'] = $value; return $this; }
    public function setAdditionalInfoContent20(string $value): self { $this->fields['additional_info_content_20'] = $value; return $this; }

    // Agricultural fields
    public function setItemCount(string $value): self { $this->fields['item_count'] = $value; return $this; }
    public function setWeight(string $value): self { $this->fields['weight'] = $value; return $this; }

    // Municipal and payment fields
    public function setPaymentMethod(string $value): self { $this->fields['payment_method'] = $value; return $this; }
    public function setClaimType(string $value): self { $this->fields['claim_type'] = $value; return $this; }
    public function setAssessmentYear(string $value): self { $this->fields['assessment_year'] = $value; return $this; }
    public function setAssignedDueDate(string $value): self { $this->fields['assigned_due_date'] = $value; return $this; }
    public function setDiscountType(string $value): self { $this->fields['discount_type'] = $value; return $this; }

    // Order and posting information
    public function setOrderNumber(string $value): self { $this->fields['order_number'] = $value; return $this; }
    public function setPostingType(string $value): self { $this->fields['posting_type'] = $value; return $this; }

    // Advance payment fields
    public function setVatCodeAdvancePayments(string $value): self { $this->fields['vat_code_advance_payments'] = $value; return $this; }
    public function setEuStateAdvancePayments(string $value): self { $this->fields['eu_state_advance_payments'] = $value; return $this; }
    public function setLAndLTransactionTypeAdvance(string $value): self { $this->fields['l_and_l_transaction_type_advance'] = $value; return $this; }
    public function setEuTaxRateAdvancePayments(string $value): self { $this->fields['eu_tax_rate_advance_payments'] = $value; return $this; }
    public function setRevenueAccountAdvancePayments(string $value): self { $this->fields['revenue_account_advance_payments'] = $value; return $this; }

    // Source and meta information
    public function setSourceCode(string $value): self { $this->fields['source_code'] = $value; return $this; }
    public function setEmptyField(string $value): self { $this->fields['empty_field'] = $value; return $this; }
    public function setCostDate(string $value): self { $this->fields['cost_date'] = $value; return $this; }

    // SEPA and payment information
    public function setSepaManDateReference(string $value): self { $this->fields['sepa_mandate_reference'] = $value; return $this; }
    public function setDiscountLock(string $value): self { $this->fields['discount_lock'] = $value; return $this; }

    // Partner information fields
    public function setPartnerName(string $value): self { $this->fields['partner_name'] = $value; return $this; }
    public function setParticipantNumber(string $value): self { $this->fields['participant_number'] = $value; return $this; }
    public function setIdentificationNumber(string $value): self { $this->fields['identification_number'] = $value; return $this; }
    public function setSubscriberNumber(string $value): self { $this->fields['subscriber_number'] = $value; return $this; }

    // Lock and special balance fields
    public function setPostingLockUntil(string $value): self { $this->fields['posting_lock_until'] = $value; return $this; }
    public function setSpecialBalanceDescription(string $value): self { $this->fields['special_balance_description'] = $value; return $this; }
    public function setSpecialBalanceIndicator(string $value): self { $this->fields['special_balance_indicator'] = $value; return $this; }
    public function setFinalization(string $value): self { $this->fields['finalization'] = $value; return $this; }

    // Date fields
    public function setServiceDate(string $value): self { $this->fields['service_date'] = $value; return $this; }
    public function setTaxPeriodDate(string $value): self { $this->fields['tax_period_date'] = $value; return $this; }
    public function setDueDate(string $value): self { $this->fields['due_date'] = $value; return $this; }

    // Tax and country fields
    public function setGeneralReversal(string $value): self { $this->fields['general_reversal'] = $value; return $this; }
    public function setTaxRate(string $value): self { $this->fields['tax_rate'] = $value; return $this; }
    public function setCountry(string $value): self { $this->fields['country'] = $value; return $this; }

    // Reference and position fields
    public function setBillingReference(string $value): self { $this->fields['billing_reference'] = $value; return $this; }
    public function setBvvPosition(string $value): self { $this->fields['bvv_position'] = $value; return $this; }

    // EU origin fields
    public function setEuStateAndVatIdOrigin(string $value): self { $this->fields['eu_state_and_vat_id_origin'] = $value; return $this; }
    public function setEuTaxRateOrigin(string $value): self { $this->fields['eu_tax_rate_origin'] = $value; return $this; }

    // Alternative account fields
    public function setAlternativeDiscountAccount(string $value): self { $this->fields['alternative_discount_account'] = $value; return $this; }
}