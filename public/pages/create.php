<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once '../../model/connection.php';
require_once '../../model/usersModel.php';
require_once '../../model/categoriesModel.php';
require_once '../../model/pagesModel.php';

isLoggedIn();
$pageTitle = 'Create Page';
$categories = getAllCategoriesForNavigation($connection);
$pagesNavigation = getAllPages($connection);
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

//title
    if (isset($formData["title"])) {
        //Filtering 1
        $formData["title"] = trim($formData["title"]);
        //Filtering 2
        $formData["title"] = strip_tags($formData["title"]);
        //Filtering 3
        //Filtering 4
        //...
        //Validation - if required
        if ($formData["title"] === "") {
            $formErrors["title"][] = "Polje title ne sme biti prazno";
        }
        if (mb_strlen($formData["title"]) <= 3 || mb_strlen($formData["title"]) >= 50) {
            $formErrors["title"][] = "Polje title ne moze imati manje od 3 i  vise od 50 karaktera.";
        }
    } else {
        //if required
        $formErrors["title"][] = "Polje title mora biti prosledjeno";
    }



    //pageText
    if (isset($formData["pageText"])) {
        //Filtering 1
        $formData["pageText"] = trim($formData["pageText"]);
        //Filtering 2
        $formData["pageText"] = strip_tags($formData["pageText"]);


        //Validation - if required
        if ($formData["pageText"] === "") {
            $formErrors["pageText"][] = "Polje Page Text ne sme biti prazno";
        }
        if (mb_strlen($formData["pageText"]) <= 20 || mb_strlen($formData["pageText"]) >= 2500) {
            $formErrors["pageText"][] = "Polje Page Text ne moze imati manje od 20 i  vise od 2500 karaktera.";
        }
    } else {
        //if required
        $formErrors["pageText"][] = "Polje Page Text mora biti prosledjeno";
    }



    //image
    if (isset($_FILES["image"]) && is_file($_FILES["image"]["tmp_name"])) {
        if (empty($_FILES["image"]["error"])) {
            //filtering
            $imageFileTmpPath = $_FILES["image"]["tmp_name"];
            $imageFileName = basename($_FILES["image"]["name"]);
            $imageFileMime = mime_content_type($_FILES["image"]["tmp_name"]);
            $imageFileSize = $_FILES["image"]["size"];

            //validation
            $imageFileAllowedMime = array("image/jpeg", "image/png", "image/gif");
            $imageFileMaxSize = 1 * 1024 * 1024; // 1 MB

            if (!in_array($imageFileMime, $imageFileAllowedMime)) {
                $formErrors["image"][] = "Image can only have .png, .gif or .jpeg extension!!!";
            }

            if ($imageFileSize > $imageFileMaxSize) {
                $formErrors["image"][] = "Image max size can me 1MB. Please browse smaller image!!!";
            }
        } else {
            $formErrors["image"][] = "Sometning is wrong with file upload: " . $_FILES["image"]["error"] . "!!!";
        }
    }



    //Ukoliko nema gresaka 
    if (empty($formErrors)) {
        //Uradi akciju koju je korisnik trazio
        $image = NULL;
        if (isset($_FILES["image"]) && is_file($_FILES["image"]["tmp_name"])) {
            if (empty($_FILES["image"]["error"])) {
                $destinationPath = __DIR__ . "/../img/pages/" . $imageFileName;
                if (!move_uploaded_file($imageFileTmpPath, $destinationPath)) {
                    $formErrors["image"][] = "Something is wrong with image move_uploaded_file";
                } else {
                    $image = "/img/pages/" . $imageFileName;
                }
            }
        }

        if (empty($formErrors)) {
            // save product
            $id = createPage($connection, $formData, $image);
            if ($id) {
                $page = getPage($id, $connection);
                $_SESSION['systemMessage'] = "Page: " . $page['title'] . " was created sucessfully";
                header("Location: /pages/list.php");
                die();
            }
        }
    }
}
//spojiti default vrednosti i ono sto je korisnik poslao kroz formu ako je poslao
$formData = array_merge($defaultFormData, $formData);

require_once '../../view/headerView.php';
require_once '../../view/navigationView.php';
require_once '../../view/pages/create.php';
require_once '../../view/footerView.php';
