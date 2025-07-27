<?php

namespace App\Enumerations;

class UserRole implements OptionEnumerationInterface
{
    const USER_DEV = 'Developer of the VendHound code';
    const USER_ADMIN = 'Administrator of the vending area';
    const USER_CURATOR = 'Curator: A staff member who can vote on applications';
    const USER_APPLNT = 'Applicant: The person submitting the application for a dealership';
    const USER_DEAL = 'Dealer: The primary point of contact for an approved dealership';
    const USER_ASST = 'Assistant: A secondary point of contact associated with an approved dealership';
    const USER_ATTND = 'Attendee: View-only access for the listings directory and search functionality';

public function toArray(): array
    {
        return [
            self::USER_DEV=> self::USER_DEV,
            self::USER_ADMIN => self::USER_ADMIN,
            self::USER_CURATOR => self::USER_CURATOR,
            self::USER_APPLNT => self::USER_APPLNT,
            self::USER_DEAL => self::USER_DEAL,
            self::USER_ASST => self::USER_ASST,
            self::USER_ATTND => self::USER_ATTND
        ];
    }

}