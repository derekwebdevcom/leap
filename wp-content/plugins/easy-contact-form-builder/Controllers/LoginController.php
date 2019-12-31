<?php

namespace GDForm\Controllers;

use GDForm\Models\Fields;
use GDForm\Models\Submission;

class LoginController
{

    /**
     * username or email
     *
     * @var string
     */
    public static $Username;


    /**
     * user password
     *
     * @var string
     */
    public static $Password;



    public static function setProperty($name,$value){
        return self::$$name = $value;
    }


    public static function loginUser()
    {
        return wp_signon(array(
            'user_login'    => static::$Username,
            'user_password' => static::$Password,
        ));


    }

}