<?php
/**
 * Manager.php
 * ----------------------------------------------
 *
 *
 * @author      Stanislav Kiryukhin <korsar.zn@gmail.com>
 * @copyright   Copyright (c) 2015, CKGroup.ru
 *
 * ----------------------------------------------
 * All Rights Reserved.
 * ----------------------------------------------
 */
namespace SKGroup\Rbac;


/**
 * Class Manager
 * @package SKGroup\Rbac
 */
class Manager implements ManagerInterface
{
    /**
     * @var RoleInterface[]
     */
    protected $roles = [];

    /**
     * @var PermissionInterface[]
     */
    protected $permissions = [];

    /**
     * Creates a new Role to the RBAC system.
     *
     * @param string $role
     * @param string|array|RoleInterface $inherits
     * @return RoleInterface
     */
    public function addRole($role, $inherits = null)
    {
        if (is_string($role)) {
            $name = $role;
            $role = $this->createRole($name);
        } elseif ($role instanceof RoleInterface) {
            $name = $role->getName();
        } else {
            throw new \InvalidArgumentException('Role must be a string or implement RoleInterface');
        }

        if ($inherits) {

            if (!is_array($inherits)) {
                $inherits = [$inherits];
            }

            foreach ($inherits as $inherit) {
                $role->inherit($this->getRole($inherit));
            }
        }

        $this->roles[$name] = $role;
        return $role;
    }

    /**
     * Adds a permission to the RBAC system.
     *
     * @param string|PermissionInterface $permission
     * @return PermissionInterface
     */
    public function addPermission($permission)
    {
        if (is_string($permission)) {
            $name       = $permission;
            $permission = $this->createPermission($name);
        } elseif ($permission instanceof PermissionInterface) {
            $name = $permission->getName();
        } else {
            throw new \InvalidArgumentException('Permission must be a string or implement PermissionInterface');
        }

        $this->permissions[$name] = $permission;
        return $permission;
    }

    /**
     * Revokes a role from the RBAC system.
     *
     * @param string $role
     * @return bool
     */
    public function revokeRole($role)
    {
        if ($this->hasRole($role)) {
            unset($this->roles[$role]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if a role exists in the RBAC system.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        if (!is_string($role)) {
            throw new \InvalidArgumentException('Role must be a string');
        }

        return isset($this->roles[$role]);
    }

    /**
     * Returns the named role from the RBAC system.
     *
     * @param string $name
     * @return RoleInterface
     */
    public function getRole($name)
    {
        if ($this->hasRole($name)) {
            return $this->roles[$name];
        }

        throw new \InvalidArgumentException(sprintf('No role with name "%s" could be found', $name));
    }

    /**
     * Returns roles from the RBAC system.
     *
     * @return RoleInterface[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Revokes a permission from the RBAC system.
     *
     * @param string $permission
     * @return bool
     */
    public function revokePermission($permission)
    {
        if ($this->hasPermission($permission)) {
            unset($this->permissions[$permission]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if a permission exists in the RBAC system.
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        if (!is_string($permission)) {
            throw new \InvalidArgumentException('Permission must be a string');
        }

        return isset($this->permissions[$permission]);
    }

    /**
     * Returns the named permission from the RBAC system.
     *
     * @param string $name
     * @return PermissionInterface
     */
    public function getPermission($name)
    {
        if ($this->hasPermission($name)) {
            return $this->permissions[$name];
        }

        throw new \InvalidArgumentException(sprintf('No permission with name "%s" could be found', $name));
    }

    /**
     * Returns permissions from the RBAC system.
     *
     * @return PermissionInterface[]
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param string $role
     * @param string $permission
     * @param null|Array $params
     * @param null|Callable $assert
     * @return bool
     */
    public function isGranted($role, $permission, Array $params = null, $assert = null)
    {
        if (!is_string($role)) {
            throw new \InvalidArgumentException('Role must be a string');
        }

        if (!is_string($permission)) {
            throw new \InvalidArgumentException('Permission must be a string');
        }

        if (is_callable($assert)) {
            return $assert($this, [
                'role'          => $role,
                'permission'    => $permission,
                'params'        => $params
            ]);
        }

        return $this->getRole($role)->isGranted($permission, $params);
    }

    /**
     * @param $name
     * @return RoleInterface
     */
    protected function createRole($name)
    {
        return new Role($this, $name);
    }

    /**
     * @param $name
     * @return PermissionInterface
     */
    protected function createPermission($name)
    {
        return new Permission($name);
    }
}