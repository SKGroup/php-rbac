<?php
/**
 * RuleInterface.php
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
 * Interface RuleInterface
 * @package SKGroup\Rbac
 */
interface RuleInterface
{
    /**
     * @param string $name
     */
    public function __construct($name);

    /**
     * Get the name of the Rule.
     *
     * @return string
     */
    public function getName();

    /**
     * @param PermissionInterface $permission
     * @param array $params
     * @return bool
     */
    public function execute(PermissionInterface $permission, Array $params = null);
}