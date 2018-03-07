<?php


// models
require_once '../../model/connection.php';
require_once '../../model/productsModel.php';
require_once '../../model/categoriesModel.php';
require_once '../../model/stickersModel.php';
require_once '../../model/usersModel.php';
require_once '../../model/pagesModel.php';

$pagesNavigation = getAllPages($connection);

isLoggedIn();

$categories = getAllCategoriesForNavigation($connection);

$id = $_GET['id'];
$id = (int)$id;
$product = getProduct($id, $connection);
if (!$product) {
	$_SESSION['systemMessage'] = "Product doesn't exist!!!";
    header("Location: /message.php");
    die();
}
$pageTitle = "Edit " . $product['title'];
//ovde su default vrednosti za polja u formi
$defaultFormData = array(
	'title' => $product['title'],
    'description' => $product['description'],
    'price' => $product['price'],
    'category_id' => $product['category_id'],
    'homepage' => $product['homepage'],
    'quantity' => $product['quantity'],
    'sticker_id' => $product['sticker_id'],
    'discount' => $product['discount']
);

$category_idPossibleValues = getAllCategoriesForSelect($connection);
$sticker_idPossibleValues = getAllStickersForSelect($connection);
$homepagePossibleValues = array("0" => "No", "1" => "Yes");


//ovde se smestaju greske koje imaju polja u formi
$formErrors = array();

//u promenljivu $formData stavljate $_GET ili $_POST u zavisnosti od forme
$formData = $_POST; // $_GET ili $_POST

