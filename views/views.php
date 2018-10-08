<?php

/**
 * .
 * User: Jermaine Durham
 * Date: 7/2/18
 * Time: 9:41 AM
 */
class views
{
    public static $SESSION_COOKIE_MANAGEMENT = "";
    const WEB_DIRECTORY = "../";


    function __construct()
    {
        //require_once "session_cookie_managerment.php";
        //$this->SESSION_COOKIE_MANAGEMENT = new session_cookie_managerment();
    }

    public static function index()
    {
        header("location: home");
    }

    public static function home()
    {
        require_once "core/session_cookie_managerment.php";

        if (session_cookie_managerment::check_logged_in() == session_cookie_managerment::NOT_LOGINED) {
            require_once "views/outer_header.php";
            ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    $("#main_table").css("margin-top", ($(this).height() - $("#main_table").height()) / 2.5 + "px");
                });
            </script>
            <table id="main_table" cellspacing="4" cellpadding="5" style="width: 100%; float: left;">
                <tr>
                    <td>
                        <a href="createaccount" target="_parent">
                            <button class="btn-primary" style="width: 100%; height: 60px;">Create Account</button>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="login" target="_parent">
                            <button class="btn-dark" style="width: 100%; height: 60px;">Login</button>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <a href="javascript:void(0);">Forgotten Password</a>
                    </td>
                </tr>
            </table>
            <?php
        } else {
            require "home.php";
        }
    }
    
    public static function myfriends(){
        require_once 'model/friendd.php';
        
        namespace\friendd::setup_friend_suggestions();
        
        require 'myfriends.php';
    }

    public static function myphoto(){
        require_once "member_photo.php";

        $config = new config();

        $mp = new member_photo($_GET['userid']);
    }

    public static function test(){
        require "test.php";
    } 

    public static function createaccount()
    {

        require_once "core/session_cookie_managerment.php";

        if (session_cookie_managerment::check_logged_in() == session_cookie_managerment::LOGINED_IN) {
            header("location: home");
            exit;
        }

        require_once "views/outer_header.php";
        ?>

        <script type="text/javascript">
            var first = $("#first").val();
            var last = $("#last").val();
            var email = $("#email").val();
            var email_exist = 0;
            var pass = $("#pass").val();
            //var country_select_index = $("#country")[0].selectedIndex;
            //var region_selected_index = $("#region")[0].selectedIndex;
            //var city_selected_index = $("#city")[0].selectedIndex;

            function check_information() {


                //Check if email already exist
                $.post("include/check_exist_email.php", {email: $("#email").val()}, function (results) {
                    email_exist = results;
                });


                if (email_exist == 1) {
                    return false;
                }
                return true;
            }

            function submit() {

                $("#mainfrm").submit(function (event) {
                    event.preventDefault();
                });

                if (check_information()) {
                    $.ajax({
                        url: "include/create_account.php",
                        type: "post",
                        data: $("#mainfrm").serialize(),
                        success: function (m) {
                            console.log(m);
                            if (m == 1) {
                                location = "home";
                            } else {
                                $("#errormessage").fadeIn();
                                $("#errormessage").html("There was an error creating your account, please try again later.");
                            }
                        }

                    });
                }
            }

            $(document).ready(function () {

                $("#mainfrm").submit(function (event) {
                    event.preventDefault();

                    submit();
                });

                $("#mainfrm").submit(function (event) {
                    event.preventDefault();
                });

                $.post("include/getCountries.php", function (countries) {
                    $("#country").html(countries);

                    //Check if email already exist while selecting country
                    $.post("include/check_exist_email.php", {email: $("#email").val()}, function (results) {
                        email_exist = results;
                    });
                });

                $.post("include/getregions.php", {countrycode: $(this).val()}, function (getregions) {
                    $("#region").html(getregions);

                    //Check if email already exist while selecting regions.
                    $.post("include/check_exist_email.php", {email: $("#email").val()}, function (results) {
                        email_exist = results;
                    });
                });

                $("#errormessage").hide();

                $("#country").change(function () {

                    $("#region").html("");
                    ;
                    $("#city").html("");

                    $.post("include/getregions.php", {countrycode: $(this).val()}, function (getregions) {
                        $("#region").html(getregions);
                    });
                });

                $("#region").change(function () {
                    $("#city").html("");
                    $.post("include/getcities.php", {regioncode: $(this).val()}, function (getcities) {
                        $("#city").html(getcities);
                    });
                });

            });
        </script>

        <form id="mainfrm" class="form-control" method="post" action="../include/create_account.php">
            <table style="float: left; width: 100%;" class="table" cellpadding="4" cellspacing="4">
                <tr>
                    <td id="errormessage" class="alert-heading alert-warning" align="center">

                    </td>
                </tr>
                <tr>
                    <td>
                        <input class="" type="text" id="first" name="first" style="width: 100%;" placeholder="Firstname"
                               required/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input class="" type="text" id="last" name="last" style="width: 100%;" placeholder="Lastname"
                               required/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input class="" type="email" id="email" name="email" style="width: 100%;" placeholder="Email"
                               required/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input class="" type="password" id="pass" name="pass" style="width: 100%;"
                               placeholder="Password" required/>
                    </td>
                </tr>
                <tr>
                    <td>Select Country:
                        <select id="country" name="country"></select>
                    </td>
                </tr>
                <tr>
                    <td>Select State or Region:
                        <select id="region" name="region">

                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Select City:
                        <select id="city" name="city">

                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <select id="gender" name="gender">
                            <option value="female">Female</option>
                            <option value="male">Male</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Select DOB: <br>
                        <select id="dobMonth" name="dobMonth">
                            <option value="">Month</option>
                            <option value="1">Jan</option>
                            <option value="2">Feb</option>
                            <option value="3">Mar</option>
                            <option value="4">Apr</option>
                            <option value="5">May</option>
                            <option value="6">Jun</option>
                            <option value="7">Jul</option>
                            <option value="8">Aug</option>
                            <option value="9">Sep</option>
                            <option value="10">Oct</option>
                            <option value="11">Nov</option>
                            <option value="12">Dec</option>
                        </select>
                        <select id="dobDay" name="dobDay">
                            <option value="Day">Day</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>
                            <option value="31">31</option>
                        </select>
                        <select id="dobYear" name="dobYear">
                            <?php
                            echo "<option value='Year'>Year</option>";

                            $current_year = date("Y");
                            $age_limit = $current_year - 18;

                            $result = $age_limit;

                            for ($a = 0; $a <= 60; $a++) {
                                echo "<option value='$result'>$result</option>";
                                $result--;
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button id="create_acc_btn" type="submit" class="btn-primary font-weight-bold"
                                style="width: 100%;">Create Account
                        </button>
                    </td>
                </tr>
            </table>
        </form>
        <?php
    }

    public static function myprofile()
    {
        require "myprofile.php";
    }

    public static function profile()
    {
        require "profile.php";
    }

    public static function login()
    {
        require "views/outer_header.php";
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#mainfrm").submit(function (event) {
                    event.preventDefault();

                    $.ajax({
                        url: "include/login.php",
                        type: "post",
                        data: $("#mainfrm").serialize(),
                        success: function (m) {
                            if (m == 1) {
                                location = "home";
                            } else {
                                $("#errormessage").html("Either Email or Password is incorrect");
                            }
                        }

                    });

                });
            });
        </script>
        <form id="mainfrm" class="form-control" method="post" action="../include/login.php">
            <table style="float: left; width: 100%;" class="table" cellpadding="4" cellspacing="4">
                <tr>
                    <td id="errormessage" class="alert-heading alert-warning" align="center">

                    </td>
                </tr>
                <tr>
                    <td>
                        <input class="" type="email" id="email" name="email" style="width: 100%;" placeholder="Email"
                               required/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input class="" type="password" id="pass" name="pass" style="width: 100%;"
                               placeholder="Password" required/>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <a href="javascript:void(0);">Forgotten Password</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button id="login_btn" type="submit" class="btn-primary font-weight-bold" style="width: 100%;">Login</button>
                    </td>
                </tr>
            </table>
        </form>
        <?php
    }

    public static function logout()
    {
        require "outer_header.php";
        require_once "core/session_cookie_managerment.php";

        $sm = new session_cookie_managerment();

        $sm::delete_session();
        $sm::delete_cookie();

        header("location: index");
        ?>

        <?php
    }

    public static function account_setting(){
        require_once "account-setting.php";
    }

    public static function search(){
        require "search.php";
        $s = new search();
        $s::searchp();
    }

    public static function error_page(){
        require_once "error.php";
        LF_ERROR::error_page();
    }

    public static function events(){
        require "views/inner_header.php";
        require "core/events_inc.php";
        require_once "model/eventsd.php";

        require_once "views/event/events.php";
    }

    public static function birthday(){
        require "views/inner_header.php";
        require "core/events_inc.php";
        require_once "model/eventsd.php";

        require_once "views/event/birthday.php";
    }

    public static function calander(){
        require "views/inner_header.php";
        require "core/events_inc.php";
        require_once "model/eventsd.php";

        require_once "views/event/calander.php";
    }
}