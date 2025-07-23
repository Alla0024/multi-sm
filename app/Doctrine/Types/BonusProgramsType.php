<?php

namespace App\Doctrine\Types;

class BonusProgramsType extends AbstractEnumType
{
    protected string $name = 'bonus_programs_type';
    protected array $values = [];
    protected static array $options = array(
        'special',
        'base',
    );

    function __init()
    {
        $this->values = self::$options;
    }

    public function getValidValues(): array
    {
        return self::$options;
    }
}
