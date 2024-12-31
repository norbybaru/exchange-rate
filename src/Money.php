<?php

declare(strict_types=1);

namespace NorbyBaru\ExchangeRate;

use Illuminate\Support\Carbon;

class Money
{
    public function __construct(
        protected float $amount,
        protected string $currency = "USD",
        protected string $baseCurrency = "USD",
        protected ?string $rate = null,
        protected ?Carbon $lastUpdatedAt = null
    ) {
    }

    public function __toString(): string
    {
        return $this->formatted();
    }

    public function formatted(int $round = 2): string
    {
        return sprintf(
            "%s %s",
            number_format($this->amount, $round),
            $this->currency
        );
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    public function getBaseCurrency(): string
    {
        return $this->baseCurrency;
    }

    public function setBaseCurrency(string $baseCurrency): void
    {
        $this->baseCurrency = $baseCurrency;
    }

    public function getLastUpdatedAt(): Carbon
    {
        return $this->lastUpdatedAt;
    }

    public function setLastUpdatedAt(Carbon $lastUpdatedAt): void
    {
        $this->lastUpdatedAt = $lastUpdatedAt;
    }

    public function getRate(): string
    {
        return $this->rate;
    }

    public function setRate(string $rate): void
    {
        $this->rate = $rate;
    }
}
