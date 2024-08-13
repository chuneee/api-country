<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'continent',
        'population',
        'language',
        'currency',
    ];

    public function deleteLogically()
    {
        $this->status = 0;
        $this->save();
    }
}
