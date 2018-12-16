<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FbPagesToken extends Model
{
    use SoftDeletes;
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fb_pages_token';
	
	protected $fillable = [
		'page_id', 'long_provider_token'
    ];
	
	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
