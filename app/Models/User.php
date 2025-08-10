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
        'role',
        'last_name',
        'email',
        'phone',
        'telegram',
        'whatsapp',
        'address',
        'country',
        'region',
        'email_verified_at',
        'phone_verified_at',
        'phone_verification_code',
        'email_verification_code',
        'city',
        'brand',
        'mark',
        'description',
        'business_type',
        'exported',
        'count_employers',
        'year',
        'contact_email',
        'site',
        'image_url',
        'password'
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

    public function transactions()
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

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'user_categories');
    }

    public function orders()
    {
//        'seller_id', 'customer_id'
        return $this->hasMany(Order::class, $this->role == UserRoleEnum::SELLER ? 'seller_id' : "customer_id");
    }
}
