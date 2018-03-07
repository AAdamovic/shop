<?php
$pageTitle = 'Users list';

// load models
require_once '../../model/connection.php';
require_once '../../model/usersModel.php';
require_once '../../model/categoriesModel.php';
require_once '../../model/pagesModel.php';

isLoggedIn();

$pagesNavigation = getAllPages($connection);
$categories = getAllCategoriesForNavigation($connection);

$systemMessage = "";
// get systemMessage from SESSION and from some previous page
if(isset($_SESSION['systemMessage'])){
    $systemMessage = $_SESSION['systemMessage'];
    unset($_SESSION['systemMessage']);
}

$users = getAllUsers($connection);

// html ali include-ovan (require)
require_once '../../view/headerView.php';
require_once '../../view/navigationView.php';
require_once '../../view/users/usersListView.php';
require_once '../../view/footerView.php';

