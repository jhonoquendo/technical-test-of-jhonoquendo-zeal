<?php

namespace App\Interfaces;

use App\Contact;
use App\Call;


interface CarrierInterface
{
	
	public function dialContact(Contact $contact);

	public function makeCall(): Call;

	public function sendMessage(Contact $contact, string $body);
	
}