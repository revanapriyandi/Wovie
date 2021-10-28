<?php

namespace App\Models;

use App\Models\Producer;
use App\Models\PostGenre;
use App\Traits\HasImagePost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
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
        'genre',
        'producer',
        'type_post',
        'anime_status'
    ];

    public function getReleaseDateAttribute()
    {
        return date('d/m/Y', strtotime($this->released));
    }

    public function getGenreAttribute()
    {
        $postGenre = PostGenre::where('content_id', $this->id)->get();
        $genre = array();
        foreach ($postGenre as $value) {
            array_push($genre, Genres::find($value->genre_id));
        }
        return $genre;
    }

    public function getProducerAttribute()
    {
        return Producer::find($this->producer_id);
    }

    public function getTypePostAttribute()
    {
        if ($this->type == 1) {
            return 'Anime';
        } elseif ($this->type == 2) {
            return 'Anime Movie';
        }
        return $this->type == 3 ? 'Movies' : 'Series';
    }

    public function getAnimeStatusAttribute()
    {
        if ($this->status == 1) {
            return 'Ongoing';
        }
        return $this->status == 2 ? 'Completed' : 'Canceled';
    }
}
