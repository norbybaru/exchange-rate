<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Base Currency
    |--------------------------------------------------------------------------
    |
    | Default currency to convert from
    |
    */
    "base_currency" => env("BASE_CURRENCY_ISO", "USD"),

    /*
    |--------------------------------------------------------------------------
    | Exchange Rate Provider
    |--------------------------------------------------------------------------
    |
    | The exchange rate provider to use.
    |
    | Supported: exchangeratesapi, eurobank
    |
    */
    "provider" => env("EXCHANGE_RATE_PROVIDER", "eurobank"),

    /*
    |--------------------------------------------------------------------------
    | Providers
    |--------------------------------------------------------------------------
    |
    | Configuration for each provider
    |
    */
    "providers" => [
        "exchangeratesapi" => [
            "access_key" => env("EXCHANGERATESAPI_ACCESS_KEY", ""),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Whitelist Currency ISO
    |--------------------------------------------------------------------------
    |
    | List of currency ISO that will be allowed to be stored.
    | Upade list below with missing curreny ISO that you want to store.
    | If left empty, all currency ISO will be stored.
    |
    |
    */
    "whitelist_currency_iso" => [
        "USD", //United States Dollar
        "EUR", //Euro
        "JPY", //Japanese Yen
        "GBP", //British Pound Sterling
        "AUD", //Australian Dollar
        "CAD", //Canadian Dollar
        "CHF", //Swiss Franc
        "CNY", //Chinese Yuan
        "SEK", //Swedish Krona
        "NZD", //New Zealand Dollar
        "MXN", //Mexican Peso
        "SGD", //Singapore Dollar
        "HKD", //Hong Kong Dollar
        "NOK", //Norwegian Krone
        "KRW", //South Korean Won
        "TRY", //Turkish Lira
        "ZAR", //South African Rand
    ],
];
