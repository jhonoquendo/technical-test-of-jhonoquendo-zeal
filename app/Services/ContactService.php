<?php

namespace App\Services;

use App\Contact;


class ContactService
{

    protected $contacts = [
        ['name' => 'John', 'phoneNumber' => '123456789'],
        ['name' => 'Jane', 'phoneNumber' => '987654321'],
        ['name' => 'Katia', 'phoneNumber' => '987654322']
    ];
	
	public static function findByNameOrNumber(string $data): Contact
    {
        foreach ($this->contacts as $contact) {
            if ($contact['name'] === $data || $contact['phoneNumber'] === $data) {
                return new Contact($contact['name'], $contact['phoneNumber']);
            }
        }
        return null;
    }

	public static function validateNumber(string $number): bool
	{
		// logic to validate numbers
		if (!preg_match('/^[0-9]+$/', $numero)) {
			return false;
		}

		if (strlen($number) !== 9) {
			return false;
		} 

		return true;
	}
}