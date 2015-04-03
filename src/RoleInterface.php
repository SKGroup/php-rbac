<?php
/**
 * RoleInterface.php
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
 * Interface RoleInterface
 * @package SKGroup\Rbac
 */
interface RoleInterface extends \RecursiveIterator
{
    /**
     * @param string $name
     */
    public function __construct($name);

    /**
     * Get the name of the Role.
     *
     * @return string
     */
    public function getName();

    /**
     * Add permission to the role.
     *
     * @param PermissionInterface $permission
     * @param string|array|null $rules
     * @return void
     */
    public function addPermission(PermissionInterface $permission, $rules = null);

    /**
     * Revokes a Permission from the Role.
     *
     * @param string|PermissionInterface $permission
     * @return bool
     */
    public function revokePermission($permission);

    /**
     * Checks if a permission exists for this role or any child roles.
     *
     * @param string|PermissionInterface $permission
     * @param array $params
     * @return bool
     */
    public function hasPermission($permission, Array $params = null);

    /**
     * Returns permissions from the Role.
     *
     * @return PermissionInterface[]
     */
    public function getPermissions();

    /**
     * @param RoleInterface $role
     */
    public function setParent(RoleInterface $role);

    /**
     * @return RoleInterface
     */
    public function getParent();

    /**
     * @param RoleInterface $role
     */
    public function addChild(RoleInterface $role);
}
