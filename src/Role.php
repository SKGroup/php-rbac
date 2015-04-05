<?php
/**
 * Role.php
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

use SKGroup\Rbac\SPL\RecursiveIteratorAbstract;

/**
 * Class Role
 * @package SKGroup\Rbac
 */
class Role extends RecursiveIteratorAbstract implements RoleInterface
{
    /**
     * @var ManagerInterface
     */
    protected $manager;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var PermissionInterface[]
     */
    protected $permissions = [];

    /**
     *
     */
    const PERMISSION_KEY_NO_RULES = '*';

    /**
     * @param ManagerInterface $manager
     * @param string $name
     */
    public function __construct(ManagerInterface $manager, $name)
    {
        $this->name = $name;
        $this->manager = $manager;
    }

    /**
     * Get the name of the Role.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add permission to the role.
     *
     * @param string $permission
     * @return void
     */
    public function allow($permission)
    {
        $this->addPermission($permission, true);
    }

    /**
     * Revokes a Permission from the Role.
     *
     * @param string $permission
     * @return bool
     */
    public function disallow($permission)
    {
        $this->addPermission($permission, false);
    }

    /**
     * Checks if a permission exists for this role or any child roles.
     *
     * @param string $permission
     * @param array $params
     * @return bool
     */
    public function isGranted($permission, Array $params = null)
    {
        if ($this->checkPermissionCurrent($permission, $params)) {
            return true;
        }

        if ($this->checkPermissionRecursive($permission, $params)) {
            return true;
        }

        return false;
    }

    /**
     * Returns permissions from the Role.
     *
     * @return PermissionInterface[]
     */
    public function getPermissions()
    {
        $mode     = \RecursiveIteratorIterator::CHILD_FIRST;
        $iterator = $this->createRecursiveIterator($mode);

        $permissions = [];

        /** @var $child RoleInterface */
        foreach ($iterator as $child) {
            $permissions = array_replace_recursive($permissions, $child->getPermissions());
        }

        return array_replace_recursive($permissions, $this->permissions);
    }

    /**
     * Do a role inherit from another existing role
     *
     * @param RoleInterface $role
     */
    public function inherit(RoleInterface $role)
    {
        $this->childrens[] = $role;
    }


    /**
     * @return ManagerInterface
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Returns role name.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @param string $permission
     * @param array $params
     * @return bool
     */
    protected function checkPermissionCurrent($permission, Array $params = null)
    {
        list($name, $rules) = $this->parsePermission($permission);
        $keyRules = $this->getKeyRules($rules);

        if (!isset($this->permissions[$name])) {
            return false;
        }

        if (isset($this->permissions[$name][$keyRules]) && $this->permissions[$name][$keyRules]['allow']) {
            return true;
        }

        if (!$rules) {
            $_permission = $this->getManager()->getPermission($name);

            foreach ($this->permissions[$name] as $child) {
                if ($child['rules'] && $_permission->checkRules($child['rules'], $params)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param string $permission
     * @param array $params
     * @return bool
     */
    protected function checkPermissionRecursive($permission, Array $params = null)
    {
        $mode     = \RecursiveIteratorIterator::SELF_FIRST;
        $iterator = $this->createRecursiveIterator($mode);

        /** @var $child RoleInterface */
        foreach ($iterator as $child) {
            if ($child->isGranted($permission, $params)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $permission
     * @return array
     */
    protected function parsePermission($permission)
    {
        if (!is_string($permission)) {
            throw new \InvalidArgumentException('Permission must be a string');
        }

        $name  = $permission;
        $rules = null;

        if (($pos = strpos($permission, '[')) !== false) {

            if (($lastPos = strpos($permission, ']', $pos)) === false) {
                throw new \InvalidArgumentException();
            }

            $name  = substr($permission, 0, $pos);
            $rules = (array)explode(',', substr($permission, $pos + 1, $lastPos - $pos - 1));
        }

        return [$name, $rules];
    }

    /**
     * @param $permission
     * @param bool $allow
     */
    protected function addPermission($permission, $allow = true)
    {
        $manager = $this->getManager();
        list($name, $rules) = $this->parsePermission($permission);

        if (!$manager->hasPermission($name)) {
            throw new \InvalidArgumentException(sprintf('No permission with name "%s" could be found', $name));
        }

        if ($rules) {
            $_permission = $manager->getPermission($name);

            foreach ($rules as $rule) {
                if (!$_permission->hasRule($rule)) {
                    throw new \InvalidArgumentException(
                        sprintf('No rule with name "%s" could be found in permission "%s"', $rule, $name)
                    );
                }
            }
        }

        $this->permissions[$name][$this->getKeyRules($rules)] = [
            'allow' => $allow,
            'rules' => $rules
        ];
    }

    /**
     * @param array $rules
     * @return string
     */
    protected function getKeyRules(Array $rules = null)
    {
        if (!$rules) {
            return static::PERMISSION_KEY_NO_RULES;
        }

        array_map('strtolower', $rules);
        sort($rules, SORT_STRING);

        return implode(',', $rules);
    }

    /**
     * @param int $mode
     * @return \RecursiveIteratorIterator
     */
    protected function createRecursiveIterator($mode = \RecursiveIteratorIterator::CHILD_FIRST)
    {
        return new \RecursiveIteratorIterator($this, $mode);
    }
}
