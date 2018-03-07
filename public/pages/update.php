<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once '../../model/connection.php';
require_once '../../model/usersModel.php';
require_once '../../model/categoriesModel.php';
require_once '../../model/pagesModel.php';

isLoggedIn();


$categories = getAllCategoriesForNavigation($connection);
$pagesNavigation = getAllPages($connection);
$id = $_GET['id'];
$id = (int) $id;
$page = getPage($id, $connection);
if (!$page) {
    $_SESSION['systemMessage'] = "Page doesn't exist!!!";
    header("Location: /message.php");
    die();
}
$pageTitle = 'Update ' . $page['title'];
$defaultFormData = array(
    'title' => $page['title'],
    'text' => $page['text'],
);

$formErrors = array();

//u promenljivu $formData stavljate $_GET ili $_POST u zavisnosti od forme
$formData = $_POST; // $_GET ili $_POST
//uvek se prosledjuje jedno polje koje je indikator da su podaci poslati sa forme
//odnosno da je korisnik pokrenuo neku akciju
//kod nas to polje ce biti SUBMIT dugme
if (isset($formData["click"]) && $formData["click"] == "Save") {

    /*     * ********* filtriranje i validacija polja *************** */
    // name
    if (isset($formData["title"])) {
        //Filtering 1
        $formData["title"] = trim($formData["title"]);
        $formData["title"] = strip_tags($formData["title"]);

        //Validation - if required
        if ($formData["title"] === "") {
            $formErrors["title"][] = "Field title is required!!!";
        } else {
            if (mb_strlen($formData["title"]) <= 3 || mb_strlen($formData["title"]) >= 50) {
                $formErrors["title"][] = "Polje title ne moze imati manje od 3 i  vise od 50 karaktera.";
            }
        }
    } else {
        //if required
        $formErrors["title"][] = "Field title must be sent!!!";
    }

    /*     * ********* filtriranje i validacija polja *************** */
    // text
    if (isset($formData["text"])) {
        //Filtering 1
        $formData["text"] = trim($formData["text"]);
        $formData["text"] = strip_tags($formData["text"], "<br><br/>");
    }

    /*     * ********* filtriranje i validacija polja *************** */
    // image
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
    if (empty($formErrors)) {
        //Uradi akciju koju je korisnik trazio

        if (isset($_FILES["image"]) && is_file($_FILES["image"]["tmp_name"])) {
            if (empty($_FILES["image"]["error"])) {
                $destinationPath = __DIR__ . "/../img/pages/" . $imageFileName;
                if (!move_uploaded_file($imageFileTmpPath, $destinationPath)) {
                    $formErrors["image"][] = "Something is wrong with image move_uploaded_file";
                } else {
                    $image = "/img/pages/" . $imageFileName;
                }
            }
        } else {
            $image = $category['image'];
        }

        if (empty($formErrors)) {
            // save product
            $status = updatePage($id, $formData, $image, $connection);
            if ($status) {
                $page = getPage($id, $connection);
                // if product is edited set sistem message and redirect to list.php (all products)
                $_SESSION['systemMessage'] = "Page: " . $page['title'] . " was edited sucessfully";
                header("Location: /pages/list.php");
                die();
            }
        }
    }
}    
require_once '../../view/headerView.php';
require_once '../../view/navigationView.php';
require_once '../../view/pages/update.php';
require_once '../../view/footerView.php';