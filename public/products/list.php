<?php
$pageTitle = 'Products list';

// load models
require_once '../../model/connection.php';
require_once '../../model/productsModel.php';
require_once '../../model/usersModel.php';
require_once '../../model/categoriesModel.php';
require_once '../../model/pagesModel.php';

$pagesNavigation = getAllPages($connection);

isLoggedIn();

$categories = getAllCategoriesForNavigation($connection);

$systemMessage = "";
// get systemMessage from SESSION and from some previous page
if(isset($_SESSION['systemMessage'])){
    $systemMessage = $_SESSION['systemMessage'];
    unset($_SESSION['systemMessage']);
}

/** PAGINATION START **/
$basePath = '/products/list.php?';
$numberOfRowsPerPage = 10;
// check and set page param
if(isset($_GET['page'])){
    $page = $_GET['page'];
    // cast u integer
    $page = (int) $page;
    if(!is_numeric($page)){
        $_SESSION['systemMessage'] = "Page isn't valid!!!";
        header("Location: /message.php");
        die();
    }
}else{
    // default 
    $page = 1;
}




// check and set page param
if(isset($_GET['order'])){
    $order = $_GET['order'];
    // check is order in possible values
    $orderPossibleValues = array('title_asc', 'title_desc', 'category_asc', 'category_desc', 'sticker_asc', 'sticker_desc', 'price_asc', 'price_desc', 'discount_asc', 'discount_desc');
    if(!in_array($order, $orderPossibleValues)){
        $_SESSION['systemMessage'] = "Order parameter isn't valid!!!";
        header("Location: /message.php");
        die();
    }
}else{
    // default 
    $order = 'title_asc';
}

$totalNumberOfRows = countProducts($connection);
$totalNumberOfPages = ceil( $totalNumberOfRows / $numberOfRowsPerPage );

if($totalNumberOfPages < $page || $page <= 0){
    $page = 1;
}
$products = getAllProductsForPagination($page, $numberOfRowsPerPage, $connection, NULL, $order);
/** PAGINATION END **/



// html ali include-ovan (require)
require_once '../../view/headerView.php';
require_once '../../view/navigationView.php';
require_once '../../view/products/productsListView.php';
require_once '../../view/footerView.php';

