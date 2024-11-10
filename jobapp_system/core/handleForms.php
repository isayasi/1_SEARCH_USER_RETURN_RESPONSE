<?php
require_once 'dbConfig.php';
require_once 'models.php';
  

if (isset($_POST['insertUserBtn'])) {
	$insertUser = insertNewUser($pdo,$_POST['username'], $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone'], $_POST['address'], $_POST['position']);

	if ($insertUser) {
		$_SESSION['message'] = "Successfully inserted!";
		header("Location: ../index.php");
	}
}

if (isset($_POST['editUserBtn'])) {
    $id = $_GET['id'];
    $editUser = editUser($pdo, $_POST['username'], $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone'], $_POST['address'], $_POST['position'], $id);
    if ($editUser) {
        $_SESSION['message'] = "Successfully edited!";
        header("Location: ../index.php");
    }
}


if (isset($_POST['deleteUserBtn'])) {
	$deleteUser = deleteUser($pdo,$_GET['id']);

	if ($deleteUser) {
		$_SESSION['message'] = "Successfully deleted!";
		header("Location: ../index.php");
	}
}

if (isset($_GET['searchBtn'])) {
    $searchInput = trim($_GET['searchInput']);
    $searchForAUser = searchForAUser($pdo, $searchInput);

    if ($searchForAUser) {
        foreach ($searchForAUser as $row) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['first_name']}</td>
                    <td>{$row['last_name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['address']}</td>
                    <td>{$row['position']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No records found.</td></tr>";
    }
}
?>


?>
