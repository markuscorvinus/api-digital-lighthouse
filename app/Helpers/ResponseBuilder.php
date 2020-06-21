<?php

namespace App\Helpers;


class ResponseBuilder
{
    public static function generate_response($status, int $status_code, $message, array $data = null)
    {
        $response = ["status" => $status, 
                    "status_code" => $status_code,
                    "message" => $message];

        if(!is_null($data) && !empty($data)){
            $response = array_merge($response, (key_exists("data",$data) ? $data : ["data" => $data]));
        }

        return $response;
    }
}