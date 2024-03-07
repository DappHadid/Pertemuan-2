<?php
session_start();
include('server/connection.php');

if(!isset($_SESSION['logged_in'])){
    header ('location: index.php');
    exit;
}

if (isset($_GET['logout'])) {
    if (isset($_SESSION['logged_in'])){
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        header('location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>

<body style="background-color: gray;">
    <h2>SELAMAT DATANG</h2>
    <br>
    <?php echo $_SESSION['user_name'] ?> <br>

    <h2>DATA YANG DI TAMPILKAN</h2>

    <table border = "1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Phone Number</th>
            <th>Address</th>
            <th>City</th>
            <th>Photo</th>
        </tr>

        <?php
        $query = mysqli_query($conn, "Select * from users");
        if($query){
            while ($tampil = ($query)){
            echo "
            <tr>
                <td>$tampil[user_name]</td>
                <td>$tampil[user_email]</td>
                <td>$tampil[user_password]</td>
                <td>$tampil[user_phone]</td>
                <td>$tampil[user_address]</td>
                <td>$tampil[user_city]</td>
                <td>$tampil[user_photo]</td>
            </tr>";
            }
            }else {
            echo "Data tidak ditemukan" . mysqli_error($conn);
        }
        ?>
    </table>
    <a href="welcome.php?logout=1" id="logout-btn">
        <button>
            logout
        </button>
    </a>
</body>
</html>