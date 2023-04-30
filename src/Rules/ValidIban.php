<?php

namespace Milwad\LaravelValidate\Rules;

use Illuminate\Contracts\Validation\Rule;
use Milwad\LaravelValidate\Utils\Country;

class ValidIban implements Rule
{
    /**
     * Character map
     *
     * @var array|int[]
     */
    private array $characterMap = [
        'A' => 10,
        'B' => 11,
        'C' => 12,
        'D' => 13,
        'E' => 14,
        'F' => 15,
        'G' => 16,
        'H' => 17,
        'I' => 18,
        'J' => 19,
        'K' => 20,
        'L' => 21,
        'M' => 22,
        'N' => 23,
        'O' => 24,
        'P' => 25,
        'Q' => 26,
        'R' => 27,
        'S' => 28,
        'T' => 29,
        'U' => 30,
        'V' => 31,
        'W' => 32,
        'X' => 33,
        'Y' => 34,
        'Z' => 35,
    ];

    /**
     * Get country code with length.
     *
     * @var array|int[]
     */
    private array $ibanLengthByCountry = [
        Country::ALBANIA => 28,
        Country::ALGERIA => 26,
        Country::ANDORRA => 24,
        Country::ANGOLA => 25,
        Country::AUSTRIA => 20,
        Country::AZERBAIJAN => 28,
        Country::BAHRAIN => 22,
        Country::BELARUS => 28,
        Country::BELGIUM => 16,
        Country::BENIN => 28,
        Country::BOSNIA_HERZEGOVINA => 20,
        Country::BRAZIL => 29,
        Country::BULGARIA => 22,
        Country::BURKINA_FASO => 28,
        Country::BURUNDI => 28,
        Country::CAMEROON => 27,
        Country::CAPE_VERDE => 25,
        Country::CENTRAL_AFRICAN_REPUBLIC => 27,
        Country::CHAD => 27,
        Country::COMOROS => 27,
        Country::CONGO => 27,
        Country::COSTA_RICA => 22,
        Country::CROATIA => 21,
        Country::CYPRUS => 28,
        Country::CZECH_REPUBLIC => 24,
        Country::DENMARK => 18,
        Country::DJIBOUTI => 27,
        Country::DOMINICAN_REPUBLIC => 28,
        Country::EGYPT => 29,
        Country::EL_SALVADOR => 28,
        Country::EQUATORIAL_GUINEA => 27,
        Country::ESTONIA => 20,
        Country::FAROE_ISLANDS => 18,
        Country::FINLAND => 18,
        Country::FRANCE => 27,
        Country::GABON => 27,
        Country::GEORGIA => 22,
        Country::GERMANY => 22,
        Country::GIBRALTAR => 23,
        Country::GREECE => 27,
        Country::GREENLAND => 18,
        Country::GUATEMALA => 28,
        Country::GUINEA_BISSAU => 25,
        Country::HOLY_SEE => 22,
        Country::HONDURAS => 28,
        Country::HUNGARY => 28,
        Country::ICELAND => 26,
        Country::IRAN => 26,
        Country::IRAQ => 23,
        Country::IRELAND => 22,
        Country::ISRAEL => 23,
        Country::ITALY => 27,
        Country::IVORY_COAST => 28,
        Country::JORDAN => 30,
        Country::KAZAKHSTAN => 20,
        Country::KOSOVO => 20,
        Country::KUWAIT => 30,
        Country::LATVIA => 21,
        Country::LEBANON => 28,
        Country::LIBYA => 25,
        Country::LIECHTENSTEIN => 21,
        Country::LITHUANIA => 20,
        Country::LUXEMBOURG => 20,
        Country::MADAGASCAR => 27,
        Country::MALI => 28,
        Country::MALTA => 31,
        Country::MAURITANIA => 27,
        Country::MAURITIUS => 30,
        Country::MOLDOVA => 24,
        Country::MONACO => 27,
        Country::MONGOLIA => 20,
        Country::MONTENEGRO => 22,
        Country::MOROCCO => 28,
        Country::MOZAMBIQUE => 25,
        Country::NETHERLANDS => 18,
        Country::NICARAGUA => 32,
        Country::NIGER => 28,
        Country::NORTH_MACEDONIA => 19,
        Country::NORWAY => 15,
        Country::PAKISTAN => 24,
        Country::PALESTINE => 29,
        Country::POLAND => 28,
        Country::PORTUGAL => 25,
        Country::QATAR => 29,
        Country::ROMANIA => 24,
        Country::RUSSIA => 33,
        Country::SAINT_LUCIA => 32,
        Country::SAN_MARINO => 27,
        Country::SAO_TOME_PRINCIPE => 25,
        Country::SAUDI_ARABIA => 24,
        Country::SENEGAL => 28,
        Country::SERBIA => 22,
        Country::SEYCHELLES => 31,
        Country::SLOVAKIA => 24,
        Country::SLOVENIA => 19,
        Country::SOMALIA => 23,
        Country::SPAIN => 24,
        Country::SUDAN => 18,
        Country::SWEDEN => 24,
        Country::SWITZERLAND => 21,
        Country::TIMOR_LESTE => 23,
        Country::TOGO => 28,
        Country::TUNISIA => 24,
        Country::TURKEY => 26,
        Country::UKRAINE => 29,
        Country::UNITED_ARAB_EMIRATES => 23,
        Country::UNITED_KINGDOM => 22,
        Country::VIRGIN_ISLANDS_BRITISH => 24,
    ];

