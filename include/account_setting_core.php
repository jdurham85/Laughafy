<?php 
session_start();

require "core_file.php";

$db = new database();
$c = new config();

if(!empty($_POST)){
	switch(true){
		case $_POST['update_member_city']:
			account_setting_inc::update_member_cityid($c->get_session_id(), $_POST['update_member_city']);
		break;

		case $_POST['update_member_state']:
			account_setting_inc::update_member_stateid($c->get_session_id(), $_POST['update_member_state']);
		break;

		case $_POST['update_member_country']:
			account_setting_inc::update_member_countryid($c->get_session_id(), $_POST['update_member_country']);
		break;
	}
}
?>