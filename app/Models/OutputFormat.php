<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutputFormat extends Model
{
    use HasFactory;

    public $table = "output_formats";

    protected $fillable = [
        'format',
    ];

    public function works() {
        return $this->belongsToMany(Work::class,'work_output_formats');
    }
}
