<?php
namespace App\Auth\Providers;

use App\Models\User;

class DatabaseProvider implements UserProvider
{

    public function getById($id)
    {
        return User::find($id);
    }

    public function getByUsername($username)
    {
        return User::where('email', $username)->first();
    }

    public function getUserByRememberIdentifier($identifier)
    {
        return User::where('remember_identifier', $identifier)->first();
    }

    public function clearUserRememberToken($id)
    {
        return $this->getById($id)->update([
            'remember_identifier' => null,
            'remember_token' => null
        ]);
    }

    public function updateUserPasswordHash($id, $hash)
    {
        return $this->getById($id)->update([
            'password' => $hash
        ]);
    }

    public function setUserRememberToken($id, $identifier, $hash)
    {
        return $this->getById($id)->update([
            'remember_identifier' => $identifier,
            'remember_token' => $hash,
        ]);
    }
}