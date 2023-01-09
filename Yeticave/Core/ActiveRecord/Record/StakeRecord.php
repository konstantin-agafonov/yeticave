<?php

namespace Yeticave\Core\ActiveRecord\Record;

class StakeRecord extends BaseRecord
{
    public $id_Field = null;
    public $stake_sum_Field = null;
    public $user_id_Field = null;
    public $lot_id_Field = null;
    public $created_at_Field = null;
    public $updated_at_Field = null;

    public function __construct(string $dbClassName, array $recordFields, bool $isNewRecord = false)
    {
        $this->tableName = 'stakes';
        parent::__construct($dbClassName, $recordFields, $isNewRecord);
    }
}
