<?php

namespace ActiveRecord\Record;

abstract class BaseRecord
{
    protected $tableName = null;
    protected $db = null;
    protected $isNewRecord = false;

    function __construct(string $dbClassName,array $recordFields,bool $isNewRecord = false)
    {
        $this->db = $dbClassName;
        $this->isNewRecord = $isNewRecord;
        foreach ($recordFields as $key => $field) {
            $this->$key = $field;
        }
    }

    public function __set($name,$value)
    {
        $class = get_class($this);
        if (property_exists($class,$name . '_Field')) {
            $this->{$name . '_Field'} = $value;
        } else {
            echo "<p style='color:red;'>Свойcтво $name не найдено в классе $class!</p>";
        }
    }

    function getTableName()
    {
        return $this->tableName;
    }

    function save()
    {
        if ($this->isNewRecord) {

            $props = get_object_vars($this);
            $fields = [];
            $placeholders = [];

            $stopList = ['id_Field','created_at_Field','updated_at_Field','category_name_Field'];

            foreach($props as $key => $value) {
                if ((strpos($key,'_Field')!==false) && (!in_array($key,$stopList))) {
                    if (isset($value)) {
                        $fields[] = str_replace('_Field','',$key);
                        $placeholders[] = '?';
                        $values[] = $value;
                    }
                }
            }

            $fields = implode(',',$fields);
            $placeholders = implode(',',$placeholders);

            $this->id_Field = $this->db::insert("insert into {$this->tableName} ($fields) values ($placeholders);",$values);
            if (!$this->id_Field) {
                echo '<p style="color:red;">Ошибка сохранения записи в таблицу ' . $this->tableName . '!</p>';
            }

            return $this->id_Field;

        } else {
            echo '<p style="color:red;">Невозможно сохранить запись в БД - признак новой записи не установлен!</p>';
        }
    }
}