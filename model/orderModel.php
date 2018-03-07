<?php

function insertOrder($connection, $formData) {
    try {
        // Make query string
        $sqlQueryString = "INSERT INTO `order`(name, surname, email, phone, address,first_price, last_price)
            VALUES(:name, :surname, :email, :phone, :address, :first_price, :last_price);";

        // Execute query (with params or without)
        $statement = $connection->prepare($sqlQueryString);

        
        $first_price = 0;
        $last_price = 0;
        $cart = $_SESSION['cart'];
        foreach ($cart as $value) {
            $first_price += $value['price'];
            $last_price += $value['price'] - $value['price'] * $value['discount'] / 100;
        }
        
        // Execute return TRUE or FALSE
        $params = array(
            'name' => $formData['name'],
            'surname' => $formData['surname'],
            'email' => $formData['email'],
            'phone' => $formData['phone'],
            'address' => $formData['address'],
            'first_price' => $first_price,
            'last_price' => $last_price
        );

        
        
        $status = $statement->execute($params);

        if ($status) {
            return $connection->lastInsertId();
        }
    } catch (PDOException $exc) {
        return FALSE;
    }
}

function insertOrderProduct($connection, $lastId, $product) {
    try {
        // Make query string
        $sqlQueryString = "INSERT INTO `order_products`(product_id, order_id, title, price, discount, image, quantity)
            VALUES(:product_id, :order_id, :title, :price, :discount, :image, :quantity);";

        // Execute query (with params or without)
        $statement = $connection->prepare($sqlQueryString);

        // Execute return TRUE or FALSE
        $params = array(
            'product_id' => $product['product_id'],
            'order_id' => $lastId,
            'title' => $product['title'],
            'price' => $product['price'],
            'discount' => $product['discount'],
            'image' => $product['image'],
            'quantity' => $product['quantity']
        );

        $status = $statement->execute($params);

        if ($status) {
            return $connection->lastInsertId();
        }
    } catch (PDOException $exc) {
        return FALSE;
    }
}

///popravi
function countOrders($connection, $search) {

    try {
        // Make query string
        $sqlQueryString = "
            SELECT `order`.`id`
            FROM `order`
            
         ";
        if ($search != NULL) {

            $sqlQueryString .= " 
              WHERE  `order`.`name` LIKE CONCAT ('%',:search,'%') OR `order`.`surname` LIKE CONCAT ('%',:search2,'%')
              OR `order`.`id` IN (SELECT `order_products`.`order_id` FROM `order_products` WHERE `order_products`.`title` LIKE CONCAT ('%',:search3,'%'))
        ;";

            $statement = $connection->prepare($sqlQueryString);
            // Execute query (with params or without)



            $params = array(
                'search' => $search,
                'search2' => $search,
                'search3' => $search
            );

            $status = $statement->execute($params);
        } else {
            $statement = $connection->prepare($sqlQueryString);
            // Execute query (with params or without)

            $params = array(
            );

            $status = $statement->execute();
        }

        if ($status) {
            // get ROWS (ROW SET) (fetchAll() - for row set or fetch() - for one row)
            $rows = $statement->fetchAll();
            $total = count($rows);
            return $total;
        } else {

            return array();
        }




        // close connection with NULL
    } catch (PDOException $e) {
        $_SESSION['systemMessage'] = "Something was wrong. 2 Error: " . $e->getMessage();
        header("Location: /message.php");
        die();
    }
}

function getAllOrdersForPagination($page, $numberOfRowsPerPage, $connection, $search) {
    try {
        // Make query string
        $sqlQueryString = "
            SELECT `order`.`id`,`order`.`date_created`,`order`.`name`,`order`.`surname`,`order`.`phone`, `order`.`address`
            FROM `order`
           ";
        if (!empty($search)) {

            $sqlQueryString .= "
             WHERE  `order`.`name` LIKE CONCAT ('%',:search,'%') OR `order`.`surname` LIKE CONCAT ('%',:search2,'%')
            OR `order`.`id` IN (SELECT `order_products`.`order_id` FROM `order_products` WHERE `order_products`.`title` LIKE CONCAT ('%',:search3,'%'))
            ORDER BY `order`.`date_created` DESC
            LIMIT :numberOfRowsPerPage
            OFFSET :offset
         ;";
            // Execute query (with params or without)

            $statement = $connection->prepare($sqlQueryString);



            $offset = ($page - 1) * $numberOfRowsPerPage;



            $params = array(
                'numberOfRowsPerPage' => $numberOfRowsPerPage,
                'offset' => $offset,
                'search' => $search,
                'search2' => $search,
                'search3' => $search
            );

            $status = $statement->execute($params);


            if ($status) {
                // get ROWS (ROW SET) (fetchAll() - for row set or fetch() - for one row)
                $rows = $statement->fetchAll();

                return $rows;
            } else {

                return array();
            }
        } else {


            $sqlQueryString .= "
            ORDER BY `order`.`date_created` DESC
            LIMIT :numberOfRowsPerPage
            OFFSET :offset
         ;";


            // Execute query (with params or without)
            $statement = $connection->prepare($sqlQueryString);

            $offset = ($page - 1) * $numberOfRowsPerPage;

            // Execute return TRUE or FALSE
            $params = array(
                'numberOfRowsPerPage' => $numberOfRowsPerPage,
                'offset' => $offset,
            );

            $status = $statement->execute($params);


            if ($status) {
                // get ROWS (ROW SET) (fetchAll() - for row set or fetch() - for one row)
                $rows = $statement->fetchAll();

                return $rows;
            } else {

                return array();
            }
        }
    } catch (PDOException $e) {
        $_SESSION['systemMessage'] = "Something was wrong. 1s Error: " . $e->getMessage();
        header("Location: /message.php");
        die();
    }
}

