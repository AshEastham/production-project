<?php

namespace App\Models\Traits;

use App\Shift\Money;
use Money\Currency;
use NumberFormatter;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;

// Abstracted price into it's own trait, as product variations may want to use the same logic.
trait HasPrice {
    public function getPriceAttribute($value) {
        return new Money($value);
    }

    public function getFormattedPriceAttribute() {
        return $this->price->formatted();
    }    
}