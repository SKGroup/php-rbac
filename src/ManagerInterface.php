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
     * Creates a new Role object.
     * Note that the newly created role is not added to the RBAC system yet.
     * You must fill in the needed data and call [[addRole()]] to add it to the system.
     *
     * @param string $role
     * @return RoleInterface
     */
    public function createRole($role);

    /**
     * Creates a new Permission object.
     * Note that the newly created permission is not added to the RBAC system yet.
     * You must fill in the needed data and call [[addPermission()]] to add it to the system.
     *
     * @param string $permission
     * @return PermissionInterface
     */
    public function createPermission($permission);

    /**
     * Adds a role to the RBAC system.
     *
     * @param RoleInterface $role
     * @return void
     */
    public function addRole(RoleInterface $role);

    /**
     * Revokes a role from the RBAC system.
     *
     * @param string|RoleInterface $role
     * @return bool
     */
    public function revokeRole($role);

    /**
     * Checks if a role exists in the RBAC system.
     *
     * @param string|RoleInterface $role
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
     * Adds a permission to the RBAC system.
     *
     * @param PermissionInterface $permission
     * @return void
     */
    public function addPermission(PermissionInterface $permission);

    /**
     * Revokes a permission from the RBAC system.
     *
     * @param string|PermissionInterface $permission
     * @return bool
     */
    public function revokePermission($permission);

    /**
     * Checks if a permission exists in the RBAC system.
     *
     * @param string|PermissionInterface $permission
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
     * @param string|RoleInterface $role
     * @param string|PermissionInterface $permission
     * @param null|Callable $assert
     * @return bool
     */
    public function isGranted($role, $permission, $assert = null);
}
