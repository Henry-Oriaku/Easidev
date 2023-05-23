<?php

namespace DevHenry\Sqlite\Model;

class Field
{
    /**
     * @param string $name The Name of the field Likely to be The ID eg. user_name
     * @param string $type The Type of the Field eg. file or text or number
     * @param string $required The Required State of The string returns null if not required
     * @param string $title The Display Name of The Field
     */
    public function __construct(public string $name, public string $type, public string $required, public string $title) {
        
    }

    /**
     * Returns The Name of the field Likely to be The ID eg. user_name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns The Display Name of The Field
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Returns The Type of the Field eg. file or text or number
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Returns The Required State of The string returns null if not required
     */
    public function getRequired(): string
    {
        return $this->required;
    }

}