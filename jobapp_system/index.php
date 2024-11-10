<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <?php if (isset($_SESSION['message'])) { ?>
        <h1 style="color: purple; text-align: center;">   
            <?php echo $_SESSION['message']; ?>
        </h1>
        <?php unset($_SESSION['message']); ?>
    <?php } ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="GET">
        <input type="text" name="searchInput" placeholder="Search here">
        <input type="submit" name="searchBtn">
    </form>

    <p><a href="index.php">Clear Search Query</a></p>
    <p><a href="insert.php">Insert New User</a></p>

    <table style="width:100%; margin-top: 20px;">
        <tr>
            <th>Username</th> 
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Position</th>
            <th>Date Applied</th>
            <th>Action</th>
        </tr>

        <?php if (!isset($_GET['searchBtn'])) { ?>
            <?php $getAllUsers = getAllUsers($pdo); ?>
                <?php foreach ($getAllUsers['querySet'] as $row) { ?>
                    <tr>
                        <td><?php echo $row['username']; ?></td> 
                        <td><?php echo $row['first_name']; ?></td>
                        <td><?php echo $row['last_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td><?php echo $row['position']; ?></td>
                        <td><?php echo $row['date_applied']; ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
                        </td>
                    </tr>
            <?php } ?>
            
            <?php } else { ?>
            <?php 
            }
            if (isset($_GET['searchBtn']) && isset($_GET['searchInput']) && !empty($_GET['searchInput'])) {
                $searchForAUser = searchForAUser($pdo, $_GET['searchInput']);
                if (!empty($searchForAUser)) {
                    foreach ($searchForAUser as $row) { ?>
                        <tr>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['first_name']; ?></td>
                            <td><?php echo $row['last_name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['position']; ?></td>
                            <td><?php echo $row['date_applied']; ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="9">No users found.</td>
                    </tr>
                <?php }
            }
        ?>

    </table>
</body>
</html>
