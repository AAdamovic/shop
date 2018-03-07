<?php
session_start();
require_once '../../model/connection.php';
require_once '../../model/usersModel.php';
require_once '../../model/categoriesModel.php';
require_once '../../model/orderModel.php';
require_once '../../model/pagesModel.php';

$categories = getAllCategoriesForNavigation($connection);
$pagesNavigation = getAllPages($connection);
$defaultFormData = array(
);
$pageTitle = "Checkout";


//ovde se smestaju greske koje imaju polja u formi
$formErrors = array();

//u promenljivu $formData stavljate $_GET ili $_POST u zavisnosti od forme
$formData = $_POST; // $_GET ili $_POST
//uvek se prosledjuje jedno polje koje je indikator da su podaci poslati sa forme
//odnosno da je korisnik pokrenuo neku akciju
//kod nas to polje ce biti SUBMIT dugme
if (isset($formData["click"]) && $formData["click"] == "Finish Order") {

    /*     * ********* filtriranje i validacija polja *************** */
    if (isset($formData["name"])) {
        //Filtering 1
        $formData["name"] = trim($formData["name"]);
        $formData["name"] = strip_tags($formData["name"]);

        //Validation - if required
        if ($formData["name"] === "") {
            $formErrors["name"][] = "Polje name ne sme biti prazno";
        } else {
            if (mb_strlen($formData["name"]) <= 3 || mb_strlen($formData["name"]) > 50) {
                $formErrors["name"][] = "Polje name mora imati vise od 3 a manje od 50 karaktera";
            }
        }
    } else {
        //if required
        $formErrors["name"][] = "Polje name mora biti prosledjeno";
    }

    /*     * ********* filtriranje i validacija polja *************** */
    if (isset($formData["surname"])) {
        //Filtering 1
        $formData["surname"] = trim($formData["surname"]);
        $formData["surname"] = strip_tags($formData["surname"]);

        //Validation - if required
        if ($formData["surname"] === "") {
            $formErrors["surname"][] = "Polje surname ne sme biti prazno";
        } else {
            if (mb_strlen($formData["surname"]) <= 3 || mb_strlen($formData["name"]) > 50) {
                $formErrors["surname"][] = "Polje surname mora imati vise od 3 a manje od 50 karaktera";
            }
        }
    } else {
        //if required
        $formErrors["name"][] = "Polje name mora biti prosledjeno";
    }

    /*     * ********* filtriranje i validacija polja *************** */
    if (isset($formData["email"])) {
        //Filtering 1
        $formData["email"] = trim($formData["email"]);
        $formData["email"] = strip_tags($formData["email"]);

        //Validation - if required
        if ($formData["email"] === "") {
            $formErrors["email"][] = "Polje email ne sme biti prazno";
        } else {
            if (filter_var($formData["email"], FILTER_VALIDATE_EMAIL) === false) {
                $formErrors["email"][] = "Email nije u validnom formatu";
            } else {
                // check is product title is unique (already exists in database)
                if (!checkEmailIsUnique($formData['email'], $connection)) {
                    $formErrors["email"][] = "User with this email already exists!!! Choose another email for user!!!";
                }
            }
        }
    } else {
        //if required
        $formErrors["email"][] = "Polje email mora biti prosledjeno";
    }

    /*     * ********* filtriranje i validacija polja *************** */
    if (isset($formData["phone"])) {
        //Filtering 1
        $formData["phone"] = trim($formData["phone"]);
        $formData["phone"] = strip_tags($formData["phone"]);

        //Validation - if required
        if ($formData["phone"] === "") {
            $formErrors["phone"][] = "Polje password ne sme biti prazno";
        } else {
            if (mb_strlen($formData["phone"]) <= 4 || mb_strlen($formData["phone"]) > 50) {
                $formErrors["phone"][] = "Polje password mora imati vise od 4 a manje od 50 karaktera";
            }
        }
    } else {
        //if required
        $formErrors["phone"][] = "Polje password mora biti prosledjeno";
    }

    /*     * ********* filtriranje i validacija polja *************** */
    if (isset($formData["address"])) {
        //Filtering 1
        $formData["address"] = trim($formData["address"]);
        $formData["address"] = strip_tags($formData["address"]);

        //Validation - if required
        if ($formData["address"] === "") {
            $formErrors["address"][] = "Polje address ne sme biti prazno";
        } else {
            if (mb_strlen($formData["address"]) <= 10 || mb_strlen($formData["address"]) > 200) {
                $formErrors["address"][] = "Polje address mora imati vise od 10 a manje od 200 karaktera";
            }
        }
    } else {
        //if required
        $formErrors["address"][] = "Polje address mora biti prosledjeno";
    }

    //Ukoliko nema gresaka 
    if (empty($formErrors)) {
    $lastID = insertOrder($connection, $formData);
   
        if (isset($_SESSION['cart'])) {
            
            $cart = $_SESSION['cart'];
           
            foreach ($cart as $product) {
            insertOrderProduct($connection, $lastID, $product);
            
             $_SESSION[systemMessage] = "Order was successful";
             header('Location:/shopping-cart/success-order.php');
            }
        }
    }
}

require_once '../../view/headerView.php';
require_once '../../view/navigationView.php';
require_once '../../view/shopping-cart/checkoutView.php';
require_once '../../view/footerView.php';
 