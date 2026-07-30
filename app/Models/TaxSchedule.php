<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxSchedule extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['tanggal' => 'date', 'is_routine_monthly' => 'boolean'];
    }
}
