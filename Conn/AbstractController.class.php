<?php

class AbstractController 
{

    public function getService($service)
    {
        return new $service();
    }

}