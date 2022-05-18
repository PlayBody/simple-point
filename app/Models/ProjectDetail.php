<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDetail extends Model
{
    use HasFactory;

    public $table = "project_details";

    protected $fillable = [
        'project_id',
        'ground_data',
        'simplified_drawing',
        'simplified_drawing_rank',
        'simplified_drawing_scale',
        'contour_data',
        'longitudinal_data',
        'simple_orthphoto',
        'mesh_soil_volume',
        'simple_accuracy_table',
        'public_accuracy_table',
        'ground_data_output',
        'simplified_drawing_output',
        'contour_data_output',
        'longitudinal_data_output',
        'simple_orthphoto_output',
        'mesh_soil_volume_output',
        'simple_accuracy_table_output',
        'public_accuracy_table_output',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
