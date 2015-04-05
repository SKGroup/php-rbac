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
     * @param ManagerInterface $manager
     * @param string $name
     */
    public function __construct(ManagerInterface $manager, $name);

    /**
     * Get the name of the Role.
     *
     * @return string
     */
    public function getName();

    /**
     * Add permission to the role.
     *
     * @param string $permission
     * @return void
     */
    public function allow($permission);

    /**
     * Revokes a Permission from the Role.
     *
     * @param string $permission
     * @return bool
     */
    public function disallow($permission);

    /**
     * Checks if a permission exists for this role or any child roles.
     *
     * @param string $permission
     * @param array $params
     * @return bool
     */
    public function isGranted($permission, Array $params = null);

    /**
     * Returns permissions from the Role.
     *
     * @return PermissionInterface[]
     */
    public function getPermissions();

    /**
     * Do a role inherit from another existing role
     *
     * @param RoleInterface $role
     */
    public function inherit(RoleInterface $role);

    /**
     * @return ManagerInterface
     */
    public function getManager();

    /**
     * Returns role name.
     *
     * @return string
     */
    public function __toString();
}
