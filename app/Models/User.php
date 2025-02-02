<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\Client as OClient;
use Laravel\Passport\HasApiTokens;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLEADMIN = 1;
    const ROLEUSER = 0;
    const STATUSACTIVE = 1;
    const STATUSINACTIVE = 0;
    const STATUSARR = [0 => 'Inactive', 1 => 'Active'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'role',
        'image',
        'email_verified_at'
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
        'email_verified_at' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function ScopeUserRole($query, $withActive = false)
    {
        return $query->where('role', self::ROLEUSER)
            ->when($withActive, function ($query) {
                $query->where('email_verified_at', '!=', null);
            });
    }

    public function getImageAttribute()
    {
        if (!$this->attributes['image']) {
            return url('dist/img/avatar.png');
        }
        return  url($this->attributes['image']);
    }

    public function getFullNameAttribute()
    {
        return  $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    public static function getTokenAndRefreshToken($email, $password)
    {
        $oClient = OClient::where('password_client', 1)->first();
        if (empty($oClient)) {
            throw new Exception('password_client not found');
        }
        $http = new Client();
        $response = $http->request('POST', url('oauth/token'), [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $oClient->id,
                'client_secret' => $oClient->secret,
                'username' => $email,
                'password' => $password,
                'scope' => '*',
            ],
            'verify' => false,
        ]);
        return json_decode((string) $response->getBody(), true);
    }

    public function loginResponse()
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'image' => $this->image,
            'email_verified_at' => $this->email_verified_at,
        ];
    }

    public function weights()
    {
        return $this->hasMany(UserWeight::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'user_weights');
    }
    
}
