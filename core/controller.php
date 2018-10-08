<?php

/**
 * .
 * User: Jermaine Durham
 * Date: 7/2/18
 * Time: 8:16 AM
 */
class controller
{

    public $REQUEST_URL = [];
    public $views;
    public $STORED_URL = [];


    public function autoload()
    {
        $this->parseurl($_SERVER['REQUEST_URI']);
        $this->route_to_page();
    }

    private function parseurl($url)
    {
        $url = str_replace("/laughafy", "", $url);

        $url = explode("/", $url);

        foreach ($url as $value) {
            if (!$value == "") {
                $this->REQUEST_URL[] = $value;
            }

            //print_r($this->REQUEST_URL);
        }
    }

    public function addURL($url)
    {
        $this->STORED_URL[] = $url;
    }

    private function route_to_page()
    {
        require "views/views.php";

        if (strpos($this->REQUEST_URL[0], "profile?userid") !== false) {
            //require_once "../admin-view/profilev.php";
            if ($_GET["userid"] == $_SESSION['SessionMemberID']) {
                header("location: myprofile");
            } else {
                views::profile();
            }
            exit;
        }

        if (strpos($this->REQUEST_URL[0], "photo?userid") !== false) {
            //require_once "../admin-view/profilev.php";
            if ($_GET["userid"] == $_SESSION['SessionMemberID']) {
                header("location: myprofile");
            } else {
                views::myphoto();
            }
            exit;
        }

        if ($this->REQUEST_URL[0] == "myfriends" || strpos($this->REQUEST_URL[0], "myfriends?request=") !== false) {
            views::myfriends();
            exit;
        }

        if(method_exists("views", $this->REQUEST_URL[0])){
            call_user_func(array("views", $this->REQUEST_URL[0]));
            exit;
        }elseif($this->REQUEST_URL[0] == ""){
            views::home();
            exit;
        }else{
            views::error_page();
            exit;
        }

        //echo $this->REQUEST_URL[];

        //if(method_exists("view", $this))

        //echo $param_total;
        //switch (count($this->REQUEST_URL)) {
        //case 0:
        //admin-views::home();
        //break;

        //case 1:
        
        /*
        //Home Page
        if (in_array("home", $this->REQUEST_URL)) {
            views::home();
            exit;
        } elseif ($this->REQUEST_URL[0] == "") {
            views::home();
            exit;
        }

        //Index Page
        if (in_array("index", $this->REQUEST_URL)) {
            views::home();
            exit;
        }

        //Create Account Page
        if (in_array("createaccount", $this->REQUEST_URL)) {
            views::create_account();
            exit;
        }

        //LOGIN
        if (in_array("login", $this->REQUEST_URL)) {
            views::login();
            exit;
        }

        //LOGOUT
        if (in_array("logout", $this->REQUEST_URL)) {
            views::logout();
            exit;
        }

        //TEST
        if (in_array("test", $this->REQUEST_URL)) {
            require_once "views/test.php";
            exit;
        }

        //DB_ERROR_PAGE
        if (in_array("db_error", $this->REQUEST_URL)) {
            require_once "views/error.php";
            $DB_ERROR_PG = new LF_ERROR();

            $DB_ERROR_PG::db_errorpage();
            exit;
        }

        //MyProfile Page
        if (in_array("myprofile", $this->REQUEST_URL)) {
            views::myprofile();
            exit;
        }

        //MyPhoto Page
        if (in_array("myphoto", $this->REQUEST_URL)) {
            views::myphoto();
            exit;
        }

        //break;

        //case 2:
        if (strpos($this->REQUEST_URL[0], "profile?userid") !== false) {
            //require_once "../admin-view/profilev.php";
            if ($_GET["userid"] == $_SESSION['SessionMemberID']) {
                header("location: myprofile");
            } else {
                views::profile();
            }
            exit;
        }

        if (strpos($this->REQUEST_URL[0], "photo?userid") !== false) {
            //require_once "../admin-view/profilev.php";
            if ($_GET["userid"] == $_SESSION['SessionMemberID']) {
                header("location: myprofile");
            } else {
                views::myphoto();
            }
            exit;
        }

        if ($this->REQUEST_URL[0] == "myfriends" || strpos($this->REQUEST_URL[0], "myfriends?request=") !== false) {
            views::myfriends();
            exit;
        }

        if (strpos($this->REQUEST_URL[0], "account-setting") !== false) {
            views::account_setting();
        }

        if(strpos($this->REQUEST_URL[0], "search") !== false){
            views::search();
        }

        /*if (in_array($this->REQUEST_URL[0], $this->STORED_URL)) {
            require_once "admin-view/" . $this->REQUEST_URL[0] . ".php";
        } elseif ($param_total > 0) {
            require_once "admin-view/" . $this->REQUEST_URL[0] . ".php";
            //break;
        }*/

        //break;
    }

    //}
}