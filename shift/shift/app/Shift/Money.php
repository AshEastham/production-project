<?php

namespace App\Shift;

use Money\Currency;
// Aliased name to stop conflicting names, from the PHPMoney package.
use NumberFormatter;
use Money\Money as BaseMoney;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;

// Abstracted money logic into my own class, to setup preferences for displaying the price.
class Money {
    protected $money;

    public function __construct($value)
    {
        // Sets default price currency to GBP.  When a money object is created.
        $this->money = new BaseMoney($value, new Currency('GBP'));
    }

    public function amount() 
    {
        return $this->money->getAmount();
    }

    public function formatted() {
        // Returns formatted price.
        $formatter = new IntlMoneyFormatter(
            new NumberFormatter('en_GB', NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );

        return $formatter->format($this->money);        
    }

    public function add(Money $money)
    {
        $this->money = $this->money->add($money->instance());

        return $this;
    }

    public function instance()
    {
        return $this->money;
    }
}