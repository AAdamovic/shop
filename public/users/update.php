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
$pageTitle = "Edit user " . $user['name'] . " " . $user['surname'];
$banPossibleValues = array("0" => "Active", "1" => "Not active");

//ovde su default vrednosti za polja u formi
$defaultFormData = array(
	'name' => $user['name'],
    'surname' => $user['surname'],
    'email' => $user['email'],
    'ban' => $user['ban']
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
    if (isset($formData["password"])) {
		//Filtering 1
		$formData["password"] = trim($formData["password"]);
        $formData["password"] = strip_tags($formData["password"]);

		//Validation - if required
		if ($formData["password"] !== "") {
			if(mb_strlen($formData["password"]) > 50){
                $formErrors["password"][] = "Polje password mora imati manje od 50 karaktera";
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
		if ($formData["repeat-password"] !== "") {
			if(mb_strlen($formData["repeat-password"]) > 50){
                $formErrors["repeat-password"][] = "Polje repeat-password mora imati manje od 50 karaktera";
            }else{
                if(mb_strlen($formData["password"]) > 0){
                    if($formData["password"]  !==  $formData["repeat-password"]){
                        $formErrors["repeat-password"][] = "Sifre se ne podudaraju";
                    }
                }
            }
		}
		
	} else {
        //if required
		$formErrors["repeat-password"][] = "Polje repeat-password mora biti prosledjeno";
	}
    
    /*********** filtriranje i validacija polja ****************/
    if (isset($formData["ban"])) {
        //Filtering 1
		$formData["ban"] = trim($formData["ban"]);
        $formData["ban"] = strip_tags($formData["ban"]);
		
		
		//Validation - if required
		if ($formData["ban"] === "") {
			$formErrors["ban"][] = "Please senf field status";
		}
		
		if (!array_key_exists($formData["ban"], $banPossibleValues)) {
			$formErrors["ban"][] = "Wrong data for field status";
		}
	} else {
        //if required
		$formErrors["ban"][] = "Please senf field status";
	}
	
	//Ukoliko nema gresaka 
	if (empty($formErrors)) {
		//Uradi akciju koju je korisnik trazio
        $status = updateUser($id, $formData, $connection);        
        if($status){
            $user = getUser($id, $connection);
            $_SESSION['systemMessage'] = "User: " . $user['name'] . " " . $user['surname'] . " was edited sucessfully";
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
require_once '../../view/users/updateView.php';
require_once '../../view/footerView.php';
