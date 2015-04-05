<?php
/**
 * PermissionInterface.php
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
 * Interface PermissionInterface
 * @package SKGroup\Rbac
 */
interface PermissionInterface
{
    /**
     * Get the name of the Permission.
     *
     * @return string
     */
    public function getName();

    /**
     * Adds a rule callback to the Permission.
     *
     * @param string $name
     * @param Callable $callback
     * @return void
     */
    public function addRuleCallback($name, Callable $callback);

    /**
     * Adds a rule to the Permission.
     *
     * @param RuleInterface $rule
     * @return void
     */
    public function addRule(RuleInterface $rule);

    /**
     * Checks if a rule exists in the Permission.
     *
     * @param string $name
     * @return bool
     */
    public function hasRule($name);

    /**
     * Revokes a rule from the Permission.
     *
     * @param string $rule
     * @return bool
     */
    public function revokeRule($rule);

    /**
     * Returns the named rule from the Permission.
     *
     * @param string $name
     * @return RuleInterface
     */
    public function getRule($name);

    /**
     * Returns rules from the Permission.
     *
     * @return RuleInterface[]
     */
    public function getRules();

    /**
     * Checks the rules for the Permission.
     *
     * @param string|array $rules
     * @param array $params
     * @return bool
     */
    public function checkRules($rules, Array $params = null);
}
