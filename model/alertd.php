<?php

/**
 * .
 * User: Jermaine Durham
 * Date: 7/25/18
 * Time: 3:48 AM
 */
class alertd extends database
{
    private $config = "";
    private $alert_count = 0;

    function __construct()
    {
        $this->config = namespace\config;
    }

    public function friend_request_count(){

    }

    public function post_new_count(){

    }

    public function alert_count_total(){
        echo $this->alert_count;
    }

    public function message_unseen_count(){

    }

    public function message_member_unseen_count($frommemberid){

    }
}