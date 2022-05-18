<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public $table = "messages";

    protected $fillable = [
        'project_id',
        'from',
        'to',
        'message',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function from()
    {
        return $this->belongsTo(User::class, 'ufrom');
    }
    public function to()
    {
        return $this->belongsTo(User::class, 'uto');
    }
}
