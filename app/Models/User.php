<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'users';

    public function getId()
    {
        return $this->id;
    }
    protected $fillable = [
        'name', 'email', 'phone', 'password'
    ];

    protected static function create($user) {
        DB::table('users')->insert($user);
    }

    protected static function updateUser($userid, $data) {
        return DB::table('users')->where('id', $userid)->update($data);
    }

    protected static function find() {

    }

    protected static function remove($userid) {
        DB::table('users')->where('userid', $userid)->delete();
    }

    protected static function get_all() {
        return DB::table('users')->get();
    }

    protected static function enable_admin($userid) {
        $user = array();
        $user['isadmin'] = 1;
        DB::table('users')->where('userid', $userid)->update($user);
    }

    protected static function disable_admin($userid) {
        $user = array();
        $user['isadmin'] = 0;
        DB::table('users')->where('userid', $userid)->update($user);
    }

    protected static function disable_user($userid) {
        $user = array();
        $user['isdisable'] = 1;
        DB::table('users')->where('userid', $userid)->update($user);
    }

    protected static function enable_user($userid) {
        $user = array();
        $user['isdisable'] = 0;
        DB::table('users')->where('userid', $userid)->update($user);
    }




    // /**
    //  * The attributes that should be hidden for serialization.
    //  *
    //  * @var array<int, string>
    //  */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];


}
