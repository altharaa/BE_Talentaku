<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlbumMedia extends Model
{
    use HasFactory;

    protected $fillable = ['album_id', 'file_name'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
