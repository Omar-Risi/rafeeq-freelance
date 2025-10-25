<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quote extends Model
{

    protected $fillable = [
        'project_id'
    ];


    public function project():BelongsTo {
        return $this->belongsTo(Project::class);
    }

    public function items():HasMany {
        $this->hasMany(QuoteItem::class);
    }
}
