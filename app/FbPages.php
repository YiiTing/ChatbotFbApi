<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FbPages extends Model
{
    use SoftDeletes;
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fb_pages';
	
	protected $fillable = [
       'page_id', 'page_token', 'creator'
    ];
	
	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
