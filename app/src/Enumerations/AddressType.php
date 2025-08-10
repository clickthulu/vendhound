<?php

namespace App\Enumerations;

enum AddressType: string implements OptionEnumerationInterface
{
    const ADDRESS_MAILING = 'This is where we will send any printed/paper communications';
    const ADDRESS_BILLING = 'The address associated with the user method of payment';
    const ADDRESS_OTHER = 'An address added for some other purpose';

public function toArray(): array
    {
        return [
            self::ADDRESS_MAILING => self::ADDRESS_MAILING,
            self::ADDRESS_BILLING => self::ADDRESS_BILLING,
            self::ADDRESS_OTHER => self::ADDRESS_OTHER
        ];
    }

}