<?php

namespace NorbyBaru\ExchangeRate\Exception;

class ProviderRequestApiException extends ExchangeRateApiException
{
    public static function throw(string $message): self
    {
        throw new self($message);
    }
}
