<?php

namespace ameax\DatevExtf;

class DatevExtfWriterParty
{
    protected array $fields = [];

    public function __construct()
    {
        $this->applyDefaults();
    }

    public function applyDefaults(): self
    {
        $this->fields = array_fill_keys($this->getFieldOrder(), '');
        $this->fields['party_type'] = '2'; // Default: Unternehmen
        $this->fields['address_type'] = 'STR';
        $this->fields['country'] = 'DE';
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
            'account_number',                    // 1. Konto
            'company_name',                      // 2. Name (Adressatentyp Unternehmen)
            'business_purpose',                  // 3. Unternehmensgegenstand
            'person_last_name',                  // 4. Name (Adressatentyp natürl. Person)
            'person_first_name',                 // 5. Vorname (Adressatentyp natürl. Person)
            'unknown_last_name',                 // 6. Name (Adressatentyp keine Angabe)
            'party_type',                        // 7. Adressatentyp
            'short_name',                        // 8. Kurzbezeichnung
            'eu_country',                        // 9. EU-Mitgliedstaat
            'eu_vat_id',                         // 10. EU-USt-IdNr.
            'salutation',                        // 11. Anrede
            'title',                             // 12. Titel / Akad. Grad
            'nobility_title',                    // 13. Adelstitel
            'prefix',                            // 14. Namensvorsatz
            'address_type',                      // 15. Adressart
            'street',                            // 16. Straße
            'pob',                               // 17. Postfach
            'postal_code',                       // 18. Postleitzahl
            'city',                              // 19. Ort
            'country',                           // 20. Land
            'additional_delivery',               // 21. Versandzusatz
            'additional_address',                // 22. Adresszusatz
            'alt_salutation',                    // 23. Abweichende Anrede
            'alt_delivery_1',                    // 24. Abw. Zustellbezeichnung 1
            'alt_delivery_2',                    // 25. Abw. Zustellbezeichnung 2
            'is_correspondence_address',         // 26. Kennz. Korrespondenzadresse
            'address_valid_from',                // 27. Adresse Gültig von
            'address_valid_until',               // 28. Adresse Gültig bis
            'phone',                             // 29. Telefon
            'phone_note',                        // 30. Bemerkung (Telefon)
            'exec_phone',                        // 31. Telefon Geschäftsleitung
            'exec_phone_note',                   // 32. Bemerktung (Telefon GL)
            'email',                             // 33. E-Mail
            'email_note',                        // 34. Bemerkung (E-Mail)
            'website',                           // 35. Internet
            'website_note',                      // 36. Bemerkung (Internet)
            'fax',                               // 37. Fax
            'fax_note',                          // 38. Bemerkung (Fax)
            'other_contact',                     // 39. Sonstige
            'other_contact_note',                // 40. Bemerkung (Sonstige 1)
            'bank_code_1',                       // 41. Bankleitzahl 1
            'bank_name_1',                       // 42. Bankbezeichung 1
            'bank_account_1',                    // 43. Bankkonto-Nummer 1
            'bank_country_1',                    // 44. Länderkennzeichen 1
            'iban_1',                            // 45. IBAN-Nr. 1
            'bank_empty_field_1',                // 46. Leerfeld
            'swift_1',                           // 47. SWIFT-Code 1
            'different_account_holder_1',        // 48. Abw. Kontoinhaber 1
            'is_main_bank_account_1',            // 49. Kennz. Hauptbankverb. 1
            'bank_valid_from_1',                 // 50. Bankverb. 1 Gültig von
            'bank_valid_until_1',                // 51. Bankverb. 1 Gültig bis
            'bank_code_2',                       // 52. Bankleitzahl 2
            'bank_name_2',                       // 53. Bankbezeichung 2
            'bank_account_2',                    // 54. Bankkonto-Nummer 2
            'bank_country_2',                    // 55. Länderkennzeichen 2
            'iban_2',                            // 56. IBAN-Nr. 2
            'bank_empty_field_2',                // 57. Leerfeld
            'swift_2',                           // 58. SWIFT-Code 2
            'different_account_holder_2',        // 59. Abw. Kontoinhaber 2
            'is_main_bank_account_2',            // 60. Kennz. Hauptbankverb. 2
            'bank_valid_from_2',                 // 61. Bankverb. 2 Gültig von
            'bank_valid_until_2',                // 62. Bankverb. 2 Gültig bis
            'bank_code_3',                       // 63. Bankleitzahl 3
            'bank_name_3',                       // 64. Bankbezeichung 3
            'bank_account_3',                    // 65. Bankkonto-Nummer 3
            'bank_country_3',                    // 66. Länderkennzeichen 3
            'iban_3',                            // 67. IBAN-Nr. 3
            'bank_empty_field_3',                // 68. Leerfeld
            'swift_3',                           // 69. SWIFT-Code 3
            'different_account_holder_3',        // 70. Abw. Kontoinhaber 3
            'is_main_bank_account_3',            // 71. Kennz. Hauptbankverb. 3
            'bank_valid_from_3',                 // 72. Bankverb. 3 Gültig von
            'bank_valid_until_3',                // 73. Bankverb. 3 Gültig bis
            'bank_code_4',                       // 74. Bankleitzahl 4
            'bank_name_4',                       // 75. Bankbezeichung 4
            'bank_account_4',                    // 76. Bankkonto-Nummer 4
            'bank_country_4',                    // 77. Länderkennzeichen 4
            'iban_4',                            // 78. IBAN-Nr. 4
            'bank_empty_field_4',                // 79. Leerfeld
            'swift_4',                           // 80. SWIFT-Code 4
            'different_account_holder_4',        // 81. Abw. Kontoinhaber 4
            'is_main_bank_account_4',            // 82. Kennz. Hauptbankverb. 4
            'bank_valid_from_4',                 // 83. Bankverb. 4 Gültig von
            'bank_valid_until_4',                // 84. Bankverb. 4 Gültig bis
            'bank_code_5',                       // 85. Bankleitzahl 5
            'bank_name_5',                       // 86. Bankbezeichung 5
            'bank_account_5',                    // 87. Bankkonto-Nummer 5
            'bank_country_5',                    // 88. Länderkennzeichen 5
            'iban_5',                            // 89. IBAN-Nr. 5
            'bank_empty_field_5',                // 90. Leerfeld
            'swift_5',                           // 91. SWIFT-Code 5
            'different_account_holder_5',        // 92. Abw. Kontoinhaber 5
            'is_main_bank_account_5',            // 93. Kennz. Hauptbankverb. 5
            'bank_valid_from_5',                 // 94. Bankverb. 5 Gültig von
            'bank_valid_until_5',                // 95. Bankverb. 5 Gültig bis
            'empty_field_96',                    // 96. Leerfeld
            'letter_salutation',                 // 97. Briefanrede
            'greeting_formula',                  // 98. Grußformel
            'customer_number',                   // 99. Kundennummer
            'tax_number',                        // 100. Steuernummer
            'language',                          // 101. Sprache
            'contact_person',                    // 102. Ansprechpartner
            'representative',                    // 103. Vertreter
            'clerk',                             // 104. Sachbearbeiter
            'diverse_account',                   // 105. Diverse-Konto
            'output_medium',                     // 106. Ausgabeziel
            'currency_control',                  // 107. Währungssteuerung
            'credit_limit',                      // 108. Kreditlimit (Debitor)
            'payment_condition',                 // 109. Zahlungsbedingung
            'debtor_due_days',                   // 110. Fälligkeit in Tagen (Debitor)
            'debtor_discount_percent',           // 111. Skonto in Prozent (Debitor)
            'creditor_target_1_days',            // 112. Kreditoren-Ziel 1 (Tage)
            'creditor_discount_1_percent',       // 113. Kreditoren-Skonto 1 (%)
            'creditor_target_2_days',            // 114. Kreditoren-Ziel 2 (Tage)
            'creditor_discount_2_percent',       // 115. Kreditoren-Skonto 2 (%)
            'creditor_target_3_gross_days',      // 116. Kreditoren-Ziel 3 Brutto (Tage)
            'creditor_target_4_days',            // 117. Kreditoren-Ziel 4 (Tage)
            'creditor_discount_4_percent',       // 118. Kreditoren-Skonto 4 (%)
            'creditor_target_5_days',            // 119. Kreditoren-Ziel 5 (Tage)
            'creditor_discount_5_percent',       // 120. Kreditoren-Skonto 5 (%)
            'reminder',                          // 121. Mahnung
            'account_statement',                 // 122. Kontoauszug
            'reminder_text_1',                   // 123. Mahntext 1
            'reminder_text_2',                   // 124. Mahntext 2
            'reminder_text_3',                   // 125. Mahntext 3
            'account_statement_text',            // 126. Kontoauszugstest
            'reminder_limit_amount',             // 127. Mahnlimit Betrag
            'reminder_limit_percent',            // 128. Mahnlimit %
            'interest_calculation',              // 129. Zinsberechnung
            'interest_rate_1',                   // 130. Mahnzinssatz 1
            'interest_rate_2',                   // 131. Mahnzinssatz 2
            'interest_rate_3',                   // 132. Mahnzinssatz 3
            'direct_debit',                      // 133. Lastschrift
            'empty_field_134',                   // 134. Leerfeld
            'client_bank',                       // 135. Mandantenbank
            'payment_carrier',                   // 136. Zahlungsträger
            'ind_field_1',                       // 137. Indiv. Feld 1
            'ind_field_2',                       // 138. Indiv. Feld 2
            'ind_field_3',                       // 139. Indiv. Feld 3
            'ind_field_4',                       // 140. Indiv. Feld 4
            'ind_field_5',                       // 141. Indiv. Feld 5
            'ind_field_6',                       // 142. Indiv. Feld 6
            'ind_field_7',                       // 143. Indiv. Feld 7
            'ind_field_8',                       // 144. Indiv. Feld 8
            'ind_field_9',                       // 145. Indiv. Feld 9
            'ind_field_10',                      // 146. Indiv. Feld 10
            'ind_field_11',                      // 147. Indiv. Feld 11
            'ind_field_12',                      // 148. Indiv. Feld 12
            'ind_field_13',                      // 149. Indiv. Feld 13
            'ind_field_14',                      // 150. Indiv. Feld 14
            'ind_field_15',                      // 151. Indiv. Feld 15
            'alt_salutation_invoice',            // 152. Abweichende Anrede (Rechnungsadresse)
            'address_type_invoice',              // 153. Adressart (Rechnungsadresse)
            'street_invoice',                    // 154. Straße (Rechnungsadresse)
            'pob_invoice',                       // 155. Postfach (Rechnungsadresse)
            'postal_code_invoice',               // 156. Postleitzahl (Rechnungsadresse)
            'city_invoice',                      // 157. Ort (Rechnungsadresse)
            'country_invoice',                   // 158. Land (Rechnungsadresse)
            'additional_delivery_invoice',       // 159. Versandzusatz (Rechnungsadresse)
            'additional_address_invoice',        // 160. Adresszusatz (Rechnungsadresse)
            'alt_delivery_1_invoice',            // 161. Abw. Zustellbezeichung 1 (Rechnungsadresse)
            'alt_delivery_2_invoice',            // 162. Abw. Zustellbezeichung 2 (Rechnungsadresse)
            'address_valid_from_invoice',        // 163. Adresse Gültig von (Rechnungsadresse)
            'address_valid_until_invoice',       // 164. Adresse Gültig bis (Rechnungsadresse)
            'bank_code_6',                       // 165. Bankleitzahl 6
            'bank_name_6',                       // 166. Bankbezeichung 6
            'bank_account_6',                    // 167. Bankkonto-Nummer 6
            'bank_country_6',                    // 168. Länderkennzeichen 6
            'iban_6',                            // 169. IBAN-Nr. 6
            'bank_empty_field_6',                // 170. Leerfeld
            'swift_6',                           // 171. SWIFT-Code 6
            'different_account_holder_6',        // 172. Abw. Kontoinhaber 6
            'is_main_bank_account_6',            // 173. Kennz. Hauptbankverb. 6
            'bank_valid_from_6',                 // 174. Bankverb. 6 Gültig von
            'bank_valid_until_6',                // 175. Bankverb. 6 Gültig bis
            'bank_code_7',                       // 176. Bankleitzahl 7
            'bank_name_7',                       // 177. Bankbezeichung 7
            'bank_account_7',                    // 178. Bankkonto-Nummer 7
            'bank_country_7',                    // 179. Länderkennzeichen 7
            'iban_7',                            // 180. IBAN-Nr. 7
            'bank_empty_field_7',                // 181. Leerfeld
            'swift_7',                           // 182. SWIFT-Code 7
            'different_account_holder_7',        // 183. Abw. Kontoinhaber 7
            'is_main_bank_account_7',            // 184. Kennz. Hauptbankverb. 7
            'bank_valid_from_7',                 // 185. Bankverb. 7 Gültig von
            'bank_valid_until_7',                // 186. Bankverb. 7 Gültig bis
            'bank_code_8',                       // 187. Bankleitzahl 8
            'bank_name_8',                       // 188. Bankbezeichung 8
            'bank_account_8',                    // 189. Bankkonto-Nummer 8
            'bank_country_8',                    // 190. Länderkennzeichen 8
            'iban_8',                            // 191. IBAN-Nr. 8
            'bank_empty_field_8',                // 192. Leerfeld
            'swift_8',                           // 193. SWIFT-Code 8
            'different_account_holder_8',        // 194. Abw. Kontoinhaber 8
            'is_main_bank_account_8',            // 195. Kennz. Hauptbankverb. 8
            'bank_valid_from_8',                 // 196. Bankverb. 8 Gültig von
            'bank_valid_until_8',                // 197. Bankverb. 8 Gültig bis
            'bank_code_9',                       // 198. Bankleitzahl 9
            'bank_name_9',                       // 199. Bankbezeichung 9
            'bank_account_9',                    // 200. Bankkonto-Nummer 9
            'bank_country_9',                    // 201. Länderkennzeichen 9
            'iban_9',                            // 202. IBAN-Nr. 9
            'bank_empty_field_9',                // 203. Leerfeld
            'swift_9',                           // 204. SWIFT-Code 9
            'different_account_holder_9',        // 205. Abw. Kontoinhaber 9
            'is_main_bank_account_9',            // 206. Kennz. Hauptbankverb. 9
            'bank_valid_from_9',                 // 207. Bankverb. 9 Gültig von
            'bank_valid_until_9',                // 208. Bankverb. 9 Gültig bis
            'bank_code_10',                      // 209. Bankleitzahl 10
            'bank_name_10',                      // 210. Bankbezeichung 10
            'bank_account_10',                   // 211. Bankkonto-Nummer 10
            'bank_country_10',                   // 212. Länderkennzeichen 10
            'iban_10',                           // 213. IBAN-Nr. 10
            'bank_empty_field_10',               // 214. Leerfeld
            'swift_10',                          // 215. SWIFT-Code 10
            'different_account_holder_10',       // 216. Abw. Kontoinhaber 10
            'is_main_bank_account_10',           // 217. Kennz. Hauptbankverb. 10
            'bank_valid_from_10',                // 218. Bankverb. 10 Gültig von
            'bank_valid_until_10',               // 219. Bankverb. 10 Gültig bis
            'external_system_number',            // 220. Nummer Fremdsystem
            'insolvent',                         // 221. Insolvent
            'sepa_mandate_reference_1',          // 222. SEPA-Mandatsreferenz 1
            'sepa_mandate_reference_2',          // 223. SEPA-Mandatsreferenz 2
            'sepa_mandate_reference_3',          // 224. SEPA-Mandatsreferenz 3
            'sepa_mandate_reference_4',          // 225. SEPA-Mandatsreferenz 4
            'sepa_mandate_reference_5',          // 226. SEPA-Mandatsreferenz 5
            'sepa_mandate_reference_6',          // 227. SEPA-Mandatsreferenz 6
            'sepa_mandate_reference_7',          // 228. SEPA-Mandatsreferenz 7
            'sepa_mandate_reference_8',          // 229. SEPA-Mandatsreferenz 8
            'sepa_mandate_reference_9',          // 230. SEPA-Mandatsreferenz 9
            'sepa_mandate_reference_10',         // 231. SEPA-Mandatsreferenz 10
            'linked_account',                    // 232. Verknüpftes OPOS-Konto
            'reminder_block_until',              // 233. Mahnsperre bis
            'direct_debit_block_until',          // 234. Lastschriftsperre bis
            'payment_block_until',               // 235. Zahlungssperre bis
            'fee_calculation',                   // 236. Gebührenberechnung
            'reminder_fee_1',                    // 237. Mahngebühr 1
            'reminder_fee_2',                    // 238. Mahngebühr 2
            'reminder_fee_3',                    // 239. Mahngebühr 3
            'default_payment_calculation',       // 240. Pauschalenberechnung
            'default_payment_1',                 // 241. Verzugspauschale 1
            'default_payment_2',                 // 242. Verzugspauschale 2
            'default_payment_3',                 // 243. Verzugspauschale 3
            'alternative_search_name',           // 244. Alternativer Suchname
            'status',                            // 245. Status
            'address_manually_changed',          // 246. Anschrift manuell geändert (Korrespondenzadresse)
            'address_individual',                // 247. Anschrift individuell (Korrespondenzadresse)
            'address_manually_changed_invoice',  // 248. Anschrift manuell geändert (Rechnungsadresse)
            'address_individual_invoice',        // 249. Anschrift individuell (Rechnungsadresse)
            'deadline_calculation_debtor',       // 250. Fristberechnung bei Debitor
            'reminder_deadline_1',               // 251. Mahnfrist 1
            'reminder_deadline_2',               // 252. Mahnfrist 2
            'reminder_deadline_3',               // 253. Mahnfrist 3
            'last_deadline'                      // 254. Letzte Frist
        ];
    }

    // Fluent setters for basic address fields
    public function setAccountNumber(string $value): self { $this->fields['account_number'] = $value; return $this; }
    public function setCompanyName(string $value): self { $this->fields['company_name'] = $value; return $this; }
    public function setBusinessPurpose(string $value): self { $this->fields['business_purpose'] = $value; return $this; }
    public function setPersonLastName(string $value): self { $this->fields['person_last_name'] = $value; return $this; }
    public function setPersonFirstName(string $value): self { $this->fields['person_first_name'] = $value; return $this; }
    public function setUnknownLastName(string $value): self { $this->fields['unknown_last_name'] = $value; return $this; }
    public function setPartyType(string $value): self { $this->fields['party_type'] = $value; return $this; }
    public function setShortName(string $value): self { $this->fields['short_name'] = $value; return $this; }
    public function setEuCountry(string $value): self { $this->fields['eu_country'] = $value; return $this; }
    public function setEuVatId(string $value): self { $this->fields['eu_vat_id'] = $value; return $this; }
    public function setSalutation(string $value): self { $this->fields['salutation'] = $value; return $this; }
    public function setTitle(string $value): self { $this->fields['title'] = $value; return $this; }
    public function setNobilityTitle(string $value): self { $this->fields['nobility_title'] = $value; return $this; }
    public function setPrefix(string $value): self { $this->fields['prefix'] = $value; return $this; }
    public function setAddressType(string $value): self { $this->fields['address_type'] = $value; return $this; }
    public function setStreet(string $value): self { $this->fields['street'] = $value; return $this; }
    public function setPob(string $value): self { $this->fields['pob'] = $value; return $this; }
    public function setPostalCode(string $value): self { $this->fields['postal_code'] = $value; return $this; }
    public function setCity(string $value): self { $this->fields['city'] = $value; return $this; }
    public function setCountry(string $value): self { $this->fields['country'] = $value; return $this; }
    public function setAdditionalDelivery(string $value): self { $this->fields['additional_delivery'] = $value; return $this; }
    public function setAdditionalAddress(string $value): self { $this->fields['additional_address'] = $value; return $this; }
    public function setAltSalutation(string $value): self { $this->fields['alt_salutation'] = $value; return $this; }
    public function setAltDelivery1(string $value): self { $this->fields['alt_delivery_1'] = $value; return $this; }
    public function setAltDelivery2(string $value): self { $this->fields['alt_delivery_2'] = $value; return $this; }
    public function setIsCorrespondenceAddress(string $value): self { $this->fields['is_correspondence_address'] = $value; return $this; }
    public function setAddressValidFrom(string $value): self { $this->fields['address_valid_from'] = $value; return $this; }
    public function setAddressValidUntil(string $value): self { $this->fields['address_valid_until'] = $value; return $this; }
    public function setPhone(string $value): self { $this->fields['phone'] = $value; return $this; }
    public function setPhoneNote(string $value): self { $this->fields['phone_note'] = $value; return $this; }
    public function setExecPhone(string $value): self { $this->fields['exec_phone'] = $value; return $this; }
    public function setExecPhoneNote(string $value): self { $this->fields['exec_phone_note'] = $value; return $this; }
    public function setEmail(string $value): self { $this->fields['email'] = $value; return $this; }
    public function setEmailNote(string $value): self { $this->fields['email_note'] = $value; return $this; }
    public function setWebsite(string $value): self { $this->fields['website'] = $value; return $this; }
    public function setWebsiteNote(string $value): self { $this->fields['website_note'] = $value; return $this; }
    public function setFax(string $value): self { $this->fields['fax'] = $value; return $this; }
    public function setFaxNote(string $value): self { $this->fields['fax_note'] = $value; return $this; }
    public function setOtherContact(string $value): self { $this->fields['other_contact'] = $value; return $this; }
    public function setOtherContactNote(string $value): self { $this->fields['other_contact_note'] = $value; return $this; }

    // Bank account 1
    public function setBankCode1(string $value): self { $this->fields['bank_code_1'] = $value; return $this; }
    public function setBankName1(string $value): self { $this->fields['bank_name_1'] = $value; return $this; }
    public function setBankAccount1(string $value): self { $this->fields['bank_account_1'] = $value; return $this; }
    public function setBankCountry1(string $value): self { $this->fields['bank_country_1'] = $value; return $this; }
    public function setIban1(string $value): self { $this->fields['iban_1'] = $value; return $this; }
    public function setSwift1(string $value): self { $this->fields['swift_1'] = $value; return $this; }
    public function setDifferentAccountHolder1(string $value): self { $this->fields['different_account_holder_1'] = $value; return $this; }
    public function setIsMainBankAccount1(string $value): self { $this->fields['is_main_bank_account_1'] = $value; return $this; }
    public function setBankValidFrom1(string $value): self { $this->fields['bank_valid_from_1'] = $value; return $this; }
    public function setBankValidUntil1(string $value): self { $this->fields['bank_valid_until_1'] = $value; return $this; }

    // Bank account 2
    public function setBankCode2(string $value): self { $this->fields['bank_code_2'] = $value; return $this; }
    public function setBankName2(string $value): self { $this->fields['bank_name_2'] = $value; return $this; }
    public function setBankAccount2(string $value): self { $this->fields['bank_account_2'] = $value; return $this; }
    public function setBankCountry2(string $value): self { $this->fields['bank_country_2'] = $value; return $this; }
    public function setIban2(string $value): self { $this->fields['iban_2'] = $value; return $this; }
    public function setSwift2(string $value): self { $this->fields['swift_2'] = $value; return $this; }
    public function setDifferentAccountHolder2(string $value): self { $this->fields['different_account_holder_2'] = $value; return $this; }
    public function setIsMainBankAccount2(string $value): self { $this->fields['is_main_bank_account_2'] = $value; return $this; }
    public function setBankValidFrom2(string $value): self { $this->fields['bank_valid_from_2'] = $value; return $this; }
    public function setBankValidUntil2(string $value): self { $this->fields['bank_valid_until_2'] = $value; return $this; }

    // Bank account 3
    public function setBankCode3(string $value): self { $this->fields['bank_code_3'] = $value; return $this; }
    public function setBankName3(string $value): self { $this->fields['bank_name_3'] = $value; return $this; }
    public function setBankAccount3(string $value): self { $this->fields['bank_account_3'] = $value; return $this; }
    public function setBankCountry3(string $value): self { $this->fields['bank_country_3'] = $value; return $this; }
    public function setIban3(string $value): self { $this->fields['iban_3'] = $value; return $this; }
    public function setSwift3(string $value): self { $this->fields['swift_3'] = $value; return $this; }
    public function setDifferentAccountHolder3(string $value): self { $this->fields['different_account_holder_3'] = $value; return $this; }
    public function setIsMainBankAccount3(string $value): self { $this->fields['is_main_bank_account_3'] = $value; return $this; }
    public function setBankValidFrom3(string $value): self { $this->fields['bank_valid_from_3'] = $value; return $this; }
    public function setBankValidUntil3(string $value): self { $this->fields['bank_valid_until_3'] = $value; return $this; }

    // Bank account 4
    public function setBankCode4(string $value): self { $this->fields['bank_code_4'] = $value; return $this; }
    public function setBankName4(string $value): self { $this->fields['bank_name_4'] = $value; return $this; }
    public function setBankAccount4(string $value): self { $this->fields['bank_account_4'] = $value; return $this; }
    public function setBankCountry4(string $value): self { $this->fields['bank_country_4'] = $value; return $this; }
    public function setIban4(string $value): self { $this->fields['iban_4'] = $value; return $this; }
    public function setSwift4(string $value): self { $this->fields['swift_4'] = $value; return $this; }
    public function setDifferentAccountHolder4(string $value): self { $this->fields['different_account_holder_4'] = $value; return $this; }
    public function setIsMainBankAccount4(string $value): self { $this->fields['is_main_bank_account_4'] = $value; return $this; }
    public function setBankValidFrom4(string $value): self { $this->fields['bank_valid_from_4'] = $value; return $this; }
    public function setBankValidUntil4(string $value): self { $this->fields['bank_valid_until_4'] = $value; return $this; }

    // Bank account 5
    public function setBankCode5(string $value): self { $this->fields['bank_code_5'] = $value; return $this; }
    public function setBankName5(string $value): self { $this->fields['bank_name_5'] = $value; return $this; }
    public function setBankAccount5(string $value): self { $this->fields['bank_account_5'] = $value; return $this; }
    public function setBankCountry5(string $value): self { $this->fields['bank_country_5'] = $value; return $this; }
    public function setIban5(string $value): self { $this->fields['iban_5'] = $value; return $this; }
    public function setSwift5(string $value): self { $this->fields['swift_5'] = $value; return $this; }
    public function setDifferentAccountHolder5(string $value): self { $this->fields['different_account_holder_5'] = $value; return $this; }
    public function setIsMainBankAccount5(string $value): self { $this->fields['is_main_bank_account_5'] = $value; return $this; }
    public function setBankValidFrom5(string $value): self { $this->fields['bank_valid_from_5'] = $value; return $this; }
    public function setBankValidUntil5(string $value): self { $this->fields['bank_valid_until_5'] = $value; return $this; }

    // Additional fields after bank accounts
    public function setLetterSalutation(string $value): self { $this->fields['letter_salutation'] = $value; return $this; }
    public function setGreetingFormula(string $value): self { $this->fields['greeting_formula'] = $value; return $this; }
    public function setCustomerNumber(string $value): self { $this->fields['customer_number'] = $value; return $this; }
    public function setTaxNumber(string $value): self { $this->fields['tax_number'] = $value; return $this; }
    public function setLanguage(string $value): self { $this->fields['language'] = $value; return $this; }
    public function setContactPerson(string $value): self { $this->fields['contact_person'] = $value; return $this; }
    public function setRepresentative(string $value): self { $this->fields['representative'] = $value; return $this; }
    public function setClerk(string $value): self { $this->fields['clerk'] = $value; return $this; }
    public function setDiverseAccount(string $value): self { $this->fields['diverse_account'] = $value; return $this; }
    public function setOutputMedium(string $value): self { $this->fields['output_medium'] = $value; return $this; }
    public function setCurrencyControl(string $value): self { $this->fields['currency_control'] = $value; return $this; }
    public function setCreditLimit(string $value): self { $this->fields['credit_limit'] = $value; return $this; }
    public function setPaymentCondition(string $value): self { $this->fields['payment_condition'] = $value; return $this; }
    public function setDebtorDueDays(string $value): self { $this->fields['debtor_due_days'] = $value; return $this; }
    public function setDebtorDiscountPercent(string $value): self { $this->fields['debtor_discount_percent'] = $value; return $this; }
    public function setCreditorTarget1Days(string $value): self { $this->fields['creditor_target_1_days'] = $value; return $this; }
    public function setCreditorDiscount1Percent(string $value): self { $this->fields['creditor_discount_1_percent'] = $value; return $this; }
    public function setCreditorTarget2Days(string $value): self { $this->fields['creditor_target_2_days'] = $value; return $this; }
    public function setCreditorDiscount2Percent(string $value): self { $this->fields['creditor_discount_2_percent'] = $value; return $this; }
    public function setCreditorTarget3GrossDays(string $value): self { $this->fields['creditor_target_3_gross_days'] = $value; return $this; }
    public function setCreditorTarget4Days(string $value): self { $this->fields['creditor_target_4_days'] = $value; return $this; }
    public function setCreditorDiscount4Percent(string $value): self { $this->fields['creditor_discount_4_percent'] = $value; return $this; }
    public function setCreditorTarget5Days(string $value): self { $this->fields['creditor_target_5_days'] = $value; return $this; }
    public function setCreditorDiscount5Percent(string $value): self { $this->fields['creditor_discount_5_percent'] = $value; return $this; }

    // Reminder settings
    public function setReminder(string $value): self { $this->fields['reminder'] = $value; return $this; }
    public function setAccountStatement(string $value): self { $this->fields['account_statement'] = $value; return $this; }
    public function setReminderText1(string $value): self { $this->fields['reminder_text_1'] = $value; return $this; }
    public function setReminderText2(string $value): self { $this->fields['reminder_text_2'] = $value; return $this; }
    public function setReminderText3(string $value): self { $this->fields['reminder_text_3'] = $value; return $this; }
    public function setAccountStatementText(string $value): self { $this->fields['account_statement_text'] = $value; return $this; }
    public function setReminderLimitAmount(string $value): self { $this->fields['reminder_limit_amount'] = $value; return $this; }
    public function setReminderLimitPercent(string $value): self { $this->fields['reminder_limit_percent'] = $value; return $this; }
    public function setInterestCalculation(string $value): self { $this->fields['interest_calculation'] = $value; return $this; }
    public function setInterestRate1(string $value): self { $this->fields['interest_rate_1'] = $value; return $this; }
    public function setInterestRate2(string $value): self { $this->fields['interest_rate_2'] = $value; return $this; }
    public function setInterestRate3(string $value): self { $this->fields['interest_rate_3'] = $value; return $this; }

    // Payment processing
    public function setDirectDebit(string $value): self { $this->fields['direct_debit'] = $value; return $this; }
    public function setClientBank(string $value): self { $this->fields['client_bank'] = $value; return $this; }
    public function setPaymentCarrier(string $value): self { $this->fields['payment_carrier'] = $value; return $this; }

    // Individual fields
    public function setIndField1(string $value): self { $this->fields['ind_field_1'] = $value; return $this; }
    public function setIndField2(string $value): self { $this->fields['ind_field_2'] = $value; return $this; }
    public function setIndField3(string $value): self { $this->fields['ind_field_3'] = $value; return $this; }
    public function setIndField4(string $value): self { $this->fields['ind_field_4'] = $value; return $this; }
    public function setIndField5(string $value): self { $this->fields['ind_field_5'] = $value; return $this; }
    public function setIndField6(string $value): self { $this->fields['ind_field_6'] = $value; return $this; }
    public function setIndField7(string $value): self { $this->fields['ind_field_7'] = $value; return $this; }
    public function setIndField8(string $value): self { $this->fields['ind_field_8'] = $value; return $this; }
    public function setIndField9(string $value): self { $this->fields['ind_field_9'] = $value; return $this; }
    public function setIndField10(string $value): self { $this->fields['ind_field_10'] = $value; return $this; }
    public function setIndField11(string $value): self { $this->fields['ind_field_11'] = $value; return $this; }
    public function setIndField12(string $value): self { $this->fields['ind_field_12'] = $value; return $this; }
    public function setIndField13(string $value): self { $this->fields['ind_field_13'] = $value; return $this; }
    public function setIndField14(string $value): self { $this->fields['ind_field_14'] = $value; return $this; }
    public function setIndField15(string $value): self { $this->fields['ind_field_15'] = $value; return $this; }

    // Invoice address fields
    public function setAltSalutationInvoice(string $value): self { $this->fields['alt_salutation_invoice'] = $value; return $this; }
    public function setAddressTypeInvoice(string $value): self { $this->fields['address_type_invoice'] = $value; return $this; }
    public function setStreetInvoice(string $value): self { $this->fields['street_invoice'] = $value; return $this; }
    public function setPobInvoice(string $value): self { $this->fields['pob_invoice'] = $value; return $this; }
    public function setPostalCodeInvoice(string $value): self { $this->fields['postal_code_invoice'] = $value; return $this; }
    public function setCityInvoice(string $value): self { $this->fields['city_invoice'] = $value; return $this; }
    public function setCountryInvoice(string $value): self { $this->fields['country_invoice'] = $value; return $this; }
    public function setAdditionalDeliveryInvoice(string $value): self { $this->fields['additional_delivery_invoice'] = $value; return $this; }
    public function setAdditionalAddressInvoice(string $value): self { $this->fields['additional_address_invoice'] = $value; return $this; }
    public function setAltDelivery1Invoice(string $value): self { $this->fields['alt_delivery_1_invoice'] = $value; return $this; }
    public function setAltDelivery2Invoice(string $value): self { $this->fields['alt_delivery_2_invoice'] = $value; return $this; }
    public function setAddressValidFromInvoice(string $value): self { $this->fields['address_valid_from_invoice'] = $value; return $this; }
    public function setAddressValidUntilInvoice(string $value): self { $this->fields['address_valid_until_invoice'] = $value; return $this; }

    // Bank account 6
    public function setBankCode6(string $value): self { $this->fields['bank_code_6'] = $value; return $this; }
    public function setBankName6(string $value): self { $this->fields['bank_name_6'] = $value; return $this; }
    public function setBankAccount6(string $value): self { $this->fields['bank_account_6'] = $value; return $this; }
    public function setBankCountry6(string $value): self { $this->fields['bank_country_6'] = $value; return $this; }
    public function setIban6(string $value): self { $this->fields['iban_6'] = $value; return $this; }
    public function setSwift6(string $value): self { $this->fields['swift_6'] = $value; return $this; }
    public function setDifferentAccountHolder6(string $value): self { $this->fields['different_account_holder_6'] = $value; return $this; }
    public function setIsMainBankAccount6(string $value): self { $this->fields['is_main_bank_account_6'] = $value; return $this; }
    public function setBankValidFrom6(string $value): self { $this->fields['bank_valid_from_6'] = $value; return $this; }
    public function setBankValidUntil6(string $value): self { $this->fields['bank_valid_until_6'] = $value; return $this; }

    // Bank account 7
    public function setBankCode7(string $value): self { $this->fields['bank_code_7'] = $value; return $this; }
    public function setBankName7(string $value): self { $this->fields['bank_name_7'] = $value; return $this; }
    public function setBankAccount7(string $value): self { $this->fields['bank_account_7'] = $value; return $this; }
    public function setBankCountry7(string $value): self { $this->fields['bank_country_7'] = $value; return $this; }
    public function setIban7(string $value): self { $this->fields['iban_7'] = $value; return $this; }
    public function setSwift7(string $value): self { $this->fields['swift_7'] = $value; return $this; }
    public function setDifferentAccountHolder7(string $value): self { $this->fields['different_account_holder_7'] = $value; return $this; }
    public function setIsMainBankAccount7(string $value): self { $this->fields['is_main_bank_account_7'] = $value; return $this; }
    public function setBankValidFrom7(string $value): self { $this->fields['bank_valid_from_7'] = $value; return $this; }
    public function setBankValidUntil7(string $value): self { $this->fields['bank_valid_until_7'] = $value; return $this; }

    // Bank account 8
    public function setBankCode8(string $value): self { $this->fields['bank_code_8'] = $value; return $this; }
    public function setBankName8(string $value): self { $this->fields['bank_name_8'] = $value; return $this; }
    public function setBankAccount8(string $value): self { $this->fields['bank_account_8'] = $value; return $this; }
    public function setBankCountry8(string $value): self { $this->fields['bank_country_8'] = $value; return $this; }
    public function setIban8(string $value): self { $this->fields['iban_8'] = $value; return $this; }
    public function setSwift8(string $value): self { $this->fields['swift_8'] = $value; return $this; }
    public function setDifferentAccountHolder8(string $value): self { $this->fields['different_account_holder_8'] = $value; return $this; }
    public function setIsMainBankAccount8(string $value): self { $this->fields['is_main_bank_account_8'] = $value; return $this; }
    public function setBankValidFrom8(string $value): self { $this->fields['bank_valid_from_8'] = $value; return $this; }
    public function setBankValidUntil8(string $value): self { $this->fields['bank_valid_until_8'] = $value; return $this; }

    // Bank account 9
    public function setBankCode9(string $value): self { $this->fields['bank_code_9'] = $value; return $this; }
    public function setBankName9(string $value): self { $this->fields['bank_name_9'] = $value; return $this; }
    public function setBankAccount9(string $value): self { $this->fields['bank_account_9'] = $value; return $this; }
    public function setBankCountry9(string $value): self { $this->fields['bank_country_9'] = $value; return $this; }
    public function setIban9(string $value): self { $this->fields['iban_9'] = $value; return $this; }
    public function setSwift9(string $value): self { $this->fields['swift_9'] = $value; return $this; }
    public function setDifferentAccountHolder9(string $value): self { $this->fields['different_account_holder_9'] = $value; return $this; }
    public function setIsMainBankAccount9(string $value): self { $this->fields['is_main_bank_account_9'] = $value; return $this; }
    public function setBankValidFrom9(string $value): self { $this->fields['bank_valid_from_9'] = $value; return $this; }
    public function setBankValidUntil9(string $value): self { $this->fields['bank_valid_until_9'] = $value; return $this; }

    // Bank account 10
    public function setBankCode10(string $value): self { $this->fields['bank_code_10'] = $value; return $this; }
    public function setBankName10(string $value): self { $this->fields['bank_name_10'] = $value; return $this; }
    public function setBankAccount10(string $value): self { $this->fields['bank_account_10'] = $value; return $this; }
    public function setBankCountry10(string $value): self { $this->fields['bank_country_10'] = $value; return $this; }
    public function setIban10(string $value): self { $this->fields['iban_10'] = $value; return $this; }
    public function setSwift10(string $value): self { $this->fields['swift_10'] = $value; return $this; }
    public function setDifferentAccountHolder10(string $value): self { $this->fields['different_account_holder_10'] = $value; return $this; }
    public function setIsMainBankAccount10(string $value): self { $this->fields['is_main_bank_account_10'] = $value; return $this; }
    public function setBankValidFrom10(string $value): self { $this->fields['bank_valid_from_10'] = $value; return $this; }
    public function setBankValidUntil10(string $value): self { $this->fields['bank_valid_until_10'] = $value; return $this; }

    // SEPA information
    public function setExternalSystemNumber(string $value): self { $this->fields['external_system_number'] = $value; return $this; }
    public function setInsolvent(string $value): self { $this->fields['insolvent'] = $value; return $this; }
    public function setSepaMandate1(string $value): self { $this->fields['sepa_mandate_reference_1'] = $value; return $this; }
    public function setSepaMandate2(string $value): self { $this->fields['sepa_mandate_reference_2'] = $value; return $this; }
    public function setSepaMandate3(string $value): self { $this->fields['sepa_mandate_reference_3'] = $value; return $this; }
    public function setSepaMandate4(string $value): self { $this->fields['sepa_mandate_reference_4'] = $value; return $this; }
    public function setSepaMandate5(string $value): self { $this->fields['sepa_mandate_reference_5'] = $value; return $this; }
    public function setSepaMandate6(string $value): self { $this->fields['sepa_mandate_reference_6'] = $value; return $this; }
    public function setSepaMandate7(string $value): self { $this->fields['sepa_mandate_reference_7'] = $value; return $this; }
    public function setSepaMandate8(string $value): self { $this->fields['sepa_mandate_reference_8'] = $value; return $this; }
    public function setSepaMandate9(string $value): self { $this->fields['sepa_mandate_reference_9'] = $value; return $this; }
    public function setSepaMandate10(string $value): self { $this->fields['sepa_mandate_reference_10'] = $value; return $this; }

    // Linked accounts and block information
    public function setLinkedAccount(string $value): self { $this->fields['linked_account'] = $value; return $this; }
    public function setReminderBlockUntil(string $value): self { $this->fields['reminder_block_until'] = $value; return $this; }
    public function setDirectDebitBlockUntil(string $value): self { $this->fields['direct_debit_block_until'] = $value; return $this; }
    public function setPaymentBlockUntil(string $value): self { $this->fields['payment_block_until'] = $value; return $this; }

    // Fee calculations
    public function setFeeCalculation(string $value): self { $this->fields['fee_calculation'] = $value; return $this; }
    public function setReminderFee1(string $value): self { $this->fields['reminder_fee_1'] = $value; return $this; }
    public function setReminderFee2(string $value): self { $this->fields['reminder_fee_2'] = $value; return $this; }
    public function setReminderFee3(string $value): self { $this->fields['reminder_fee_3'] = $value; return $this; }
    public function setDefaultPaymentCalculation(string $value): self { $this->fields['default_payment_calculation'] = $value; return $this; }
    public function setDefaultPayment1(string $value): self { $this->fields['default_payment_1'] = $value; return $this; }
    public function setDefaultPayment2(string $value): self { $this->fields['default_payment_2'] = $value; return $this; }
    public function setDefaultPayment3(string $value): self { $this->fields['default_payment_3'] = $value; return $this; }

    // Search and status
    public function setAlternativeSearchName(string $value): self { $this->fields['alternative_search_name'] = $value; return $this; }
    public function setStatus(string $value): self { $this->fields['status'] = $value; return $this; }

    // Address information
    public function setAddressManuallyChanged(string $value): self { $this->fields['address_manually_changed'] = $value; return $this; }
    public function setAddressIndividual(string $value): self { $this->fields['address_individual'] = $value; return $this; }
    public function setAddressManuallyChangedInvoice(string $value): self { $this->fields['address_manually_changed_invoice'] = $value; return $this; }
    public function setAddressIndividualInvoice(string $value): self { $this->fields['address_individual_invoice'] = $value; return $this; }

    // Deadline calculations
    public function setDeadlineCalculationDebtor(string $value): self { $this->fields['deadline_calculation_debtor'] = $value; return $this; }
    public function setReminderDeadline1(string $value): self { $this->fields['reminder_deadline_1'] = $value; return $this; }
    public function setReminderDeadline2(string $value): self { $this->fields['reminder_deadline_2'] = $value; return $this; }
    public function setReminderDeadline3(string $value): self { $this->fields['reminder_deadline_3'] = $value; return $this; }
    public function setLastDeadline(string $value): self { $this->fields['last_deadline'] = $value; return $this; }