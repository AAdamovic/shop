<?php

/**
 * Funkcija koja proverava unesene kredencijale tj. login formu
 * 
 * 
 * @param string $username
 * @param string $password
 * @return boolean
 */
function checkUser($username, $password, $connection){
    try {
        // Make query string
        $sqlQueryString = "
                SELECT *
                FROM users 
                WHERE email = :email AND password = :password AND ban = :ban ;
             ";

        // Execute query (with params or without)
        $statement = $connection->prepare($sqlQueryString);

        // Execute return TRUE or FALSE
        $params = array(
            'email' => $username,
            'password' => md5($password),
            'ban' => 0
         );

        $status = $statement->execute($params);


        if($status){
            // get ROWS (ROW SET) (fetchAll() - for row set or fetch() - for one row)
            $row = $statement->fetch();
            
//            if(count($row) == 1){
//                
//            }
            
            if($statement->rowCount() == 1){
                if(!isset($_SESSION)){
                    session_start();
                }
                
                $_SESSION['loggedIn'] = TRUE;
                $_SESSION['userId'] = $row['id'];
                $_SESSION['userName'] = $row['name'] . ' ' . $row['surname'];
                return TRUE;
            }else{
                return FALSE;
            }
        }

    }catch( PDOException $e ) {
        $_SESSION['systemMessage'] = "Something was wrong. Error: " . $e->getMessage();
        header("Location: /message.php");
        die();
    }
}

/**
 * 
 */
function isLoggedIn(){
    if(!isset($_SESSION)){
        session_start();
    }

    if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == TRUE){
        
    }else{
        header("Location: /login.php");
        die();
    }
}


/**
 * 
 * @param Array $formData
 * @param PDO $connection
 * @return int|bool lastInsertId
 */
function createUser($formData, $connection){
    try {
        // Make query string
        $sqlQueryString = "INSERT INTO users(name, surname, email, password, ban)
            VALUES(:name, :surname, :email, :password, :ban);";

        // Execute query (with params or without)
        $statement = $connection->prepare($sqlQueryString);

        // Execute return TRUE or FALSE
        $params = array(
            'name' => $formData['name'],
            'surname' => $formData['surname'],
            'email' => $formData['email'],
            'password' => md5($formData['password']),
            'ban' => 0
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
 * @param int $id
 * @param PDO $connection
 * @return array Returns false if no user is found for given id
 */
function getUser($id, $connection) {
	try {
		// Make query string
		$sqlQueryString = "
            SELECT *
            FROM users AS u
			WHERE u.id=:id
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
 * @param PDO $connection
 * @return array Returns all users
 */
function getAllUsers($connection) {
	try {
		// Make query string
		$sqlQueryString = "
            SELECT *
            FROM users AS u
            ORDER BY name ASC, surname ASC
         ";

		// Execute query (with params or without)
		$statement = $connection->prepare($sqlQueryString);

		$status = $statement->execute();


		if ($status) {
			// get ROWS (ROW SET) (fetchAll() - for row set or fetch() - for one row)
			$row = $statement->fetchAll();
			
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
 * @param int $id user id to delete
 * @param PDO $connection
 * @return bool status of sql query
 */
function deleteUser($id, $connection){
    try {
        // Make query string
        $sqlQueryString = "DELETE FROM users  WHERE id=:id";
        
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
 * @param Array $formData
 * @param PDO $connection
 * @return bool status of sql query
 */
function updateUser($id, $formData, $connection){
    try {
        // Make query string
        $sqlQueryString = "
            UPDATE users
            SET name=:name, surname=:surname, ban=:ban
            ";
        
        // password ulazi u upit samo ako je unesen
        if($formData['password'] !== ""){
            $sqlQueryString .= " , password=:password ";
        }
        
        $sqlQueryString .= " WHERE id=:id;";

        // Execute query (with params or without)
        $statement = $connection->prepare($sqlQueryString);

        // Execute return TRUE or FALSE
        $params = array(
            'id' => $id,
            'name' => $formData['name'],
            'surname' => $formData['surname'],
            'ban' => $formData['ban']
        );
        
        // password ulazi u upit samo ako je unesen
        if($formData['password'] !== ""){
            $params['password'] = md5($formData['password']);
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
 * @param string $email Email to check
 * @param PDO $connection
 * @return bool status does email exists
 */
function checkEmailIsUnique($email, $connection) {
	try {
		// Make query string
		$sqlQueryString = "
            SELECT *
            FROM users
			WHERE users.email=:email
         ";

		// Execute query (with params or without)
		$statement = $connection->prepare($sqlQueryString);

		// Execute return TRUE or FALSE
		$params = array(
			'email' => $email
		);
        

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