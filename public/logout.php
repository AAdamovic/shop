<?php
// ucitavanje svih neophodnih skripti
require_once '../model/connection.php';
require_once '../model/usersModel.php';
require_once '../model/categoriesModel.php';
require_once '../model/pagesModel.php';

$pagesNavigation = getAllPages($connection);
$categories = getAllCategoriesForNavigation($connection);

// controller for logout
$systemMessage = "";
$pageTitle = "Logout";
 
// check if is already logged in
if(!isset($_SESSION)){
    session_start();
}

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == TRUE){
    $systemMessage = "Uspesno izlogovan korisnik " . $_SESSION['userName'];
    $_SESSION['loggedIn'] = FALSE;
    unset($_SESSION['userId']);
    unset($_SESSION['userName']);
    
    session_destroy();
}else{
    $systemMessage = "Pokusali ste da izlogujete korisnika a on uopste nije ni bio ulogovan";
}

// html ali include-ovan (require)
require_once '../view/headerView.php';
require_once '../view/navigationView.php';
require_once '../view/logoutView.php';
require_once '../view/footerView.php';