<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'person_id',
        'center_id',
    ];

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
        ];
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    protected function status(): Attribute
    {
        $statuses = [0 => 'inactive', 1 => 'active'];

        return Attribute::make(
            get: fn (string $value) => $statuses[$value],
        );
    }

    /**
     * Creates a new user.
     *
     * @param  array<string, string>  $data
     */
    public static function createNew(array $data): User
    {
        // First create the person
        $person = Person::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'center_id' => $data['center_id'] ?? 1,
            'status' => Person::STATUS_ACTIVE,
            'type_id' => Person::TYPE_CONTACT,
        ]);
        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'person_id' => $person->id,
            'center_id' => $data['center_id'] ?? 1,
        ]);

        $user->sendEmailVerificationNotification();

        return $user;
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }
}
