<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageProfile extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'kontak_desa' => 'array',
        ];
    }
}
