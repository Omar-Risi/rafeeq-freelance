<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{

    protected $fillable = [
        'name',
        'deadline',
        'description',
        'price',
        'advance',
        'is_advance_paid',
        'is_fully_paid',
        'agreement',
        'signed_agreement',
        'advance_invoice',
        'final_invoice',
        'user_id',
        'client_id',
        'status_id'
    ];


    public function client():BelongsTo {
        return $this->belongsTo(Client::class);
    }

    public function status():BelongsTo {
        return $this->belongsTo(Status::class);
    }
}
