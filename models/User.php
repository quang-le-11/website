<?php
namespace app\models;

use app\core\DbModel;

class User extends DbModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;


    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public int $status = self::STATUS_INACTIVE;
    public string $password = '';
    public string $confirmPassword = '';

    public function tableName(): string
    {
        return 'users';
    }

    public function attributes(): array
    {
        return ['firstname', 'lastname', 'email', 'password', 'status'];
    }

    public function save()
    {
        $this->status = self::STATUS_INACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function rules(): array
    {
        return [
            'firstname' => [self::RULES_REQUIRED],
            'lastname' => [self::RULES_REQUIRED],
            'email' => [self::RULES_REQUIRED, self::RULES_EMAIL],
            'password' => [self::RULES_REQUIRED, [self::RULES_MIN, 'min' => 8], [self::RULES_MAX, 'max' => 24]],
            'confirmPassword' => [self::RULES_REQUIRED, [self::RULES_MATCH, 'match' => 'password']],
        ];
    }
}