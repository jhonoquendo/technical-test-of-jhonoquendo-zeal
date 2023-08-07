<?php

namespace Tests;

use Mockery as m;
use App\Interfaces\CarrierInterface;
use App\Mobile;
use App\Call;
use App\Contact;
use PHPUnit\Framework\TestCase;

class MobileTest extends TestCase
{

	protected $provider;
	protected $contactService;
    protected function setUp(): void
    {
		$this->contactService = m::mock('overload:App\Services\ContactService');
		$this->provider = m::mock(CarrierInterface::class);
        parent::setUp();
    }

    protected function tearDown(): void
    {
        unset($this->contactService);
        unset($this->provider);
        parent::tearDown();
    }

	protected function mockFindByNameOrNumber(string $name, $result){
		$this->contactService->shouldReceive('findByNameOrNumber')->with($name)->andReturn($result);
	}
	
	/** @test */
	public function it_returns_null_when_name_empty()
	{

		$this->provider->shouldReceive('dialContact')->andReturn(null);
    	$this->provider->shouldReceive('makeCall')->andReturn(null);

		$mobile = new Mobile($this->provider);
		$this->assertNull($mobile->makeCallByName(''));
	}

	/** @test */
 	public function it_returns_a_contact_valid_when_name_is_not_empty()
	{
		$contactName = "John";
		$validContact = new Contact($contactName, '123456789');

		$this->mockFindByNameOrNumber($contactName, $validContact);

		$this->provider->shouldReceive('dialContact')->andReturn($validContact);
		$this->provider->shouldReceive('makeCall')->andReturn(new Call(10, 'connected'));

		$mobile = new Mobile($this->provider);
		$call = $mobile->makeCallByName($contactName);

		$this->assertInstanceOf(Call::class, $call);
		$this->assertEquals(10, $call->getDuration());
		$this->assertEquals('connected', $call->getCallStatus());
	} 

	/** @test */
	public function it_returns_null_when_contact_not_found()
	{

		$this->provider->shouldReceive('dialContact')->andReturnNull();
		$this->provider->shouldReceive('makeCall')->andReturnNull();

		$this->mockFindByNameOrNumber('test', null);

		$mobile = new Mobile($this->provider);
		$result = $mobile->makeCallByName('test');

		$this->assertNull($result);
	}
	/** @test */
	public function it_returns_ok_when_send_sms()
	{
		$contactNumber = "987654322";
		$validContact = new Contact("Katia", $contactNumber);
		$body = "This is a test message";


		$this->contactService->shouldReceive('validateNumber')->with($contactNumber)->andReturn(true);
		$this->mockFindByNameOrNumber($contactNumber, $validContact);

		$resultMessage = "Sending message to contact: Katia - ({$contactNumber}), Message: {$body}";

		$this->provider->shouldReceive('sendMessage')->andReturn($resultMessage);

		$mobile = new Mobile($this->provider);
		$sendSMS = $mobile->sendSmsByNumber($contactNumber, $body);

		$this->assertEquals($sendSMS, $resultMessage);
	} 
	/** @test */
	public function it_returns_error_when_send_sms()
	{
		$contactNumber = "9876543222";
		$validContact = new Contact("Katia", $contactNumber);
		$body = "This is a test message";


		$this->contactService->shouldReceive('validateNumber')->with($contactNumber)->andReturn(false);

		$resultMessage = "Sending message to contact: Katia - ({$contactNumber}), Message: {$body}";

		$this->provider->shouldReceive('sendMessage')->andReturn($resultMessage);

		$mobile = new Mobile($this->provider);
		$sendSMS = $mobile->sendSmsByNumber($contactNumber, $body);

		$this->assertEquals($sendSMS, null);
	}
}
