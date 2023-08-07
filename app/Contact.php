<?php

namespace App;


class Contact
{
    private $name;
    private $phoneNumber;

    public function __construct($name, $phoneNumber)
    {
        $this->name = $name;
        $this->phoneNumber = $phoneNumber;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
}