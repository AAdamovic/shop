<?php 
$pageTitle = 'Successful order';
require_once '../../model/connection.php';
require_once '../../model/usersModel.php';
require_once '../../model/categoriesModel.php';
require_once '../../model/pagesModel.php';

$pagesNavigation = getAllPages($connection);
$categories = getAllCategoriesForNavigation($connection);
require_once '../../view/headerView.php';
require_once '../../view/navigationView.php';
require_once '../../view/shopping-cart/success-order-view.php';
require_once '../../view/footerView.php';
