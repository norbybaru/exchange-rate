<?php namespace NorbyBaru\ExchangeRate\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class ExchangeRate
 *
 * @property int $id
 * @property string $currency_iso
 * @property string $rate
 * @property string $base_currency_iso
 * @property \Carbon\Carbon $source_updated_at
 * @package NorbyBaru\ExchangeRate\Models
 */
class ExchangeRate extends Model
{
    public static function boot()
    {
        parent::boot();

        static::created(function($model) {
            ExchangeRateHistory::query()->insert($model);
        });

        static::updated(function($model) {
            ExchangeRateHistory::query()->insert($model);
        });
    }

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
