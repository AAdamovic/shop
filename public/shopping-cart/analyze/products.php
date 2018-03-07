<?php
require_once '../../../model/connection.php';
require_once '../../../model/usersModel.php';
require_once '../../../model/categoriesModel.php';
require_once '../../../model/orderModel.php';
require_once '../../../model/pagesModel.php';

isLoggedIn();
$pagesNavigation = getAllPages($connection);
$basePath = '/shopping-cart/analyze/products.php?'; 
$categories = getAllCategoriesForNavigation($connection);
$pageTitle = 'Analyze Products';




if (isset($_GET['page'])) {
    $page = $_GET['page'];
    // cast u integer
    $page = (int) $page;
    if (!is_numeric($page)) {
        $page = 1;
    }
} else {
    // default 

    $page = 1;
}
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    // cast u integer
    $search = $search;
    
    
}else{
    $search = NULL;
}

$numberOfRowsPerPage = 3;


$totalNumberOfRows = countOrderProducts($connection, $search);

$totalNumberOfPages = ceil($totalNumberOfRows / $numberOfRowsPerPage);

if ($totalNumberOfPages < $page || $page <= 0) {
    $page = 1;
}

$formData = $_GET;
$formErrors = array();
if (isset($formData['click']) && $formData['click'] === 'Search') {

        if (isset($formData["search"])) {
		//Filtering 1
		$formData["search"] = trim($formData["search"]);
		$formData["search"] = strip_tags($formData["search"]);
		
			
	} else {
        
		$formErrors["search"][] = "Polje search mora biti prosledjeno";
	}


    

    if (empty($formErrors)) {
        // filtriraj
       $analyzedProducts = getOrderProductsForAnalyze($connection, $page, $search, $numberOfRowsPerPage); 
    }else{
        
    }
}else{
     $analyzedProducts = getOrderProductsForAnalyze($connection, $page, $search, $numberOfRowsPerPage);
}
    
 
 


require_once '../../../view/headerView.php';
require_once '../../../view/navigationView.php';
require_once '../../../view/shopping-cart/analyze/productsView.php';
require_once '../../../view/footerView.php';