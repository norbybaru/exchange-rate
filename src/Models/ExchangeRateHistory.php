<?php namespace NorbyBaru\ExchangeRate\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class ExchangeRateHistory
 * @package NorbyBaru\ExchangeRate\Models
 */
class ExchangeRateHistory extends Model
{
    protected $fillable = [
        'currency_iso',
        'rate',
        'base_currency_iso',
        'source_updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'source_updated_at',
    ];
}
