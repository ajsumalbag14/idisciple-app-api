<?php
 
namespace App\Modules\User\Profile\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
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
    protected $table = 'user_profile';

    /**
     * Disable timestamp
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Define primary key
     * @var string
     */
    protected $primaryKey = 'user_profile_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'firstname', 'lastname', 'middlename', 'nickname', 'gender',
        'birthdate', 'mobile_no', 'country', 'is_pwd', 'created_at', 'updated_at'
    ];

}
