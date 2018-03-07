<?php

if(!isset($_SESSION)){
    session_start();
}

require_once '../model/connection.php';
require_once '../model/productsModel.php';
require_once '../model/categoriesModel.php';
require_once '../model/pagesModel.php';

$pagesNavigation = getAllPages($connection);

$categories = getAllCategoriesForNavigation($connection);

// get systemMessage from SESSION and from some previous page
$systemMessage = "";
if(isset($_SESSION['systemMessage'])){
    $systemMessage = $_SESSION['systemMessage'];
    unset($_SESSION['systemMessage']);
}


$pageTitle = 'Message';
// html ali include-ovan (require)
require_once '../view/headerView.php';
require_once '../view/navigationView.php';
require_once '../view/messageView.php';
require_once '../view/footerView.php';


