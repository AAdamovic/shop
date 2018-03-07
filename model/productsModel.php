<?php

/**
 * Get all products
 * @param int $page current page
 * @param int $numberOfRowsPerPage number of rows per page
 * @param PDO $connection
 * @return array
 */
function getAllProductsForPagination($page, $numberOfRowsPerPage, $connection, $categoryId = NULL, $order = NULL) {
	try {
		// Make query string
		$sqlQueryString = "
            SELECT p.*, s.title as sticker_title, c.name as category_name
            FROM products AS p
            LEFT JOIN stickers as s ON s.id = p.sticker_id
            LEFT JOIN categories as c ON c.id = p.category_id ";
        
        if(!is_null($categoryId)){
            $sqlQueryString .= " WHERE p.category_id LIKE :category_id ";
        }
        
        if(!is_null($order)){
            switch ($order) {
                case "title_asc":
                    $sqlQueryString .= " ORDER BY p.title ASC ";

                    break;
                case "title_desc":
                    $sqlQueryString .= " ORDER BY p.title DESC ";

                    break;
                case "category_asc":
                    $sqlQueryString .= " ORDER BY category_name ASC ";

                    break;
                case "category_desc":
                    $sqlQueryString .= " ORDER BY category_name DESC ";

                    break;
                case "sticker_asc":
                    $sqlQueryString .= " ORDER BY sticker_title ASC ";

                    break;
                case "sticker_desc":
                    $sqlQueryString .= " ORDER BY sticker_title DESC ";

                    break;
                case "price_asc":
                    $sqlQueryString .= " ORDER BY p.price ASC";

                    break;
                case "price_desc":
                    $sqlQueryString .= " ORDER BY p.price DESC ";

                    break;
                case "discount_asc":
                    $sqlQueryString .= " ORDER BY p.discount ASC ";

                    break;
                case "discount_desc":
                    $sqlQueryString .= " ORDER BY p.discount DESC ";

                    break;
            }
        }
        
        $sqlQueryString .= "
            LIMIT :number_of_rows_per_page
            OFFSET :offset;
         ";

		// Execute query (with params or without)
		$statement = $connection->prepare($sqlQueryString);

		// Execute return TRUE or FALSE
		$params = array(
			'number_of_rows_per_page' => $numberOfRowsPerPage,
                        'offset' => ($page - 1) * $numberOfRowsPerPage
		);

        
        
        if(!is_null($categoryId)){
            $params['category_id'] = $categoryId;
        }
        
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

/**
 * Get all products
 * @param PDO $connection
 * @return array
 */
function getAllProducts($connection) {
	try {
		// Make query string
		$sqlQueryString = "
            SELECT p.*, s.title as sticker_title, c.name as category_name
            FROM products AS p
            LEFT JOIN stickers as s ON s.id = p.sticker_id
            LEFT JOIN categories as c ON c.id = p.category_id
         ";

		// Execute query (with params or without)
		$statement = $connection->prepare($sqlQueryString);

		// Execute return TRUE or FALSE
		$params = array(
			
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

/**
 * Count all products
 * @param PDO $connection
 * @param int $categoryId Filter for category
 * @return array
 */
function countProducts($connection, $categoryId = NULL) {
	try {
		// Make query string
		$sqlQueryString = "
            SELECT COUNT(*) as total
            FROM products
         ";
        
        if(!is_null($categoryId)){
            $sqlQueryString .= " WHERE products.category_id=:category_id;";
        }

		// Execute query (with params or without)
		$statement = $connection->prepare($sqlQueryString);

		// Execute return TRUE or FALSE
		$params = array(
			
		);
        if(!is_null($categoryId)){
            $params['category_id'] = $categoryId;
        }

		$status = $statement->execute($params);


		if ($status) {
			// get ROWS (ROW SET) (fetchAll() - for row set or fetch() - for one row)
			$row = $statement->fetch();
			return $row['total'];
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


/**
 * 
 * @param int $id
 * @param PDO $connection
 * @return array Returns false if no product is found for given id
 */
function getProduct($id, $connection) {
	try {
		// Make query string
		$sqlQueryString = "
            SELECT p.*, s.title as sticker_title
            FROM products AS p
			LEFT JOIN stickers as s ON s.id = p.sticker_id
			WHERE p.id=:id
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
			$row = $statement->fetch();
			
			return $row;
			
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

/**
 * 
 * @param Array $formData
 * @param string $image
 * @param type $connection
 * @return int|bool lastInsertId
 */
function createProduct($formData, $image, $connection){
    try {
        // Make query string
        $sqlQueryString = "INSERT INTO products(title, description, image, price, category_id, sticker_id, homepage, quantity, discount)
            VALUES(:title, :description, :image, :price, :category_id, :sticker_id, :homepage, :quantity, :discount);";

        // Execute query (with params or without)
        $statement = $connection->prepare($sqlQueryString);

        // Execute return TRUE or FALSE
        $params = array(
            'title' => $formData['title'],
            'description' => $formData['description'],
            'image' => $image,
            'price' => $formData['price'],
            'category_id' => $formData['category_id'],
            'homepage' => $formData['homepage'],
            'quantity' => $formData['quantity']
        );
        
        if(isset($formData['sticker_id'])){
            $params['sticker_id'] = $formData['sticker_id'];
        }else{
            $params['sticker_id'] = NULL;
        }
        
        if(!empty($formData['discount'])){
            $params['discount'] = $formData['discount'];
        }else{
            $params['discount'] = NULL;
        }

        $status = $statement->execute($params);

        if($status){
            return $connection->lastInsertId();
        }
    } catch (PDOException $exc) {        
        return FALSE;
    }

    
}

/**
 * 
 * @param Array $formData
 * @param string $image
 * @param type $connection
 * @return int|bool lastInsertId
 */
function updateProduct($id, $formData, $image, $connection){
    try {
        // Make query string
        $sqlQueryString = "UPDATE products 
            SET title=:title, description=:description, image=:image, price=:price, category_id=:category_id, sticker_id=:sticker_id, homepage=:homepage, quantity=:quantity, discount=:discount
            WHERE id=:id;";

        // Execute query (with params or without)
        $statement = $connection->prepare($sqlQueryString);

        // Execute return TRUE or FALSE
        $params = array(
            'id' => (int)$id, 
            'title' => $formData['title'],
            'description' => $formData['description'],
            'image' => $image,
            'price' => $formData['price'],
            'category_id' => $formData['category_id'],
            'homepage' => $formData['homepage'],
            'quantity' => $formData['quantity']
        );
        
        if(isset($formData['sticker_id'])){
            $params['sticker_id'] = $formData['sticker_id'];
        }else{
            $params['sticker_id'] = NULL;
        }
        
        if(!empty($formData['discount'])){
            $params['discount'] = $formData['discount'];
        }else{
            $params['discount'] = NULL;
        }

        $status = $statement->execute($params);

        if($status){
            return TRUE;
        }
    } catch (PDOException $exc) {        
        return FALSE;
    }

    
}


/**
 * 
 * @param int $id product id to delete
 * @param PDO $connection
 * @return bool status of sql query
 */
function deleteProduct($id, $connection){
    try {
        // Make query string
        $sqlQueryString = "DELETE FROM products  WHERE id=:id";
        
        // Execute query (with params or without)
        $statement = $connection->prepare($sqlQueryString);

        // Execute return TRUE or FALSE
        $params = array(
            'id' => $id
        );

        $status = $statement->execute($params);

        if($status){
            return TRUE;
        }
    } catch (PDOException $exc) {        
        return FALSE;
    }    
}

/**
 *
 * @param string $title Product title
 * @param PDO $connection
 * @param int $id optional when update product
 * @return bool status does title exists
 */
function checkProductNameIsUnique($title, $connection, $id = NULL) {
	try {
		// Make query string
		$sqlQueryString = "
            SELECT p.*
            FROM products AS p
			WHERE p.title=:title
         ";
        
        // this part we use for update
        if(!is_null($id)){
            $sqlQueryString .= " AND p.id != :id;";
        }

		// Execute query (with params or without)
		$statement = $connection->prepare($sqlQueryString);

		// Execute return TRUE or FALSE
		$params = array(
			'title' => $title
		);
        
        // this part we use for update
        if(!is_null($id)){
            $params['id'] = $id;
        }

		$status = $statement->execute($params);


		if ($status) {
			// get ROWS (ROW SET) (fetchAll() - for row set or fetch() - for one row)
			$rows = $statement->fetchAll();
			
			if(count($rows) > 0){
                return FALSE;
            }else{
                return TRUE;
            }
		} else {
			return TRUE;
		}
		// close connection with NULL
	} catch (PDOException $e) {
		$_SESSION['systemMessage'] = "Something was wrong. Error: " . $e->getMessage();
        header("Location: /message.php");
        die();
	}
}
function deleteProductPhoto($id, $connection){
    try {
        // Make query string
        $sqlQueryString = "UPDATE products SET image=NULL where id=:id";
        
        // Execute query (with params or without)
        $statement = $connection->prepare($sqlQueryString);

        // Execute return TRUE or FALSE
        $params = array(
            'id' => $id
        );

        $status = $statement->execute($params);

        if($status){
            return TRUE;
        }
    } catch (PDOException $exc) {        
        return FALSE;
    }    
}
