<?php

if (!isset($_SESSION)) {
    session_start();
}

$pageTitle = 'Orders';
require_once '../../../model/connection.php';
require_once '../../../model/usersModel.php';
require_once '../../../model/categoriesModel.php';
require_once '../../../model/orderModel.php';
require_once '../../../model/pagesModel.php';

isLoggedIn();

$pagesNavigation = getAllPages($connection);


  $basePath = '/shopping-cart/analyze/order.php?';  


//get Page
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
//search through get 
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    // cast u integer
    $search = $search;
    
    
}else{
    $search = NULL;
}
//if(is_string($search)){
//    print_r($_GET);
//}


$categories = getAllCategoriesForNavigation($connection);

$numberOfRowsPerPage = 3;


$totalNumberOfRows = countOrders($connection, $search);


$totalNumberOfPages = ceil($totalNumberOfRows / $numberOfRowsPerPage);

if ($totalNumberOfPages < $page || $page <= 0) {
    $page = 1;
}

$formErrors = array();
$formData = $_GET;

if (isset($formData["click"]) && $formData["click"] == "Search") {

    if (isset($formData["search"])) {
		//Filtering 1
		$formData["search"] = trim($formData["search"]);
		$formData["search"] = strip_tags($formData["search"]);
		
		//Validation - if required
		if ($formData["search"] === "") {
			$formErrors["search"][] = "Polje search ne sme biti prazno";
		}
			
	} else {
        
		$formErrors["search"][] = "Polje search mora biti prosledjeno";
	}


    

    if (empty($formErrors)) {
        // filtriraj
        $orders = getAllOrdersForPagination($page, $numberOfRowsPerPage, $connection, $search);  
    }
}else{
    $orders = getAllOrdersForPagination($page, $numberOfRowsPerPage, $connection, $search);
}
    

 
  $ordersAndProducts = array();
  
  foreach ($orders as $order) {
       
           $ordersAndProducts[$order['id']] = getAllOrderProducts($connection,$order['id']);
}
//print_r($orders);



//spojiti default vrednosti i ono sto je korisnik poslao kroz formu ako je poslao
//$formData = array_merge($defaultFormData, $formData);
require_once '../../../view/headerView.php';
require_once '../../../view/navigationView.php';
require_once '../../../view/shopping-cart/analyze/orderView.php';
require_once '../../../view/footerView.php';

?>

