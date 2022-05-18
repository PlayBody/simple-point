<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public $table = "projects";

    protected $fillable = [
        'client_id',
        'business_id',
        'title',
        'amount',
        'delivery_date',
        'purchase_order',
        'invoice',
        'status',
    ];

    protected $casts = [
        'delivery_date' => 'datetime:Y-m-d',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function business()
    {
        return $this->belongsTo(User::class, 'business_id');
    }

    public function detail()
    {
        return $this->hasOne(ProjectDetail::class, 'project_id');
    }

    public function requestData()
    {
        return $this->hasMany(RequestData::class, 'project_id');
    }

    public function deliverableData()
    {
        return $this->hasMany(DeliverableData::class, 'project_id');
    }
}
