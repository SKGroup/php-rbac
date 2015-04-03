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
     * @param string $name
     */
    public function __construct($name);

    /**
     * Get the name of the Permission.
     *
     * @return string
     */
    public function getName();

    /**
     * Creates a new Rule object.
     * Note that the newly created rule is not added to the Permission yet.
     * You must fill in the needed data and call [[addRule()]] to add it to the system.
     *
     * @param string $rule
     * @param Callable $callback
     * @return RuleInterface
     */
    public function createRule($rule, Callable $callback = null);

    /**
     * Adds a role to the Permission.
     *
     * @param RuleInterface $rule
     * @return void
     */
    public function addRule(RuleInterface $rule);

    /**
     * Checks if a rule exists in the Permission.
     *
     * @param string|RuleInterface $rule
     * @return bool
     */
    public function hasRule($rule);

    /**
     * Revokes a rule from the Permission.
     *
     * @param string|RuleInterface $rule
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
}
