<?php
require_once('config.php');
require_once('vendor/autoload.php');
session_start();

use App\Core\Router;
use App\Core\Session;

//we generate a key specific to the session (if it is not already done)
$key = Session::generateKey();
// we generate the CSRF token for THIS HTTP REQUEST ONLY
$csrf_token = hash_hmac("sha256", SECRET, $key);

// if the protection present in Router it returns true
if(Router::CSRFProtection($csrf_token)){
    //we let the router request the controller
     //(continue handling the request as normal)
    $response = Router::handleRequest($_GET);
}//otherwise, we redirect to logout
else{
    Session::eraseKey();
    Session::addFlash("error", "Invalid CSRF Token !!");
    Router::redirect([
        "ctrl"   => "security", 
        "method" => "logout"
    ]);
}

$title = null;
if(isset($response["data"]["title"])){
    $title = $response["data"]["title"];
    unset($response["data"]["title"]);
}

$data = isset($response["data"]) ? $response["data"] : null;

// output buffering (temporisation sortie)

ob_start();

include $response['view'];
$page = ob_get_contents();

ob_end_clean();

include "view/layout.php";