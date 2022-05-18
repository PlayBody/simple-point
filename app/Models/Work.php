<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    public $table = "works";

    protected $fillable = [
        'work',
    ];

    public function price()
    {
        return $this->hasOne(Price::class);
    }
    public function outputFormats() {
        return $this->belongsToMany(OutputFormat::class,'work_output_formats');
    }
}
