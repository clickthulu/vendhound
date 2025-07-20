<?php

namespace App\Enumerations;

class UnitOfMeasurement implements OptionEnumerationInterface
{
    const UOM_METER = 'Meter';
    const UOM_CENTIMETER = 'Centimeter';
    const UOM_FEET = 'Feet';
    const UOM_INCH = 'Inch';
    const ABR_METER = 'm';
    const ABR_CENTIMETER = 'cm';
    const ABR_FEET = 'ft';
    const ABR_INCH = 'in';


    public function toArray(): array
    {
        return [
            self::UOM_METER => self::ABR_METER,
            self::UOM_CENTIMETER => self::ABR_CENTIMETER,
            self::UOM_FEET => self::ABR_FEET,
            self::UOM_INCH => self::ABR_INCH,
        ];
    }

}