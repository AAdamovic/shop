<?php



// models
require_once '../../model/connection.php';
require_once '../../model/usersModel.php';
require_once '../../model/categoriesModel.php';
require_once '../../model/pagesModel.php';

isLoggedIn();

$pagesNavigation = getAllPages($connection);
$categories = getAllCategoriesForNavigation($connection);

$id = $_GET['id'];
$id = (int)$id;
$user = getUser($id, $connection);
if (!$user) {
	$_SESSION['systemMessage'] = "User doesn't exist!!!";
    header("Location: /message.php");
    die();
}
$pageTitle = "Delete user " . $user['name'] . " " . $user['surname'];
//ovde su default vrednosti za polja u formi
$defaultFormData = array();

//ovde se smestaju greske koje imaju polja u formi
$formErrors = array();

//u promenljivu $formData stavljate $_GET ili $_POST u zavisnosti od forme
$formData = $_POST; // $_GET ili $_POST

//uvek se prosledjuje jedno polje koje je indikator da su podaci poslati sa forme
//odnosno da je korisnik pokrenuo neku akciju
//kod nas to polje ce biti SUBMIT dugme
if (isset($formData["click"]) && ($formData["click"] == "Delete" || $formData["click"] == "Cancel")) {
	
	/*********** filtriranje i validacija polja ****************/
	if ($formData["click"] == "Cancel") {
        header('Location: /users/list.php');
	}
    
	/*********** filtriranje i validacija polja ****************/
	if ($formData["click"] == "Delete") {
        //Uradi akciju koju je korisnik trazio
        $id = deleteUser($id, $connection);        
        if($id){
            $_SESSION['systemMessage'] = "User: " . $user['name'] . " " . $user['surname'] . " was deleted sucessfully";
            header("Location: /users/list.php");
            die();
        }
	}
}

//spojiti default vrednosti i ono sto je korisnik poslao kroz formu ako je poslao
$formData = array_merge($defaultFormData, $formData);


// html ali include-ovan (require)
require_once '../../view/headerView.php';
require_once '../../view/navigationView.php';
require_once '../../view/users/deleteView.php';
require_once '../../view/footerView.php';
