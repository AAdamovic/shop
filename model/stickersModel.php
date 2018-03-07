<?php

/**
 * Get all categories
 * @param PDO $connection
 * @return array
 */
function getAllStickersForSelect($connection) {
	try {
		// Make query string
		$sqlQueryString = "
            SELECT *
            FROM stickers
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
			$rows = $statement->fetchAll();
			
            // prepare possible values
            $arrayForSelectOption = array();
            if(count($rows) > 0){
                foreach ($rows as $value) {
                    $arrayForSelectOption[$value['id']] = $value['title'];
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
