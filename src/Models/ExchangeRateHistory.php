<?php

namespace NorbyBaru\ExchangeRate\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRateHistory extends Model
{
    protected $guarded = ["id"];

    protected $cast = [
        "source_updated_at" => "datetime",
    ];
}
