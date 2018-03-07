<?php

// ucitavanje svih neophodnih skripti
require_once '../model/connection.php';
require_once '../model/usersModel.php';
require_once '../model/categoriesModel.php';
require_once '../model/pagesModel.php';

$pagesNavigation = getAllPages($connection);
$categories = getAllCategoriesForNavigation($connection);

// ovo je nas controller
$pageTitle = "Login";

// check if is already logged in
if(!isset($_SESSION)){
    session_start();
}

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == TRUE){
    // if is logged in
    $status = TRUE;
    $systemMessage = "Korisnik je vec ulogovan sa username: " . $_SESSION['userName'];
}else{
    // if not logged in
    
    

    // validacija i filtriranje forme
    // tj post zahteva
    // ako je sve sa formom u redu pozovi MODEL i proveri da li korisnik ima
    // privilegije za login

    $status = FALSE;
    $systemMessage = "";

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
    if (isset($formData["click"]) && $formData["click"] == "Login") {

        /*********** filtriranje i validacija polja ****************/
        // username
        if (isset($formData["username"])) {
            //Filtering 1
            $formData["username"] = trim($formData["username"]);
            $formData["username"] = strip_tags($formData["username"]);

            //Filtering 2
            //Filtering 3
            //Filtering 4
            //...


            // Validation -  email

            //Validation - if required
            if ($formData["username"] === "") {
                $formErrors["username"][] = "Polje username ne sme biti prazno";
            } else{
                if (filter_var($formData["username"], FILTER_VALIDATE_EMAIL) === false) {
                    $formErrors["username"][] = "Polje username mora biti email";
                } 
            }


        } else {
            //if required
            $formErrors["username"][] = "Polje username mora biti prosledjeno";
        }


        /*********** filtriranje i validacija polja ****************/
        // password
        if (isset($formData["password"])) {
            //Filtering 1
            $formData["password"] = trim($formData["password"]);
            $formData["password"] = strip_tags($formData["password"]);

            //Validation - if required
            if ($formData["password"] === "") {
                $formErrors["password"][] = "Polje password ne sme biti prazno";
            } else {
                if(mb_strlen($formData["password"]) < 5){
                    $formErrors["password"][] = "Polje password mora imati vise od 4 karaktera";
                }
            }		
        } else {
            //if required
            $formErrors["password"][] = "Polje password mora biti prosledjeno";
        }

        //Ukoliko nema gresaka 
        if (empty($formErrors)) {
            // Uradi akciju koju je korisnik trazio
            // pozovi MODEL
            $status = checkUser($formData["username"], $formData["password"], $connection);

            if($status){
                $systemMessage = "Korisnik je ulogovan uspesno";
            } else{
                $systemMessage = "Username ili sifra su pogresni";
            }
        }
    }

    //spojiti default vrednosti i ono sto je korisnik poslao kroz formu ako je poslao
    $formData = array_merge($defaultFormData, $formData);
}

// html ali include-ovan (require)
require_once '../view/headerView.php';
require_once '../view/navigationView.php';
require_once '../view/loginView.php';
require_once '../view/footerView.php';




