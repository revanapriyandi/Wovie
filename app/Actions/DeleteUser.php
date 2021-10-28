<?php

namespace App\Actions;

use App\Contracts\DeletesUsers;


class DeleteUser implements DeletesUsers
{
    public function delete($user)
    {
        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->delete();
    }
}