    /**
     * Set multiple country codes to validate IBAN (Optional).
     *
     * @var array
     */
    private array $countries;

    public function __construct(array|string $countries = [])
    {
        $this->setCountries(func_get_args());
    }

    /**
     * Check IBAN.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->isIbanValid($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validate.iban');
    }

    /**
     * Set value of $countries property.
     *
     * @return void
     */
    private function setCountries(array|null $countries)
    {
        if (empty($countries)) {
            $this->countries = [];
            return;
        }

        if (is_array($countries[0])) {
            $countries = $countries[0];
        }

        foreach ($countries as $country) {
            $this->countries[] = $country;
        }
    }


    /**
     * Check IBAN is valid.
     *
     * @return bool
     */
    private function isIbanValid(string $iban)
    {
        if (! $this->checkIbanFormat($iban)) {
            return false;
        }

        /*
         * Connect Iban title with value (code) ex: 8330001234567NO .
         */
        $parsedIban = substr($iban, 4).substr($iban, 0, 4);

        /*
         * Replace iban value with character map.
         */
        $parsedIban = strtr($parsedIban, $this->characterMap);

        return bcmod($parsedIban, '97') === '1';
    }

    /**
     * Check IBAN format is valid.
     *
     * @return bool
     */
    private function checkIbanFormat(string $iban)
    {
        if (empty($iban)) {
            return false;
        }

        $ibanCountryCode = $this->getIbanCountryCode($iban);

        return !(empty($this->checkIfBcmodIsAvailable())
            || !$this->twoFirstCharactersValid($ibanCountryCode)
            || !$this->isCountriesValid($ibanCountryCode)
            || !$this->isIbanLengthValid($iban, $ibanCountryCode));
    }

    /**
     * Get IBAN country code.
     *
     * @return string
     */
    private function getIbanCountryCode(string $iban)
    {
        return substr($iban, 0, 2);
    }

    /**
     * Check if bcmod function is available.
     *
     * @return bool
     */
    private function checkIfBcmodIsAvailable()
    {
        return function_exists('bcmod');
    }

    /**
     * Check two first character's validity.
     *
     * @return bool
     */
    private function twoFirstCharactersValid(string $countryCode)
    {
        return !empty($countryCode) && ctype_alpha($countryCode);
    }

    /**
     * Check countries of the IBAN.
     *
     * @return bool
     */
    private function isCountriesValid(string $ibanCountryCode)
    {
        if (empty($this->countries)) {
            return true;
        }

        foreach ($this->countries as $country) {
            if ($this->isCountryValid($country, $ibanCountryCode)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check country of the IBAN.
     *
     * @return bool
     */
    private function isCountryValid(string $country, string $ibanCountryCode)
    {
        return ! empty($country)
            && isset($this->ibanLengthByCountry[$country])
            && $ibanCountryCode === $country;
    }

    /**
     * Check country of the IBAN.
     *
     * @return bool
     */
    private function isIbanLengthValid(string $iban, string $ibanCountryCode)
    {
        return strlen($iban) === $this->ibanLengthByCountry[$ibanCountryCode];
    }
}

