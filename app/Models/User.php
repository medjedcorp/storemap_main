<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use App\Notifications\UserPasswordResetNotification;
use Kyslik\ColumnSortable\Sortable; // 追加


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    use Sortable; // 追加
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $sortable = ['name', 'email', 'role']; // 追加
    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $attributes = [
        'role' => 'user', // デフォルト値
    ];

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
    public function store()
    {
        return $this->belongsToMany('App\Models\Store');
    }
    // public function sendPasswordResetNotification($token)
    // {
    //     $this->notify(new \App\Notifications\ResetPassword($token));
    // }
    // public function sendEmailVerificationNotification()
    // {
    //     $this->notify(new \App\Notifications\VerifyEmailJapanese);
    // }
}
