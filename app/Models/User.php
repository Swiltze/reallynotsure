<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

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
	'stream_key' => 'string',
    ];

	protected static function booted ()
	{	
		static::created(function ($user) {
			$user->generateStreamKey();
		});
	}


	 public function generateStreamKey()
    {
        $this->stream_key = Str::random(20);
        $this->save();
    }

    public function resetStreamKey()
    {
        $this->generateStreamKey();
    }



	const ROLE_USER = 'user';
	const ROLE_MODERATOR = 'moderator';
    	const ROLE_ADMIN = 'admin';

}
