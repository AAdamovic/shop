<?php


// models
require_once '../../model/connection.php';
require_once '../../model/categoriesModel.php';
require_once '../../model/usersModel.php';
require_once '../../model/pagesModel.php';

$pagesNavigation = getAllPages($connection);

isLoggedIn();

$categories = getAllCategoriesForNavigation($connection);

$id = $_GET['id'];
$id = (int)$id;
$category = getCategory($id, $connection);
if (!$category) {
	$_SESSION['systemMessage'] = "Category doesn't exist!!!";
    header("Location: /message.php");
    die();
}
$pageTitle = "Edit " . $category['name'];
//ovde su default vrednosti za polja u formi
$defaultFormData = array(
    'name' => $category['name'],
    'text' => $category['text'],
    'ban' => $category['ban']
);

$banPossibleValues = array("0" => "Active", "1" => "Not active");


//ovde se smestaju greske koje imaju polja u formi
$formErrors = array();

//u promenljivu $formData stavljate $_GET ili $_POST u zavisnosti od forme
$formData = $_POST; // $_GET ili $_POST

//uvek se prosledjuje jedno polje koje je indikator da su podaci poslati sa forme
//odnosno da je korisnik pokrenuo neku akciju
//kod nas to polje ce biti SUBMIT dugme
if (isset($formData["click"]) && $formData["click"] == "Save") {
	
	/*********** filtriranje i validacija polja ****************/
    // name
	if (isset($formData["name"])) {
		//Filtering 1
		$formData["name"] = trim($formData["name"]);
        $formData["name"] = strip_tags($formData["name"]);

		//Validation - if required
		if ($formData["name"] === "") {
			$formErrors["name"][] = "Field name is required!!!";
		}else{
            if(mb_strlen($formData['name'] > 100)){
                $formErrors["name"][] = "Field name can not have more then 100 characters!!!";
            }
        }
		
	} else {
        //if required
		$formErrors["name"][] = "Field name must be sent!!!";
	}
    
	/*********** filtriranje i validacija polja ****************/
    // text
    if (isset($formData["text"])) {
		//Filtering 1
		$formData["text"] = trim($formData["text"]);
        $formData["text"] = strip_tags($formData["text"], "<br><br/>");
	}
    
    /*********** filtriranje i validacija polja ****************/
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
			$imageFileMaxSize = 1 * 1024 * 1024;// 1 MB
			
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
        
        if (isset($_FILES["image"]) && is_file($_FILES["image"]["tmp_name"])) {
                if (empty($_FILES["image"]["error"])) {
                    $destinationPath = __DIR__ . "/../img/categories/" . $imageFileName;		
                if (!move_uploaded_file($imageFileTmpPath, $destinationPath)) {
                    $formErrors["image"][] = "Something is wrong with image move_uploaded_file";
                }else{
                    $image = "/img/categories/" . $imageFileName;
                }
            }
        }else{
            $image = $category['image'];
        }
        
        if (empty($formErrors)) {
            // save product
            $status = updateCategory($id, $formData, $image, $connection);
            if($status){
                $category = getCategory($id, $connection);
                // if product is edited set sistem message and redirect to list.php (all products)
                $_SESSION['systemMessage'] = "Category: " . $category['name'] . " was edited sucessfully";
                header("Location: /categories/list.php");
                die();
            }
            
        }
        
	}
}

//spojiti default vrednosti i ono sto je korisnik poslao kroz formu ako je poslao
$formData = array_merge($defaultFormData, $formData);


// html ali include-ovan (require)
require_once '../../view/headerView.php';
require_once '../../view/navigationView.php';
require_once '../../view/categories/updateView.php';
require_once '../../view/footerView.php';
