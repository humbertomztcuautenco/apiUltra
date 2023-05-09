<?php

namespace App\Lib;

class HasPass{
    public static function hash($password){
        $options=[
            'memory_cost'=> 2**15,
            'time_cost' => 4,
            'threads' => 2
        ];
        $hash=password_hash($password, PASSWORD_ARGON2ID, $options);
        return $hash;
    }
}