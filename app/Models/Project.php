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
        'agreement',
        'signed_agreement',
        'client_id'
    ];


    public function client():BelongsTo {
        return $this->belongsTo(Client::class);
    }
}
