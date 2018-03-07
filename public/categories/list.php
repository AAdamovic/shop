<?php
$pageTitle = 'Categories list';

// load models
require_once '../../model/connection.php';
require_once '../../model/usersModel.php';
require_once '../../model/categoriesModel.php';
require_once '../../model/pagesModel.php';

$pagesNavigation = getAllPages($connection);

isLoggedIn();
// get categories for navigation
$categories = getAllCategoriesForNavigation($connection);

// get all categories for table
$allCategories = getAllCategories($connection);

$systemMessage = "";
// get systemMessage from SESSION and from some previous page
if(isset($_SESSION['systemMessage'])){
    $systemMessage = $_SESSION['systemMessage'];
    unset($_SESSION['systemMessage']);
}


// html ali include-ovan (require)
require_once '../../view/headerView.php';
require_once '../../view/navigationView.php';
require_once '../../view/categories/listView.php';
require_once '../../view/footerView.php';

