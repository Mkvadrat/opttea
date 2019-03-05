<?php
include('login/config.php');
session_start();
$user_check=$_SESSION['login_user'];

$ses_sql=mysql_query("select log from dop where log='$user_check' ");

$row=mysql_fetch_array($ses_sql);

$login_session=$row['log'];

if(!isset($login_session))
{
header("Location: login/login.php");
}
?>