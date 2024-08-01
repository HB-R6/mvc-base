<?php

namespace App\Routing\Exception;

use Exception;

class RouteNotFoundException extends Exception
{
    public function __construct()
    {
        $this->message = "La route n'a pas été trouvée";
    }
}
