<?php
if(!isset($_SESSION)){
    session_start();
}

require_once '../../model/connection.php';
require_once '../../model/productsModel.php';
require_once '../../model/categoriesModel.php';
require_once '../../model/pagesModel.php';

$pagesNavigation = getAllPages($connection);
$categories = getAllCategoriesForNavigation($connection);

$id = (int) $_GET['id'];

$category = getCategory($id, $connection);
if (!$category) {
	$_SESSION['systemMessage'] = "Category doesn't exist!!!";
    header("Location: /message.php");
    die();
    
}

if (!isset($_SESSION['listed_products'])) {
	$_SESSION['listed_products'] = array();
}

$listedProductsIds = $_SESSION['listed_products'];


/** PAGINATION START **/
$basePath = '/products/category.php?id=' . $id . '&';
$numberOfRowsPerPage = 3;
// check and set page param
if(isset($_GET['page'])){
    $page = $_GET['page'];
    // cast u integer
    $page = (int) $page;
    if(!is_numeric($page)){
        $page = 1;
    }
}else{
    // default 
    $page = 1;
}

$totalNumberOfRows = countProducts($connection, $id);
$totalNumberOfPages = ceil( $totalNumberOfRows / $numberOfRowsPerPage );

if($totalNumberOfPages < $page || $page <= 0){
    $page = 1;
}
$products = getAllProductsForPagination($page, $numberOfRowsPerPage, $connection, $id);
/** PAGINATION END **/

$pageTitle = 'Kategorija ' . $category['name'];

// html ali include-ovan (require)
require_once '../../view/headerView.php';
require_once '../../view/navigationView.php';
require_once '../../view/products/categoryView.php';
require_once '../../view/footerView.php';


