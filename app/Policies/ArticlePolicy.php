<?php

namespace App\Policies;

use App\Article;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
        if ($user->isAdmin()) return true; //adminTS
        if ($user->isChangeLeader()) return true; //cl
        if ($user->isChangeChampion()) return true; //cc
        if ($user->isTopLeader()) return true; //tl
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function view(User $user, Article $article)
    {
        //
        if ($user->isAdmin()) return true; //adminTS
        if ($user->isChangeLeader()) return true; //cl
        if ($user->isChangeChampion()) return true; //cc
        if ($user->isTopLeader()) return true; //tl
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        if ($user->isAdmin()) return true; //adminTS
        if ($user->isChangeLeader()) return true; //cl
        if ($user->isChangeChampion()) return true; //cc
        if ($user->isTopLeader()) return true; //tl
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function update(User $user, Article $article)
    {
        //
        return false;
        //return $user->id == $article->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function delete(User $user, Article $article)
    {
        //
        if ($user->isAdmin()) return true; //adminTS
        return false;
        //return $user->id == $article->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function restore(User $user, Article $article)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function forceDelete(User $user, Article $article)
    {
        //
    }

    public function approve(User $user,  Article $article)
    {
        if ($user->isAdmin() and $article->status != 2) return true; //adminTS
        return false;
    }
}
