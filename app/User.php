<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject as AuthenticatableUserContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract,  AuthenticatableUserContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    protected $guarded = []; //守卫
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $attributes = [
        'email' => '',
    ];



    public function getJWTIdentifier()
    {
        return $this->getKey(); // Eloquent model method
    }


    public function getJWTCustomClaims()
    {
        return [];
    }

    public function UserBadges()
    {
        return $this->belongsToMany('App\Model\Badge', 'user_badges', 'user_id', 'badge_id');
    }

    public function UserArticles()
    {
        return $this->belongsToMany('App\Model\Article', 'user_articles', 'user_id', 'article_id');
    }


}
