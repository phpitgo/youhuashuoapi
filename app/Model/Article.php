<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Article extends Model
{
	protected $guarded = [];
    protected $appends = ['create_time', 'sub_content'];
    //
    //
    public function getCreateTimeAttribute()
    {
    	return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->diffForHumans();
    }

    public function getSubContentAttribute()
    {
    	return str_limit($this->attributes['content']);
    }
}
