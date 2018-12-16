<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FbMessengerPersistentMenu extends Model
{
    use SoftDeletes;
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fb_messenger_persistent_menu';
	
	protected $fillable = [
       'page_id', 'mpm_title', 'mpm_answer', 'mpm_url',
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
