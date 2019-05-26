<?php
/**
 * Created by PhpStorm.
 * User: ilanvac
 * Date: 5/22/2019
 * Time: 3:55 PM
 */

namespace App\Http\Traits;


trait ParameterValidationTrait
{
    /**
     * @return array
     */
    protected function validationData()
    {
        $data = $this->all();
        $data = array_merge($data, $this->route()->parameters);

        return $data;
    }
}
