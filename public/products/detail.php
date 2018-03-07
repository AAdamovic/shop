<?php
session_start();

require_once '../../model/connection.php';
require_once '../../model/productsModel.php';
require_once '../../model/categoriesModel.php';
require_once '../../model/pagesModel.php';

$pagesNavigation = getAllPages($connection);
$categories = getAllCategoriesForNavigation($connection);

$id = (int) $_GET['id'];

$product = getProduct($id, $connection);
if (!$product) {
	$_SESSION['systemMessage'] = "Product doesn't exist!!!";
    header("Location: /message.php");
    die();
}

if (!isset($_SESSION['listed_products'])) {
	$_SESSION['listed_products'] = array();
}

$listedProductsIds = $_SESSION['listed_products'];

if (!in_array($id, $_SESSION['listed_products'])) {
	
	$_SESSION['listed_products'][] = $id;
}

$pageTitle = $product['title'];

// html ali include-ovan (require)
require_once '../../view/headerView.php';
require_once '../../view/navigationView.php';
require_once '../../view/products/productsDetailView.php';
require_once '../../view/footerView.php';