function getAllOrderProducts($connection, $id) {
    try {
        // Make query string
        $sqlQueryString = "
            SELECT   order_products.title, order_products.price, order_products.discount, order_products.quantity, order_products.order_id
            FROM order_products
            WHERE order_products.order_id = :id;
            
         ";

        // Execute query (with params or without)
        $statement = $connection->prepare($sqlQueryString);

        // Execute return TRUE or FALSE
        $params = array(
            'id' => $id
        );

        $status = $statement->execute($params);


        if ($status) {
            // get ROWS (ROW SET) (fetchAll() - for row set or fetch() - for one row)
            $rows = $statement->fetchAll();

            return $rows;
        } else {

            return array();
        }




        // close connection with NULL
    } catch (PDOException $e) {
        $_SESSION['systemMessage'] = "Something was wrong. Error: " . $e->getMessage();
        header("Location: /message.php");
        die();
    }
}
function getOrderProductsForAnalyze($connection, $page, $search, $numberOfRowsPerPage) {
    try {
        // Make query string
        $sqlQueryString = "
            SELECT product_id, title, SUM(price) AS zarada, SUM(price)*discount/100 AS popust, SUM(quantity) AS kolicina
            FROM `order_products`
            ";
            if (!empty($search)) {

            $sqlQueryString .= "
            WHERE title LIKE CONCAT ('%',:search,'%')
            GROUP BY product_id
            ORDER BY `order_products`.`product_id` ASC
            LIMIT :numberOfRowsPerPage
            OFFSET :offset
         ";
            
            $statement = $connection->prepare($sqlQueryString);



            $offset = ($page - 1) * $numberOfRowsPerPage;



            $params = array(
                'numberOfRowsPerPage' => $numberOfRowsPerPage,
                'offset' => $offset,
                'search' => $search
            );

            $status = $statement->execute($params);


            if ($status) {
                // get ROWS (ROW SET) (fetchAll() - for row set or fetch() - for one row)
                $rows = $statement->fetchAll();

                return $rows;
            
            }
             }else{
                $sqlQueryString .= "
            GROUP BY product_id
            ORDER BY `order_products`.`product_id` ASC
            LIMIT :numberOfRowsPerPage
            OFFSET :offset
         ";
         
         
        // Execute query (with params or without)
        $statement = $connection->prepare($sqlQueryString);
        
        $offset = ($page - 1) * $numberOfRowsPerPage;
        // Execute return TRUE or FALSE
        $params = array(
            'numberOfRowsPerPage' => $numberOfRowsPerPage,
            'offset' => $offset,
        );

        $status = $statement->execute($params);


        if ($status) {
            // get ROWS (ROW SET) (fetchAll() - for row set or fetch() - for one row)
            $rows = $statement->fetchAll();

            return $rows;
        } else {

            return array();
        }


             }

        // close connection with NULL
    } catch (PDOException $e) {
        $_SESSION['systemMessage'] = "Something was wrong. Error: " . $e->getMessage();
        header("Location: /message.php");
        die();
    }
}
function countOrderProducts($connection, $search){
    try {
        // Make query string
        $sqlQueryString = "
            SELECT product_id
            FROM `order_products`
           ";
        if ($search != NULL) {

            $sqlQueryString .= " 
            WHERE title LIKE CONCAT ('%',:search,'%')
            GROUP BY product_id
            ORDER BY `order_products`.`product_id` ASC
            ;";

            $statement = $connection->prepare($sqlQueryString);
            // Execute query (with params or without)



            $params = array(
                'search' => $search
            );

            $status = $statement->execute($params);
        } else {
            $sqlQueryString .= " 
            
            GROUP BY product_id
            ORDER BY `order_products`.`product_id` ASC
            ;";
            $statement = $connection->prepare($sqlQueryString);
            // Execute query (with params or without)

            $params = array(
            );

            $status = $statement->execute();
        }

        if ($status) {
            // get ROWS (ROW SET) (fetchAll() - for row set or fetch() - for one row)
            $rows = $statement->fetchAll();
            $total = count($rows);
            return $total;
        } else {

            return array();
        }
      
        // close connection with NULL
    } catch (PDOException $e) {
        $_SESSION['systemMessage'] = "Something was wrong. Error: " . $e->getMessage();
        header("Location: /message.php");
        die();
    }
}