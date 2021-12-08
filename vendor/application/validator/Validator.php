<?php
namespace lib\validator;

/**
 * Class Validator
 *
 * @package lib\validator
 */
class Validator
{
    /**
     * Result of validation
     *
     * @var bool
     */
    protected $result = true;

    /**
     * Checking variable values, used rules
     *
     * @param $rules
     * @return bool
     */
    public function validation($rules)
    {
        foreach($rules as $variable => $rule)
        {
            $value = $rule[0]??'';

            $variableRules = explode('|', $rule[1]??'');

            foreach($variableRules as $variableRule)
            {
                $func = $variableRule;

                $this->$func($value);
            }
        }

        return $this->result;
    }

    /**
     * Checking integer type
     *
     * @param $value
     */
    protected function integer($value)
    {
        $this->result = preg_match('/^[0-9]+$/', $value);
    }

    /**
     * Checking float type
     *
     * @param $value
     */
    protected function float($value)
    {
        $this->result = preg_match('/^([0-9]+\.[0-9]+)|([0-9]+)$/', $value);
    }

    /**
     * Checking empty type
     *
     * @param $value
     */
    protected function notEmpty($value)
    {
        if(is_array($value)) $this->result = !empty($value);
        else $this->result = (!empty($value) && !preg_match('/^([0]+\.[0]+)$/', $value));
    }

    /**
     * Checking email type
     *
     * @param $value
     */
    protected function email($value)
    {
        $this->result = preg_match(
            '/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/',
            $value
        );
    }
}