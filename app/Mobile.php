<?php

namespace App;

use App\Interfaces\CarrierInterface;
use App\Services\ContactService;
use App\Services\TwilioService;
use App\Call;


class Mobile implements CarrierInterface
{

	protected $provider;
	
	function __construct(CarrierInterface $provider)
	{
		$this->provider = $provider;
	}

	public function dialContact(Contact $contact)
    {
		echo "Dialing contact: {$contact->getName()} - ({$contact->getPhoneNumber()})";
    }

	public function makeCall(): Call
    {
		$duration = rand(5, 30);
    
		$callStatus = (rand(0, 1) === 0) ? "connected" : "failed";
	
		return new Call($duration, $callStatus);
    }

	public function sendMessage(Contact $contact, string $body)
    {
		echo "Sending message to contact: {$contact->getName()} - ({$contact->getPhoneNumber()}), Message: {$body}";
    }


	public function makeCallByName($name = '')
	{
		if( empty($name) ) return;

		$contact = ContactService::findByNameOrNumber($name);

		if ($contact == null ){
			return null;
		}

		$this->provider->dialContact($contact);

		return $this->provider->makeCall();
	}


	public function sendSmsByNumber(string $number, string $body)
	{
		if( empty($number) ) return;

		$validNumber = ContactService::validateNumber($number);

		if (!$validNumber){
			return null;
		}

		$contact = ContactService::findByNameOrNumber($number);
		return $this->provider->sendMessage($contact,$body);
	}


	public function sendSmsWithTwilio(string $number, string $body)
	{
		if( empty($number) ) return;

		$validNumber = ContactService::validateNumber($number);

		if (!$validNumber){
			return null;
		}

		return TwilioService::sendMessageFromTwilio($number, $body);
	}
}
