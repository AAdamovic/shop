<?php

/**
 * Get all categories
 * @param PDO $connection
 * @return array
 */
function getAllCategories($connection) {
	try {
		// Make query string
		$sqlQueryString = "
            SELECT *
            FROM categories
            ORDER BY name;
         ";

		// Execute query (with params or without)
		$statement = $connection->prepare($sqlQueryString);

		// Execute return TRUE or FALSE
		$params = array(
			
		);

		$status = $statement->execute($params);


		if ($status) {
			// get ROWS (ROW SET) (fetchAll() - for row set or fetch() - for one row)
			return $rows = $statement->fetchAll();
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
 * Get all categories
 * @param PDO $connection
 * @return array
 */
function getAllCategoriesForSelect($connection) {
	try {
		// Make query string
		$sqlQueryString = "
            SELECT id, name
            FROM categories
            ORDER BY name;
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
			
            // prepare possible values
            $arrayForSelectOption = array();
            if(count($rows) > 0){
                foreach ($rows as $value) {
                    $arrayForSelectOption[$value['id']] = $value['name'];
                }
            }
            
			return $arrayForSelectOption;
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
 * Get all categories
 * @param PDO $connection
 * @return array
 */
function getAllCategoriesForNavigation($connection) {
	try {
		// Make query string
		$sqlQueryString = "
            SELECT categories.id, categories.name, COUNT(categories.name) as total, products.title
            FROM products
            RIGHT JOIN categories ON categories.id = products.category_id
            WHERE products.title IS NOT NULL and categories.ban = 0
            GROUP BY categories.id, categories.name  
            ORDER BY categories.id ASC
         ";

		// Execute query (with params or without)
		$statement = $connection->prepare($sqlQueryString);

		// Execute return TRUE or FALSE
		$params = array(
			
		);

		$status = $statement->execute($params);


		if ($status) {
			// get ROWS (ROW SET) (fetchAll() - for row set or fetch() - for one row)
			return $rows = $statement->fetchAll();
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
 * @return array Returns false if no category is found for given id
 */
function getCategory($id, $connection) {
	try {
		// Make query string
		$sqlQueryString = "
            SELECT *
            FROM categories 
			WHERE id=:id
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
function createCategory($formData, $image, $connection){
    try {
        // Make query string
        $sqlQueryString = "INSERT INTO categories(name, text, image)
            VALUES(:name, :text, :image);";

        // Execute query (with params or without)
        $statement = $connection->prepare($sqlQueryString);

        // Execute return TRUE or FALSE
        $params = array(
            'name' => $formData['name'],
            'text' => $formData['text'],
            'image' => $image
        );

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
function updateCategory($id, $formData, $image, $connection){
    try {
        // Make query string
        $sqlQueryString = "UPDATE categories 
            SET name=:name, text=:text, image=:image, ban=:ban
            WHERE id=:id;";

        // Execute query (with params or without)
        $statement = $connection->prepare($sqlQueryString);

        // Execute return TRUE or FALSE
        $params = array(
            'id' => (int)$id, 
            'name' => $formData['name'],
            'text' => $formData['text'],
            'image' => $image,
            'ban' => $formData['ban']
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
 * @param int $id category id to delete
 * @param PDO $connection
 * @return bool status of sql query
 */
function deleteCategory($id, $connection){
    try {
        // Make query string
        $sqlQueryString = "DELETE FROM categories  WHERE id=:id";
        
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
 * Count products for category
 * @param int $id category id
 * @param PDO $connection
 * @return int number of products
 */
function totalNumberOfProductsInCategory($id, $connection) {
	try {
		// Make query string
		$sqlQueryString = "
            SELECT COUNT(categories.name) as total
            FROM products
            RIGHT JOIN categories ON categories.id = products.category_id
            WHERE categories.id = :id
            GROUP BY categories.id, categories.name  
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
function deleteCategoryPhoto($id, $connection){
    try {
        // Make query string
        $sqlQueryString = "UPDATE categories SET image=NULL where id=:id";
        
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