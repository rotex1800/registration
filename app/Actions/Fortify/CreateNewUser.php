<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Ramsey\Uuid\Uuid;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    private const MAX_255 = 'max:255';

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'first_name' => ['required', 'string', self::MAX_255],
            'family_name' => ['required', 'string', self::MAX_255],
            'email' => [
                'required',
                'string',
                'email',
                self::MAX_255,
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'email' => $input['email'],
            'first_name' => $input['first_name'],
            'family_name' => $input['family_name'],
            'password' => Hash::make($input['password']),
            'uuid' => Uuid::uuid4(),
        ]);

        $user->giveRole('participant');

        return $user;
    }
}
