<?php

namespace SehrGut\LaravelObjectRoles\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use SehrGut\LaravelObjectRoles\ResolvesByName;

class Role extends Model
{
    use ResolvesByName;

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * All Permissions that are assigned to this Role.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)
            ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Roles & Permissions Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Attach a Permission to this Role.
     *
     * @param  SehrGut\LaravelObjectRoles\Models\Permission|string $permission
     * @return $this
     */
    public function attachPermission($permission): self
    {
        $permission = Permission::resolve($permission);
        $this->permissions()->attach($permission);

        return $this;
    }
}
