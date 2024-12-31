<?php

namespace NorbyBaru\ExchangeRate\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property int $id
 * @property string $currency_iso
 * @property float $rate
 * @property string $base_currency_iso
 * @property \Illuminate\Support\Carbon $source_updated_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class ExchangeRate extends Model
{
    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $data = collect($model->toArray())->except("id")->toArray();
            ExchangeRateHistory::query()->insert($data);
        });

        static::updated(function ($model) {
            $data = collect($model->toArray())->except("id")->toArray();
            ExchangeRateHistory::query()->insert($data);
        });
    }

    protected $guarded = ["id"];

    protected $cast = [
        "source_updated_at" => "datetime",
    ];
}
