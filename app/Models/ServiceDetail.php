<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    use HasFactory;

    public function technical()
    {
        return $this->belongsTo(Technical::class, 'technical_id', 'id');
    }
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
}
