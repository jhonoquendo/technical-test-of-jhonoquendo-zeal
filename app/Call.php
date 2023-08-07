<?php

namespace App;

class Call
{
    protected $duration;
    protected $callStatus;

    public function __construct($duration, $callStatus)
    {
        $this->duration = $duration;
        $this->callStatus = $callStatus;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getCallStatus()
    {
        return $this->callStatus;
    }
}