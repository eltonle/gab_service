<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public function payment()
    {
        return $this->belongsTo(ServicePayment::class, 'id', 'service_id');
    }

    public function invoice_details()
    {
        return $this->hasMany(ServiceDetail::class, 'service_id', 'id');
    }
}
