<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genres extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $appends = [
        'type_genre',
    ];

    public function getTypeGenreAttribute()
    {
        if ($this->type == 0) {
            return 'Default';
        } else if ($this->type == 1) {
            return 'Eksplisit';
        }
        return $this->type == 2 ? 'Themes' : 'Demographics';
    }
}
