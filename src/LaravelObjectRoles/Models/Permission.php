<?php

namespace SehrGut\LaravelObjectRoles\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use SehrGut\LaravelObjectRoles\ResolvesByName;

class Permission extends Model
{
    use ResolvesByName;

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * All Roles that this Permission is associated with.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->withTimestamps();
    }
}
