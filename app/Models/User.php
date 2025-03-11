<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    // SoftDeletes dùng để xoá mềm
    use HasFactory, SoftDeletes, QueryScopes;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     *
     */
    protected $primaryKey = 'id';
    protected $fillable = [
        'fullname',
        'user_catalogue_id',
        'email',
        'password',
        'phone',
        'address',
        'province_id',
        'district_id',
        'ward_id',
        'birthday',
        'image',
        'description',
        'user_agent',
        'publish',
        'ip',
        'referral_code',
        'parent_id',
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
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();

        // Tự động tạo referral_code khi tạo user mới
        static::creating(function ($user) {
            $user->referral_code = self::generateReferralCode();
        });
    }

    public static function generateReferralCode()
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (static::where('referral_code', $code)->exists());

        return $code;
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    public function user_catalogues()
    {
        return $this->belongsTo(UserCatalogue::class, 'user_catalogue_id', 'id');
    }

    public function languages()
    {
        return $this->hasMany(Language::class, 'user_id', 'id');
    }

    public function post_catalogues()
    {
        return $this->hasMany(PostCatalogue::class, 'user_id', 'id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function hasPermission($permissionCanonical)
    {
        return $this->user_catalogues()->permissions()->contains('canonical', $permissionCanonical);
    }
}
