<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteItem extends Model
{

    protected $fillable = [
        'name',
        'description',
        'price',
        'quote_id'
    ];


    public function quote():BelongsTo {
        return $this->belongsTo(Quote::class);
    }

}
