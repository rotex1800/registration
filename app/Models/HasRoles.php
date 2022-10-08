<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasRoles
{
    /**
     * Indicates whether the user has a role of the given name
     *
     * @param  string  $roleName
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        return $this->roles()->where('name', $roleName)->get()->count() > 0;
    }

    /**
     * @return BelongsToMany
     * @phpstan-return BelongsToMany<Role>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function giveRole(string $roleName)
    {
        $role = Role::where('name', $roleName)->first();
        if ($role == null) {
            $role = Role::create(['name' => $roleName]);
        }
        $this->roles()->save($role);
    }
}
