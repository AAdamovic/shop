<?php
if(!isset($_SESSION)){
    session_start();
}

require_once '../model/connection.php';
require_once '../model/productsModel.php';
require_once '../model/categoriesModel.php';
require_once '../model/pagesModel.php';
$categories = getAllCategoriesForNavigation($connection);
$pagesNavigation = getAllPages($connection);
/** PAGINATION START **/
$basePath = '/index.php?';
$numberOfRowsPerPage = 8;
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

$totalNumberOfRows = countProducts($connection);
$totalNumberOfPages = ceil( $totalNumberOfRows / $numberOfRowsPerPage );

if($totalNumberOfPages < $page || $page <= 0){
    $page = 1;
}
$products = getAllProductsForPagination($page, $numberOfRowsPerPage, $connection);
/** PAGINATION END **/

$pageTitle = 'Proizvodi';

// html ali include-ovan (require)
require_once '../view/headerView.php';
require_once '../view/navigationView.php';
require_once '../view/indexView.php';
require_once '../view/footerView.php';