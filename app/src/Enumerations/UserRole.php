<?php

namespace App\Enumerations;

use App\Exception\RoleNotFoundException;

class UserRole implements OptionEnumerationInterface
{
    const DESC_DEVELOPER = 'Developer of the VendHound code';
    const DESC_ADMIN = 'Administrator of the vending area';
    const DESC_CURATOR = 'Curator: A staff member who can vote on applications';
    const DESC_DEALER = 'Dealer: The primary point of contact for an approved dealership';
//    const DESC_APPLICANT = 'Applicant: The person submitting the application for a dealership';
    const DESC_ASSISTANT = 'Assistant: A secondary point of contact associated with an approved dealership';
    const DESC_USER = 'Attendee: View-only access for the listings directory and search functionality';

    const ROLE_DEVELOPER = "ROLE_DEVELOPER";
    const ROLE_ADMIN = "ROLE_ADMIN";
    const ROLE_CURATOR = "ROLE_CURATOR";
    const ROLE_DEALER = "ROLE_DEALER";
//    const ROLE_APPLICANT = "ROLE_APPLICANT";
    const ROLE_ASSISTANT = "ROLE_ASSISTANT";
    const ROLE_USER = "ROLE_USER";


    public function toArray(): array
    {
        return [
            self::DESC_DEVELOPER => self::ROLE_DEVELOPER,
            self::DESC_ADMIN => self::ROLE_ADMIN,
            self::DESC_CURATOR => self::ROLE_CURATOR,
            self::DESC_DEALER => self::ROLE_DEALER,
//            self::DESC_APPLICANT => self::ROLE_APPLICANT,
            self::DESC_ASSISTANT => self::ROLE_ASSISTANT,
            self::DESC_USER => self::ROLE_USER
        ];
    }
    
    public static function normalize($role)
    {
        switch (strtoupper($role)) {
            case self::ROLE_DEVELOPER:
                return self::ROLE_DEVELOPER;
            case self::ROLE_ADMIN:
                return self::ROLE_ADMIN;
            case self::ROLE_CURATOR:
                return self::ROLE_CURATOR;
            case self::ROLE_DEALER:
                return self::ROLE_DEALER;
            case self::ROLE_ASSISTANT:
                return self::ROLE_ASSISTANT;
        }
        throw new RoleNotFoundException("Role {$role} was not found");
    }    

}