<?php

namespace ActiveRecord\Record;

class LotRecord extends BaseRecord
{
    public $id_Field = null;
    public $pic_Field = null;
    public $name_Field = null;
    public $description_Field = null;
    public $start_price_Field = null;
    public $end_date_Field = null;
    public $stake_step_Field = null;
    public $num_likes_Field = null;
    public $author_id_Field = null;
    public $winner_id_Field = null;
    public $category_id_Field = null;
    public $category_name_Field = null;
    public $created_at_Field = null;
    public $updated_at_Field = null;

    function __construct(string $dbClassName,array $recordFields,bool $isNewRecord = false)
    {
        $this->tableName = 'lots';
        parent::__construct($dbClassName,$recordFields,$isNewRecord);
    }
}