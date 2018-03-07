<?php

/**
 * Get all pages
 * @param PDO $connection
 * @return array
 */
function getAllPages($connection) {
    try {
        // Make query string
        $sqlQueryString = "
            SELECT *
            FROM pages
            ORDER BY title;
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
    
function getPage($id, $connection){
    try {
		// Make query string
		$sqlQueryString = "
            SELECT *
            FROM pages 
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

function createPage($connection, $formData, $image) {
    try {
        // Make query string
        $sqlQueryString = "INSERT INTO pages (title, text, image) VALUES (:title, :pagetext, :image);";

         echo "Successfully connected to DBMS<br>";
        echo ("Successfully connected to database " . $databaseName);
        // Execute query (with params or without)
        $statement = $connection->prepare($sqlQueryString);

        // Execute return TRUE or FALSE
        $params = array(
            'title' => $formData['title'],
            'pagetext' => $formData['pageText'],
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
function updatePage($id, $formData, $image, $connection){
    try {
        // Make query string
        $sqlQueryString = "UPDATE pages 
            SET title=:title, text=:text, image=:image
            WHERE id=:id;";

        // Execute query (with params or without)
        $statement = $connection->prepare($sqlQueryString);

        // Execute return TRUE or FALSE
        $params = array(
            'id' => (int)$id, 
            'title' => $formData['title'],
            'text' => $formData['text'],
            'image' => $image
        );

        $status = $statement->execute($params);

        if($status){
            return TRUE;
        }
    } catch (PDOException $exc) {        
        return FALSE;
    }

}
function deletePage($id, $connection){
    try {
        // Make query string
        $sqlQueryString = "DELETE FROM pages WHERE id=:id";
        
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
function deletePagePhoto($id, $connection){
    try {
        // Make query string
        $sqlQueryString = "UPDATE pages SET image=NULL where id=:id";
        
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
