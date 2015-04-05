<?php
/**
 * ManagerInterface.php
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
 * Interface ManagerInterface
 * @package SKGroup\Rbac
 */
interface ManagerInterface
{
    /**
     * Adds a role to the RBAC system.
     *
     * @param string|RoleInterface $role
     * @param string|array|RoleInterface $inherits
     * @return RoleInterface
     */
    public function addRole($role, $inherits = null);

    /**
     * Adds a permission to the RBAC system.
     *
     * @param string|PermissionInterface $permission
     * @return PermissionInterface
     */
    public function addPermission($permission);

    /**
     * Revokes a role from the RBAC system.
     *
     * @param string $role
     * @return bool
     */
    public function revokeRole($role);

    /**
     * Checks if a role exists in the RBAC system.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole($role);

    /**
     * Returns the named role from the RBAC system.
     *
     * @param string $name
     * @return RoleInterface
     */
    public function getRole($name);

    /**
     * Returns roles from the RBAC system.
     *
     * @return RoleInterface[]
     */
    public function getRoles();

    /**
     * Revokes a permission from the RBAC system.
     *
     * @param string $permission
     * @return bool
     */
    public function revokePermission($permission);

    /**
     * Checks if a permission exists in the RBAC system.
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permission);

    /**
     * Returns the named permission from the RBAC system.
     *
     * @param string $name
     * @return PermissionInterface
     */
    public function getPermission($name);

    /**
     * Returns permissions from the RBAC system.
     *
     * @return PermissionInterface[]
     */
    public function getPermissions();

    /**
     * @param string $role
     * @param string $permission
     * @param null|Array $params
     * @param null|Callable $assert
     * @return bool
     */
    public function isGranted($role, $permission, Array $params = null, $assert = null);
}
