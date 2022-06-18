<?php
session_start();
if(isset($_SESSION["response"]))
{
    $username = $_SESSION["response"]["username"];
    $userpassword = $_SESSION["response"]["userpassword"];
    unset($_SESSION["response"]);
}
header("location:/userAuthMySQL/forms/login.html");
?>