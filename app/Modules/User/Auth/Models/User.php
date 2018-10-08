<?php
 
namespace App\Modules\User\Auth\Models;

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

}
