<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $table = 'page_content';
    protected $fillable = [
        'page_id','title','description','description2','image','order'
    ];
    public function pages()
    {
        return $this->belongsTo('App\Page', 'page_id', 'id');
    }
}
