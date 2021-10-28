<?php

namespace App\Models;

use App\Traits\HasImagePost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostEpisode extends Model
{
    use HasFactory, HasImagePost;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $appends = [
        'images_url',
        'release_date',
    ];

    public function getReleaseDateAttribute()
    {
        return date('d/m/Y', strtotime($this->created_at));
    }

    public function anime()
    {
        return $this->hasOne(Post::class, 'id', 'content_id');
    }
}
