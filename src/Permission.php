<?php
/**
 * Permission.php
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

use SKGroup\Rbac\Rule\Callback;


/**
 * Class Permission
 * @package SKGroup\Rbac
 */
class Permission implements PermissionInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var RuleInterface
     */
    protected $rules;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the name of the Permission.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Adds a rule callback to the Permission.
     *
     * @param string $name
     * @param Callable $callback
     * @return void
     */
    public function addRuleCallback($name, Callable $callback)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('Rule must be a string');
        }

        $rule = new Callback($name, $callback);
        $this->addRule($rule);
    }

    /**
     * Adds a rule to the Permission.
     *
     * @param RuleInterface $rule
     * @return void
     */
    public function addRule(RuleInterface $rule)
    {
        $this->rules[$rule->getName()] = $rule;
    }

    /**
     * Checks if a rule exists in the Permission.
     *
     * @param string $name
     * @return bool
     */
    public function hasRule($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('Rule must be a string');
        }

        return isset($this->rules[$name]);
    }

    /**
     * Revokes a rule from the Permission.
     *
     * @param string $rule
     * @return bool
     */
    public function revokeRule($rule)
    {
        if ($this->hasRule($rule)) {
            unset($this->rules[$rule]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns the named rule from the Permission.
     *
     * @param string $name
     * @return RuleInterface
     */
    public function getRule($name)
    {
        if ($this->hasRule($name)) {
            return $this->rules[$name];
        }

        throw new \InvalidArgumentException(sprintf('No rule with name "%s" could be found', $name));
    }

    /**
     * Returns rules from the Permission.
     *
     * @return RuleInterface[]
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Checks the rules for the Permission.
     *
     * @param string|array $rules
     * @param array $params
     * @return bool
     */
    public function checkRules($rules, Array $params = null)
    {
        if (is_string($rules)) {
            $rules = (array)explode(',', $rules);
        }

        foreach ($rules as $name) {
            if (!$this->hasRule($name) || !$this->getRule($name)->execute($this, $params)) {
                return false;
            }
        }

        return true;
    }
}