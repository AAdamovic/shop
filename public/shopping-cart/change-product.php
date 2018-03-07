<?php
if(!isset($_SESSION)){
    session_start();
}
$pageTitle = 'Cart';
// models
require_once '../../model/connection.php';
require_once '../../model/productsModel.php';
require_once '../../model/categoriesModel.php';
require_once '../../model/pagesModel.php';

$pagesNavigation = getAllPages($connection);
$categories = getAllCategoriesForNavigation($connection);

// validate product id param
if(isset($_GET['id'])){
    $id = $_GET['id'];
    //$id = (int)$id;
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    
    $product = getProduct($id, $connection);
    if (!$product) {
        $_SESSION['systemMessage'] = "Product doesn't exist!!!";
        header("Location: /message.php");
        die();
    }
}


// validate type param
$typesPossibleValues = array('increment', 'decrement', 'remove');
if(isset($_GET['type'])){
    $type = $_GET['type'];
    $type = trim($type);
    $type = strip_tags($type);
    $type = filter_var($type, FILTER_SANITIZE_STRING);
    
    if(!in_array($type, $typesPossibleValues)){
        $_SESSION['systemMessage'] = "Please send VALID type param through url!!!";
        header("Location: /message.php");
        die();
    }
}

// if cart is empty initialize it as SESSION['cart]
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}

// put SESSION in to variable for easy use 
$cart = $_SESSION['cart'];

if(isset($_GET['id']) && isset($_GET['type'])){
    if(count($cart) > 0){
        $foundStatus = FALSE;

        foreach ($cart as $key => $value) {
            if($id == $value['product_id']){
                // product is already in cart
                // change quantity
                $product = array(
                    'product_id' => $id,
                    'title' => $product['title'],
                    'price' => $product['price'],
                    'discount' => $product['discount'],
                    'image' => $product['image']
                );

                switch ($type) {
                    case "increment":
                        $product['quantity'] = $value['quantity'] + 1;
                        // change products values in cart 
                        $cart[$key] = $product;
                        break;

                    case "decrement":
                        if($value['quantity'] <= 1){
                            // if current state for quantity is 1
                            // after remove qauntuty is 0 and we need 
                            // to remove product from cart
                            unset($cart[$key]);
                        }else{
                            // if quantity is > 1
                            $product['quantity'] = $value['quantity'] - 1;
                            // change products values in cart 
                            $cart[$key] = $product;
                        }
                        break;

                    case "remove":
                        unset($cart[$key]);
                        break;
                }

                $foundStatus = TRUE;
                break;
            }
        }

        // product was not found in cart
        // add product to cart

        if(!$foundStatus){
            // put product to cart
            $product = array(
                'product_id' => $id,
                'title' => $product['title'],
                'price' => $product['price'],
                'quantity' => 1,
                'discount' => $product['discount'],
                'image' => $product['image']
            );
            array_push($cart, $product);
        }

    }else{
        // cart is empty
        // put product to cart
        $product = array(
            'product_id' => $id,
            'title' => $product['title'],
            'price' => $product['price'],
            'quantity' => 1,
            'discount' => $product['discount'],
            'image' => $product['image']
        );
        array_push($cart, $product);
    }
    
    $_SESSION['cart'] = $cart;
    
    // if page is redirected
    header('Location: /shopping-cart/change-product.php');
    die();
}

// html ali include-ovan (require)
require_once '../../view/headerView.php';
require_once '../../view/navigationView.php';
require_once '../../view/shopping-cart/cartView.php';
require_once '../../view/footerView.php';
