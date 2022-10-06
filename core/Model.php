<?php

namespace app\core;

abstract class Model
{
    public const RULES_REQUIRED = 'required';
    public const RULES_EMAIL= 'email';
    public const RULES_MIN = 'min';
    public const RULES_MAX = 'max';
    public const RULES_MATCH = 'match';
    public const RULES_UNIQUE = 'unique';


    public function loadData($data)
    {
        foreach($data as $key => $value) {
            if(property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    public function labels(): array
    {
        return [];
    }
    public function getLabels($attribute)
    {
        return $this->labels()[$attribute] ?? $attribute;
    }

    public array $errors = [];

    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULES_REQUIRED && !$value) {
                    $this->addErrorForRules($attribute, self::RULES_REQUIRED);
                }
                if($ruleName === self::RULES_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRules($attribute, self::RULES_EMAIL);
                }
                if($ruleName === self::RULES_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorForRules($attribute, self::RULES_MIN, $rule);
                }
                if($ruleName === self::RULES_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorForRules($attribute, self::RULES_MIN, $rule);
                }
                if($ruleName === self::RULES_MATCH && $value !== $this->{$rule['match']}) {
                    $rule['match'] = $this->getLabels($rule['match']);
                    $this->addErrorForRules($attribute, self::RULES_MATCH, $rule);
                }
                if($ruleName === self::RULES_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                    $statement->bindValue(":attr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if($record) {
                        $this->addErrorForRules($attribute, self::RULES_UNIQUE, ['field' => $this->getLabels($attribute)]);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    private function addErrorForRules(string $attribute, string $rule, $params = [])
    {

        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages() {
        return [
            self::RULES_REQUIRED => 'This field is require',
            self::RULES_EMAIL => 'This field must be valid email address',
            self::RULES_MIN => 'Min length of this field must be {min}',
            self::RULES_MAX => 'Max length of this field must bt {max|',
            self::RULES_MATCH => 'This field must be the same as {match}',
            self::RULES_UNIQUE => 'Record with this {field} already exists'
        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute) 
    {
        return $this->errors[$attribute][0] ?? false;
    }
}