<?php

namespace App\Models;

use App\Models\Country;
use App\Models\Services;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostVideo extends Model
{
    use HasFactory;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function Lang()
    {
        return $this->hasOne(Country::class, 'id', 'language_id');
    }

    public function Service()
    {
        return $this->hasOne(Services::class, 'id', 'service_id');
    }
}
