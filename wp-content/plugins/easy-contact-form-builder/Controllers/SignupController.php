<?php

namespace GDForm\Controllers;

use GDForm\Models\Fields;
use GDForm\Models\Submission;

class SignupController
{

    /**
     * username
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

    /**
     * user email
     *
     * @var string
     */
    public static $Email;



    public static function setProperty($name,$value){
        return self::$$name = $value;
    }


    public static function registerNewUser()
    {
        return wp_create_user(static::$Username, static::$Password, static::$Email);
    }

}