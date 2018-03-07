<?php
if (!isset($_SESSION)) {
    session_start();
}
$pageTitle = 'Pages list';

// load models
require_once '../../model/connection.php';
require_once '../../model/usersModel.php';
require_once '../../model/categoriesModel.php';
require_once '../../model/pagesModel.php';

isLoggedIn();

$pagesNavigation = getAllPages($connection);
// get categories for navigation
$categories = getAllCategoriesForNavigation($connection);

// get all categories for table
$allPages = getAllPages($connection);

$systemMessage = "";
// get systemMessage from SESSION and from some previous page
if(isset($_SESSION['systemMessage'])){
    $systemMessage = $_SESSION['systemMessage'];
    unset($_SESSION['systemMessage']);
}


// html ali include-ovan (require)
require_once '../../view/headerView.php';
require_once '../../view/navigationView.php';
require_once '../../view/pages/list.php';
require_once '../../view/footerView.php';


