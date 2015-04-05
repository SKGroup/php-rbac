<?php
/**
 * Callback.php
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
namespace SKGroup\Rbac\Rule;


use SKGroup\Rbac\PermissionInterface;

/**
 * Class RuleCallback
 * @package SKGroup\Rbac
 */
class Callback extends RuleAbstract
{
    /**
     * @var Callable
     */
    protected $callback;

    /**
     * @param string $name
     * @param $callback
     */
    public function __construct($name, Callable $callback)
    {
        parent::__construct($name);
        $this->callback = $callback;
    }

    /**
     * @param PermissionInterface $permission
     * @param array $params
     * @return bool
     */
    public function execute(PermissionInterface $permission, Array $params = null)
    {
        return call_user_func($this->callback, $permission, $params);
    }
}