<?php

namespace App\Http\Traits;


trait StringFunctionsTrait
{
    public function RandomString($stringLength)
    {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randString = '';
            for ($i = 0; $i < $stringLength; $i++)
            {
                $randString[$i] = $characters[rand(0, strlen($characters)-1)];
            }
            return $randString;
    }
}
