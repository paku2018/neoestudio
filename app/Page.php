<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //
    public function page_video()
    {
        return $this->belongsTo('App\PageVideo', 'id', 'page_id');
    }

    public function page_content()
    {
        return $this->hasMany('App\PageContent', 'page_id');
    }
}
