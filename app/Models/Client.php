<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{

    protected $fillable = ['name', 'type','email','phone_number'];

    public function notes():HasMany {
        return $this->hasMany(Note::class);
    }

    public function projects():HasMany {
        return $this->hasMany(Project::class);
    }
}
