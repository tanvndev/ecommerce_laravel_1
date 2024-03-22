<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserCatalogue extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, QueryScopes;
    protected $table = 'user_catalogues';
    protected $fillable = [
        'name',
        'description',
        'publish',
        'deleted_at',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'user_catalogue_id', 'id');
    }
}
