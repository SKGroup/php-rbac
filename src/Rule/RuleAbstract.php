<?php
/**
 * RuleAbstract.php
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


use SKGroup\Rbac\RuleInterface;

/**
 * Class RuleAbstract
 * @package SKGroup\Rbac\Rule
 */
abstract class RuleAbstract implements RuleInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the name of the Rule.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}