//uvek se prosledjuje jedno polje koje je indikator da su podaci poslati sa forme
//odnosno da je korisnik pokrenuo neku akciju
//kod nas to polje ce biti SUBMIT dugme
if (isset($formData["click"]) && $formData["click"] == "Save") {
	
	/*********** filtriranje i validacija polja ****************/
    // title
	if (isset($formData["title"])) {
		//Filtering 1
		$formData["title"] = trim($formData["title"]);
        $formData["title"] = strip_tags($formData["title"]);

		//Validation - if required
		if ($formData["title"] === "") {
			$formErrors["title"][] = "Field title is required!!!";
		}else{
            if(mb_strlen($formData['title'] > 100)){
                $formErrors["title"][] = "Field title can not have more then 100 characters!!!";
            }else{
                // check is product title is unique (already exists in database)
                if(!checkProductNameIsUnique($formData['title'], $connection, $id)){
                    $formErrors["title"][] = "Product with this title already exists!!! Choose another title for product!!!";
                }
            }
        }
		
	} else {
        //if required
		$formErrors["title"][] = "Field title must be sent!!!";
	}
    
	/*********** filtriranje i validacija polja ****************/
    // description
    if (isset($formData["description"])) {
		//Filtering 1
		$formData["description"] = trim($formData["description"]);
        $formData["description"] = strip_tags($formData["description"], "<br><br/>");
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
    // price
    if (isset($formData["price"])) {
		//Filtering 1
		$formData["price"] = trim($formData["price"]);
        $formData["price"] = strip_tags($formData["price"]);
		
		//Validation - if required
		if ($formData["price"] === "") {
			$formErrors["price"][] = "Field price is required!!!";
		}else{
            if(!is_numeric($formData["price"])){
                $formErrors["price"][] = "Field price can only be a number!!!";
            }else{
                if($formData["price"] <= 0){
                    $formErrors["price"][] = "Price must be greater then 0!!!";
                }
            }
        }		
	} else {
        //if required
		$formErrors["price"][] = "Field price must be sent!!!";
	}
    
    /*********** filtriranje i validacija polja ****************/
    // category_id
    if (isset($formData["category_id"])) {
        //Filtering 1
		$formData["category_id"] = trim($formData["category_id"]);
        $formData["category_id"] = strip_tags($formData["category_id"]);
	
		
		//Validation - if required
		if ($formData["category_id"] === "") {
			$formErrors["category_id"][] = "Please choose category!!!";
		}
		
		if (!array_key_exists($formData["category_id"], $category_idPossibleValues)) {
			$formErrors["category_id"][] = "Wrong category!!!";
		}
		
	} else {
        //if required
		$formErrors["category_id"][] = "Field category must be sent!!!";
	}
    
    /*********** filtriranje i validacija polja ****************/
    // sticker_id
    if (isset($formData["sticker_id"])) {
        //Filtering 1
		//$formData["sticker_id"] = trim($formData["sticker_id"]);
        //$formData["sticker_id"] = strip_tags($formData["sticker_id"]);
		
		//Validation - if required
		if ($formData["sticker_id"] === "") {
			
		}else{
            if (!array_key_exists($formData["sticker_id"], $sticker_idPossibleValues)) {
                $formErrors["sticker_id"][] = "Please choose sticker!!!";
            }
        }
		
	}
    
    // homepage
    if (isset($formData["homepage"])) {
        //Filtering 1
		$formData["homepage"] = trim($formData["homepage"]);
        $formData["homepage"] = strip_tags($formData["homepage"]);
		
				
		//Validation - if required
		if ($formData["homepage"] === "") {
			$formErrors["homepage"][] = "Choose homepage status";
		}
		
		if (!array_key_exists($formData["homepage"], $homepagePossibleValues)) {
			$formErrors["homepage"][] = "Wrong data for homepage status";
		}
		
	} else {
        //if required
		$formErrors["homepage"][] = "Field homepage must be sent!!!";
	}
    
	/*********** filtriranje i validacija polja ****************/
	// discount
    if (isset($formData["discount"])) {
		//Filtering 1
		$formData["discount"] = trim($formData["discount"]);

		
		//Validation - if required
		if ($formData["discount"] === "") {
			
		}else{
            if(!is_numeric($formData["discount"])){
                $formErrors["discount"][] = "Field discount can only be a number!!!";
            }else{
                if($formData["discount"] <= 0 || $formData["discount"] > 100){
                    $formErrors["discount"][] = "Field discount must be greater then 0 and smaller then 100!!!";
                }
            }
        }		
	}
    
    if (isset($formData["quantity"])) {
		//Filtering 1
		$formData["quantity"] = trim($formData["quantity"]);
		//Filtering 2
		//Filtering 3
		//Filtering 4
		//...
		
		//Validation - if required
		if ($formData["quantity"] === "") {
			$formErrors["quantity"][] = "Field quantity is required!!!";
		}else{
            if(!is_numeric($formData["quantity"])){
                $formErrors["quantity"][] = "Field discount can only be a number!!!";
            }else{
                if($formData["quantity"] < 0){
                    $formErrors["quantity"][] = "Field discount must be greater or equal then 0!!!";
                }
            }
        }
		
	} else {
        //if required
		$formErrors["quantity"][] = "Field quantity must be sent!!!";
	}
    
	//Ukoliko nema gresaka 
	if (empty($formErrors)) {
		//Uradi akciju koju je korisnik trazio
        
        if (isset($_FILES["image"]) && is_file($_FILES["image"]["tmp_name"])) {
                if (empty($_FILES["image"]["error"])) {
                    $destinationPath = __DIR__ . "/../img/products/" . $imageFileName;		
                if (!move_uploaded_file($imageFileTmpPath, $destinationPath)) {
                    $formErrors["image"][] = "Something is wrong with image move_uploaded_file";
                }else{
                    $image = "/img/products/" . $imageFileName;
                }
            }
        }else{
            $image = $product['image'];
        }
        
        if (empty($formErrors)) {
            // save product
            $status = updateProduct($id, $formData, $image, $connection);
            $product = getProduct($id, $connection);
            // if product is edited set sistem message and redirect to list.php (all products)
            $_SESSION['systemMessage'] = "Product: " . $product['title'] . " was edited sucessfully";
            header("Location: /products/list.php");
            die();
        }
        
	}
}

//spojiti default vrednosti i ono sto je korisnik poslao kroz formu ako je poslao
$formData = array_merge($defaultFormData, $formData);


// html ali include-ovan (require)
require_once '../../view/headerView.php';
require_once '../../view/navigationView.php';
require_once '../../view/products/updateView.php';
require_once '../../view/footerView.php';
