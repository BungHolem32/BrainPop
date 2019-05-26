<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use JWTAuth;


class Controller extends BaseController
{

    /**
     * @return string
     */
    public function assignUser()
    {
        //handle the issue with artisan cli (only run if the done from the web)
        if (strpos(php_sapi_name(), 'cli') === false) {
            $this->user = JWTAuth::parseToken()->authenticate();
        }
    }
}
