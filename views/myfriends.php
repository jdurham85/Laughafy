<?php
/**
 * .
 * User: Jermaine Durham
 * Date: 7/29/18
 * Time: 1:16 AM
 */

require_once "model/profiled.php";
require "inner_header.php";
require_once "friend_inc.php";

?>
<link rel="stylesheet" href="css/friend_style.css"/>
<?php
if (isset($_GET['request']) && $_GET['request'] != "") {
    ?>
    <script type="text/javascript">
        //setTimeout(function () {
            $(document).ready(function(){
                $("#friend_request_tb").show();
                $("#friend_suggestion_tb").hide();
                $("#friend_tb").hide();
                $("#friend_contact_tb").hide();
            });
        //}, 40);
    </script>
    <?php
}
?>
<script type="text/javascript">
    function frequest_tb_show() {
        $("#friend_request_tb").show();
        $("#friend_suggestion_tb").hide();
        $("#friend_tb").hide();
        $("#friend_contact_tb").hide();
    }

    function suggestion_tb_show() {
        $("#friend_suggestion_tb").show();
        $("#friend_request_tb").hide();
        $("#friend_contact_tb").hide();
        $("#friend_tb").hide();
    }

    function contact_tb_show() {
        $("#friend_contact_tb").show();
        $("#friend_request_tb").hide();
        $("#friend_suggestion_tb").hide();
        $("#friend_tb").hide();
    }

    function friends_tb_show() {
        $("#friend_suggestion_tb").hide();
        $("#friend_request_tb").hide();
        $("#friend_contact_tb").hide();
        $("#friend_tb").show();

        my_friends_show();
    }
</script>
<table id="friendmain_tb">
    <tr>
        <td onclick="suggestion_tb_show();">
            Suggestions
            <div id="friend_sugesstion_pl"></div>
        </td>
        <td onclick="frequest_tb_show();">
            Request
            <div id="friend_request_pl"></div>
        </td>
        <!--td onclick="contact_tb_show();">
            Contacts
            <div id="friend_contact_pl"></div>
        </td -->
        <td onclick="friends_tb_show();">
            Friends
            <div id="friend_pl"></div>
        </td>
    </tr>
</table>
<table id="friend_suggestion_tb">
    <tr>
        <td>
            <?php
namespace\friend_inc::friend_suggestion();
?>
        </td>
    </tr>
</table>

<table id="friend_request_tb">
    <tr>
        <td>
            <?php
namespace\friend_inc::friend_pending_request();
?>
        </td>
    </tr>
</table>

<table id="friend_contact_tb">
    <tr>
        <td>

        </td>
    </tr>
</table>

<table id="friend_tb">
    <tr>
        <td>
            <?php
//namespace\friendd::my_friends_list();
?>
        </td>
    </tr>
</table>