<?php
/**
 * Created by PhpStorm.
 * User: ilanvac
 * Date: 5/25/2019
 * Time: 7:25 PM
 */

// Get Query String params
if (!function_exists('getQueryParam')) {
    function getQueryParam($string = null)
    {
        $parameters = request()->route()->parameters;
        if ($string) {
            return $parameters[$string];
        }
        return $parameters;
    }
}

// Get Class Method name
if (!function_exists('getClassMethodName')) {
    function getClassMethodName()
    {
        $action = request()->route()->action;

        return substr(strstr($action['controller'], '@'), 1);

    }
}


// Get Class Method name
if (!function_exists('getControllerRoleId')) {
    function getControllerRoleId()
    {
        return request()->route()->controller->getRoleId();
    }
}


