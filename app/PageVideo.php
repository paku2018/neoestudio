<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageVideo extends Model
{
    protected $table = 'page_video';
    protected $fillable = [
        'page_id','video','order'
    ];
    public function pages()
    {
        return $this->belongsTo('App\Page', 'page_id', 'id');
    }
}
