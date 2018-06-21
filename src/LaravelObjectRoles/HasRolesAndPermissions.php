<?php

namespace SehrGut\LaravelObjectRoles;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use SehrGut\LaravelObjectRoles\Models\Role;

trait HasRolesAndPermissions
{
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * All roles of this User.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->withTimestamps()
            ->withPivot([
                'object_type',
                'object_id',
                'global',
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Roles & Permissions Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Determine whether the User has given global Permission.
     *
     * @param  string $permission
     * @return boolean
     */
    public function hasGlobalPermission(string $permission): bool
    {
        return $this->roles()
            ->whereHas('permissions', function ($builder) use ($permission) {
                $builder->where('name', $permission);
            })
            ->wherePivot('global', true)
            ->count() > 0;
    }

    /**
     * Determine whether the User has given Permission in regard to an Object.
     *
     * @param  string $permission
     * @param  Illuminate\Database\Eloquent\Model $object
     * @return boolean
     */
    public function hasPermissionThrough(string $permission, Model $object): bool
    {
        return $this->roles()
            ->whereHas('permissions', function ($builder) use ($permission) {
                $builder->where('name', $permission);
            })
            ->wherePivot('object_type', get_class($object))
            ->wherePivot('object_id', $object->getKey())
            ->count() > 0;
    }

    /**
     * Attach a Role globally to this User.
     *
     * @param  SehrGut\LaravelObjectRoles\Models\Role|string $role
     * @return $this
     */
    public function assignGlobalRole($role): self
    {
        $role = Role::resolve($role);
        $this->roles()->attach($role, ['global' => true]);

        return $this;
    }

    /**
     * Attach a Role to this User with respect to an object.
     *
     * @param  SehrGut\LaravelObjectRoles\Models\Role|string $role
     * @param  Illuminate\Database\Eloquent\Model $object
     * @return $this
     */
    public function assignObjectRole($role, Model $object): self
    {
        $role = Role::resolve($role);
        $this->roles()->attach($role, [
            'object_type' => get_class($object),
            'object_id' => $object->getKey(),
        ]);

        return $this;
    }
}
