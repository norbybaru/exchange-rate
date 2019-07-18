<?php namespace NorbyBaru\ExchangeRate;


use Carbon\Carbon;

/**
 * Class Money
 * @package NorbyBaru\ExchangeRate
 */
class Money
{
    /** @var float|int */
    protected $amount;

    /** @var string */
    protected $currency;

    /** @var string */
    protected $baseCurrency;

    /** @var string  */
    protected $rate;

    /** @var Carbon */
    protected $lastUpdatedAt;

    /**
     * Money constructor.
     *
     * @param float|int $amount
     * @param string    $currency
     * @param string    $baseCurrency
     * @param Carbon    $updatedAt
     */
    public function __construct($amount, string $currency = 'USD', string $baseCurrency = 'USD', string $rate = null, $updatedAt = null)
    {
        $this->amount = (float)$amount;
        $this->currency = $currency;
        $this->baseCurrency = $baseCurrency;
        $this->lastUpdatedAt = $updatedAt ? $updatedAt : now();
        $this->rate = $rate;
    }

    /**
     * @return string
     */
    public function __toString()
    {
       return $this->formatted();
    }

    /**
     * @param int $round
     *
     * @return string
     */
    public function formatted($round = 2)
    {
        return sprintf("%s %s", number_format($this->amount, $round), $this->currency);
    }

    /**
     * @return float|int
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float|int $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getBaseCurrency()
    {
        return $this->baseCurrency;
    }

    /**
     * @param string $baseCurrency
     */
    public function setBaseCurrency(string $baseCurrency): void
    {
        $this->baseCurrency = $baseCurrency;
    }

    /**
     * @return Carbon
     */
    public function getLastUpdatedAt(): Carbon
    {
        return $this->lastUpdatedAt;
    }

    /**
     * @param Carbon $lastUpdatedAt
     */
    public function setLastUpdatedAt(Carbon $lastUpdatedAt): void
    {
        $this->lastUpdatedAt = $lastUpdatedAt;
    }

    /**
     * @return string
     */
    public function getRate(): string
    {
        return $this->rate;
    }

    /**
     * @param string $rate
     */
    public function setRate(string $rate): void
    {
        $this->rate = $rate;
    }
}
