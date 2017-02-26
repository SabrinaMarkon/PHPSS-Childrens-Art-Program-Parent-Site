<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
if (!isset($_SESSION))
{
session_start();
}
require_once "config/Database.php";
require_once "config/Settings.php";
require_once "config/Layout.php";

function sabrina_autoloader($class) {
	require "classes/" . $class . ".php";
}
spl_autoload_register("sabrina_autoloader");

$sitesettings = new Settings();
$settings = $sitesettings->getSettings();
foreach ($settings as $key => $value)
{
	$$key = $value;
}

if (isset($_REQUEST['referid']))
{
	$referid = $_REQUEST['referid'];
	$_SESSION['referid'] = $referid;
}
else
{
	$referid = "";
}

######################################
if (isset($_POST['login']))
{
$_SESSION['username'] = $_REQUEST['username'];
$_SESSION['password'] = $_REQUEST['password'];
$logincheck = new User();
$newlogin = $logincheck->userLogin($_SESSION['username'],$_SESSION['password']);
 if ($newlogin === false)
	{
	$logout = new User();
	$logout->userLogout();
	}
else
	{
	# returned member details.
	foreach ($newlogin as $key => $value)
		{
		$$key = $value;
		$_SESSION[$key] = $value;
		}
	$showgravatar = $logincheck->getGravatar($_SESSION['username'],$_SESSION['email']);
	}
}
if (isset($_POST['forgotlogin']))
{
$forgot = new User();
$showforgot = $forgot->forgotLogin($sitename,$domain,$adminemail);
}
if (isset($_POST['contactus']))
{
$contact = new Contact();
$sentcontact = $contact->sendContact($settings);
}
if (isset($_POST['register']))
{
$register = new User();
$showregistration = $register->newSignup($settings);
}
if (isset($_POST['saveprofile']))
{
$update = new User();
$showupdate = $update->saveProfile($_SESSION['username']);
}
if (isset($_GET['page']) && ($_GET['page'] == "logout"))
{
$logout = new User();
$logout->userLogout();
$logoutpage = new PageContent();
$showlogout = $logoutpage->showPage('Logout Page');
}
######################################

if ((!empty($_GET['page'])) and ((file_exists($_GET['page'] . ".php") and ($_GET['page'] != "index")))) {

    $Layout = new Layout();
    $Layout->showHeader();
    $page = $_REQUEST['page'];
    include $page . ".php";
    $Layout->showFooter();

} elseif ((!empty($_GET['page'])) and ($_GET['page'] != "index") and ($_GET['page'] == "ipn")) {

    // received a POST from paypal:
    $raw_post_data = file_get_contents('php://input');
    $ipn = new IPN($raw_post_data, $domain, $sitename, $adminname, $adminemail);

} else {

    $Layout = new Layout();
    $Layout->showHeader();
    include "main.php";
    $Layout->showFooter();
}
