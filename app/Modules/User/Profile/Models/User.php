<?php
 
namespace App\Modules\User\Profile\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql';
	/**
	 * Define table name
	 * @var string
	 */
    protected $table = 'user';

    /**
     * Disable timestamp
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Define primary key
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'temp_password', 
        'token', 'token_expiry', 'fcm_token', 'is_active', 
        'first_time_user', 'created_at', 'updated_at',
        'login_datetime', 'logout_datetime','hint'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'temp_password'
    ];

}
