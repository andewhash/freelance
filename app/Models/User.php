<?php

namespace App\Models;

use App\Enum\User\UserRoleEnum;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'image_url',
        'balance',
        'referral_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function trasactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function chats()
    {
        if ($this->role == UserRoleEnum::SELLER) {
            return $this->hasMany(Chat::class, 'seller_id');
        }

        return $this->hasMany(Chat::class, 'customer_id');
    }

    public function orders()
    {
//        'seller_id', 'customer_id'
        return $this->hasMany(Order::class, $this->role == UserRoleEnum::SELLER ? 'seller_id' : "customer_id");
    }
}
