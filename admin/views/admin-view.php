<?php

/**
 * Created by PhpStorm.
 * User: jermainedurham
 * Date: 9/10/18
 * Time: 3:34 PM
 */
class admin_view
{
    function __construct()
    {
        self::header();
        self::side_menu();
    }

    static function header()
    {
        ?>
        <?php  ?>
        <div id="admin-header">
            <div id="admin-menu-btn" onclick="admin_menu_toggle();">Menu</div>
            <div id="admin-title">Laughfy (Admintrator)</div>
        </div>
        <script type="text/javascript">
            function admin_menu_toggle(){
                $("#admin_menu").slideToggle();
            }
        </script>
        <?php
    }

    static function side_menu()
    {
        ?>
        <script type="text/javascript">

        </script>
        <div id="admin_menu">
            <div class="admin-menu-btn">Dashboard</div>
            <div class="admin-menu-btn">Users</div>
            <div class="admin-menu-btn">Messages</div>
            <div class="admin-menu-btn">Events</div>
            <div class="admin-menu-btn">Advertise</div>
            <div class="admin-menu-btn"></div>
        </div>
        <?php
    }

    static function dashboard()
    {
        ?>
        <div id="admin-body">
            <?php require 'views/dashboard.php'; ?>
        </div>
        <?php
    }

    static function messaging(){

    }
}