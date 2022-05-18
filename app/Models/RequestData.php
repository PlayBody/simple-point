<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestData extends Model
{
    use HasFactory;

    public $table = "request_data";

    protected $fillable = [
        'project_id',
        'request_data',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
