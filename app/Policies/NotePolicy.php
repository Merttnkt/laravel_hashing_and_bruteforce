<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given note can be viewed by the user.
     */
    public function view(User $user, Note $note)
    {
        return $user->id === $note->user_id;
    }

    /**
     * Determine if the given note can be updated by the user.
     */
    public function update(User $user, Note $note)
    {
        return $user->id === $note->user_id;
    }

    /**
     * Determine if the given note can be deleted by the user.
     */
    public function delete(User $user, Note $note)
    {
        return $user->id === $note->user_id;
    }
    
    /**
     * Determine if the user can create notes
     */
    public function create(User $user)
    {
        // Any authenticated user can create notes
        // We could add additional checks here if needed
        return true;
    }
}