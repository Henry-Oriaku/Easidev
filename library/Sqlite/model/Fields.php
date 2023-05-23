<?php
namespace DevHenry\Sqlite\Model;
use ArrayObject;
use DevHenry\Sqlite\Model\Field;

class Fields extends ArrayObject
{
    public array $fields;
    private Field $field;
    public function __construct(Field ...$field) {
        $this->fields = $field;
    }

    function add(Field $field): void
    {
        $this->fields[] = $field;
    }
}