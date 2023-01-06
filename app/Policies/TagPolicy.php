<?php

namespace App\Policies;

use App\User;
use App\Tag;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    public function modify(User $user, Tag $tag)
    {
      if($user->hasRole('View Dashboard')){
        return $user->company()->first()->tags()->where('id','=', $tag->id)->first();
      }
      return false;
    }
}
