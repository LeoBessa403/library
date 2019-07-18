<?php

class AbstractController
{

    public function getService($service)
    {
        return new $service();
    }
    public static function getServiceStatic($service)
    {
        return new $service();
    }

}