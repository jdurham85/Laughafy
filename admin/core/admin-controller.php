<?php

/**
 * Created by PhpStorm.
 * User: jermainedurham
 * Date: 9/10/18
 * Time: 3:34 PM
 */
class admin_controller
{
    function __construct()
    {
        self::parseURL($_SERVER['REQUEST_URI']);
    }

    static function parseURL($url)
    {
        require "views/admin-view.php";
        $url = str_replace("/laughafy/admin/", "", $url);

        $urls = explode("/", $url);

        echo $urls[0];

        $admin_view = new admin_view();

        if ($urls[0] == "" || $urls[0] == null) {
            $admin_view::dashboard();
        }elseif($urls[0] == "test"){
            //echo date("Y");
        }
        //print_r($data);
    }

    static function dashboard(){
        require_once "views/admin-view.php";
        //$aview = new admin_view();
    }

    static function messaging(){

    }

    
}