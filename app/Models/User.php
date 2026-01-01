<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\ContactStatus;
use App\Enums\UserStatus;
use App\Helpers\Common;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'contact_id',
        'center_id',
        'status',
    ];

    // for spatie
    protected $guard_name = 'api';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatus::class,

        ];
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    /**
     * Creates a new user.
     *
     * @param  array<string, string>  $data
     */
    public static function createNew(array $data): User
    {
        // First create the contact record
        $password = Str::password();
        $centerId = $data['center_id'] ?? Common::centerId();

        $contact = Contact::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'center_id' => $centerId,
            'status' => ContactStatus::Active,
            'type_id' => Contact::TYPE_INDIVIDUAL,
        ]);

        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($password),
            'contact_id' => $contact->id,
            'center_id' => $centerId,
            'status' => UserStatus::Active,
        ]);
        // Assign roles
        $user->assignRole($data['roles']);

        $user->sendEmailVerificationNotification();

        return $user;
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }
}
