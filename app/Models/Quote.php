<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quote extends Model
{

    protected $fillable = [
        'project_id',
        'user_id'
    ];


    public function project():BelongsTo {
        return $this->belongsTo(Project::class);
    }

    public function items():HasMany {
        return $this->hasMany(QuoteItem::class);
    }
}
