<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once '../../model/connection.php';
require_once '../../model/categoriesModel.php';
require_once '../../model/pagesModel.php';

$pagesNavigation = getAllPages($connection);

$id = $_GET['id'];
$id = (int)$id;
$page = getPage($id, $connection);
if (!$page) {
	$_SESSION['systemMessage'] = "Page doesn't exist!!!";
    header("Location: /message.php");
    die();
}
$page = getPage($id, $connection);
$pageTitle = $page['title'];
$categories = getAllCategoriesForNavigation($connection);


require_once '../../view/headerView.php';
require_once '../../view/navigationView.php';
require_once '../../view/pages/detail.php';
require_once '../../view/footerView.php';
