<?php

namespace App\Policies;

use App\Models\Comic;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ComicPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comic $comic): bool
    {
        return $user->id === $comic->uploader_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comic $comic): bool
    {
        return $user->id === $comic->uploader_id || $user->isAdmin();
    }
}