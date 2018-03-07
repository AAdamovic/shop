<?php

$pageTitle = "New user";

// models
require_once '../../model/connection.php';
require_once '../../model/usersModel.php';
require_once '../../model/categoriesModel.php';
require_once '../../model/pagesModel.php';

isLoggedIn();

$pagesNavigation = getAllPages($connection);
$categories = getAllCategoriesForNavigation($connection);

//ovde su default vrednosti za polja u formi
$defaultFormData = array(
	
);

//ovde se smestaju greske koje imaju polja u formi
$formErrors = array();

//u promenljivu $formData stavljate $_GET ili $_POST u zavisnosti od forme
$formData = $_POST; // $_GET ili $_POST

//uvek se prosledjuje jedno polje koje je indikator da su podaci poslati sa forme
//odnosno da je korisnik pokrenuo neku akciju
//kod nas to polje ce biti SUBMIT dugme
if (isset($formData["click"]) && $formData["click"] == "Save") {
	
	/*********** filtriranje i validacija polja ****************/
	if (isset($formData["name"])) {
		//Filtering 1
		$formData["name"] = trim($formData["name"]);
        $formData["name"] = strip_tags($formData["name"]);
		
		//Validation - if required
		if ($formData["name"] === "") {
			$formErrors["name"][] = "Polje name ne sme biti prazno";
		}else{
            if(mb_strlen($formData["name"]) <= 3 || mb_strlen($formData["name"]) > 50){
                $formErrors["name"][] = "Polje name mora imati vise od 3 a manje od 50 karaktera";
            }
        }
		
	} else {
        //if required
		$formErrors["name"][] = "Polje name mora biti prosledjeno";
	}
    
	/*********** filtriranje i validacija polja ****************/
    if (isset($formData["surname"])) {
		//Filtering 1
		$formData["surname"] = trim($formData["surname"]);
        $formData["surname"] = strip_tags($formData["surname"]);
		
		//Validation - if required
		if ($formData["surname"] === "") {
			$formErrors["surname"][] = "Polje surname ne sme biti prazno";
		}else{
            if(mb_strlen($formData["surname"]) <= 3 || mb_strlen($formData["name"]) > 50){
                $formErrors["surname"][] = "Polje surname mora imati vise od 3 a manje od 50 karaktera";
            }
        }
		
	} else {
        //if required
		$formErrors["name"][] = "Polje name mora biti prosledjeno";
	}
    
    /*********** filtriranje i validacija polja ****************/
    if (isset($formData["email"])) {
		//Filtering 1
		$formData["email"] = trim($formData["email"]);
        $formData["email"] = strip_tags($formData["email"]);
		
		//Validation - if required
		if ($formData["email"] === "") {
			$formErrors["email"][] = "Polje email ne sme biti prazno";
		} else{
            if (filter_var($formData["email"], FILTER_VALIDATE_EMAIL) === false){
                $formErrors["email"][] = "Email nije u validnom formatu";
            } else{
                // check is product title is unique (already exists in database)
                if(!checkEmailIsUnique($formData['email'], $connection)){
                    $formErrors["email"][] = "User with this email already exists!!! Choose another email for user!!!";
                }
            }
        }
		
	} else {
        //if required
		$formErrors["email"][] = "Polje email mora biti prosledjeno";
	}
    
    /*********** filtriranje i validacija polja ****************/
    if (isset($formData["password"])) {
		//Filtering 1
		$formData["password"] = trim($formData["password"]);
        $formData["password"] = strip_tags($formData["password"]);

		//Validation - if required
		if ($formData["password"] === "") {
			$formErrors["password"][] = "Polje password ne sme biti prazno";
		}else{
            if(mb_strlen($formData["password"]) <= 4 || mb_strlen($formData["password"]) > 50){
                $formErrors["password"][] = "Polje password mora imati vise od 4 a manje od 50 karaktera";
            }
        }
		
	} else {
        //if required
		$formErrors["password"][] = "Polje password mora biti prosledjeno";
	}
    
    /*********** filtriranje i validacija polja ****************/
    if (isset($formData["repeat-password"])) {
		//Filtering 1
		$formData["repeat-password"] = trim($formData["repeat-password"]);
        $formData["repeat-password"] = strip_tags($formData["repeat-password"]);

		//Validation - if required
		if ($formData["repeat-password"] === "") {
			$formErrors["repeat-password"][] = "Polje password ne sme biti prazno";
		}else{
            if(mb_strlen($formData["repeat-password"]) <= 4 || mb_strlen($formData["repeat-password"]) > 50){
                $formErrors["repeat-password"][] = "Polje repeat-password mora imati vise od 4 a manje od 50 karaktera";
            }else{
                if($formData["password"]  !==  $formData["repeat-password"]){
                    $formErrors["repeat-password"][] = "Sifre se ne podudaraju";
                }
            }
        }
		
	} else {
        //if required
		$formErrors["repeat-password"][] = "Polje repeat-password mora biti prosledjeno";
	}
	
	//Ukoliko nema gresaka 
	if (empty($formErrors)) {
		//Uradi akciju koju je korisnik trazio
        $id = createUser($formData, $connection);        
        if($id){
            $user = getUser($id, $connection);
            $_SESSION['systemMessage'] = "User: " . $user['name'] . " " . $user['surname'] . " was created sucessfully";
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
require_once '../../view/users/createView.php';
require_once '../../view/footerView.php';
