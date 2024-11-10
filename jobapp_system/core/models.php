<?php

require_once 'dbConfig.php';

function checkIfUserExists($pdo, $username) {
    $response = ["message" => "", "statusCode" => 400, "querySet" => []];
    
    $sql = "SELECT * FROM applicants WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$username])) {
        $userInfoArray = $stmt->fetch();
        
        if ($stmt->rowCount() > 0) {
            $response = array(
                "result" => true,
                "statusCode" => 200,
                "querySet" => $userInfoArray
            );
        } else {
            $response = array(
                "statusCode" => 400,
                "message" => "User doesn't exist in the database"
            );
        }
    }
    
    return $response;
}

function getAllUsers($pdo) {
    $stmt = $pdo->query("SELECT * FROM applicants");
    $querySet = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return ['querySet' => $querySet];
}

function getUserByID($pdo, $id) {
	$sql = "SELECT * from applicants WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function searchForAUser($pdo, $searchQuery) {
    $sql = "SELECT * FROM applicants WHERE first_name LIKE ?";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute(["%".$searchQuery."%"]);

    if ($executeQuery) {
        return $stmt->fetchAll();
    } else {
        return []; 
    }
}



function insertNewUser($pdo, $username, $first_name, $last_name, $email, $phone, $address, $position) {
    $response = ["message" => "", "statusCode" => 400];

    $checkIfUserExists = checkIfUserExists($pdo, $username);
    
    if (!$checkIfUserExists['result']) {
        $sql = "INSERT INTO applicants (username, first_name, last_name, email, phone, address, position)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([$username, $first_name, $last_name, $email, $phone, $address, $position]);
        
        if ($executeQuery) {
            $response["message"] = "Applicant inserted successfully.";
            $response["statusCode"] = 200;
        } else {
            $response["message"] = "Failed to insert applicant.";
        }
    } else {
        $response["message"] = "User already exists!";
    }
    
    return $response;
}

function editUser($pdo, $username, $first_name, $last_name, $email, $phone, $address, $position, $id) {
    $sql = "UPDATE applicants
            SET 
                username = ?,
                first_name = ?,
                last_name = ?,
                email = ?,
                phone = ?,
                address = ?,
                position = ?
            WHERE id = ?";
    
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$username, $first_name, $last_name, $email, $phone, $address, $position, $id]);

    if ($executeQuery) {
        return true;
    }
}



function deleteUser($pdo, $id) {
    $response = ["message" => "", "statusCode" => 400];
    
    $sql = "DELETE FROM applicants WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$id]);
    
    if ($executeQuery) {
        $response["message"] = "Applicant deleted successfully.";
        $response["statusCode"] = 200;
    } else {
        $response["message"] = "Failed to delete applicant.";
    }
    
    return $response;
}


?>
