<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverableData extends Model
{
    use HasFactory;

    public $table = "deliverable_data";

    protected $fillable = [
        'project_id',
        'deliverable_data',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
