<?php
namespace App\Permissions;

use App\Permission;
use App\Group;

trait HasPermissionsTrait {

    public function groups() {
        return $this->belongsToMany(Group::class,'user_group');
    }
    public function hasRole( ... $roles ) {
        foreach ($roles as $role) {
            if ($this->groups->contains('alias', $role)) {
                return true;
            }
        }
        return false;
    }
    public function hasPermissions(... $permisions) {
        $perms = $this->groups->load('permissions')->pluck('permissions')->flatten()->pluck('alias')->unique();
        foreach ($permisions as $value) {
            if($perms->contains($value)) return true;
        }
        return false;
    }
}