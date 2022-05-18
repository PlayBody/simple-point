<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    public $table = "prices";

    protected $fillable = [
        'work_id',
        'main_amount',
        'main_unit',
        'add_amount',
        'add_unit',
        'main_period',
        'main_period_unit',
        'add_period',
        'add_period_unit',
    ];

    public function work()
    {
        return $this->belongsTo(Work::class);
    }
}
