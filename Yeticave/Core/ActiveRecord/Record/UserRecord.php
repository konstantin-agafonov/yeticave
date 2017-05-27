<?php

namespace Yeticave\Core\ActiveRecord\Record;

class UserRecord extends BaseRecord
{
    public $id_Field = null;
    public $name_Field = null;
    public $avatar_Field = null;
    public $email_Field = null;
    public $password_Field = null;
    public $contacts_Field = null;
    public $created_at_Field = null;
    public $updated_at_Field = null;

    function __construct(string $dbClassName,array $recordFields,bool $isNewRecord = false)
    {
        $this->tableName = 'users';
        parent::__construct($dbClassName,$recordFields,$isNewRecord);
    }
}