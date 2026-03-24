<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="utf-8" />
    <title>СПА Комплекс "Cherry"</title>
	<link rel="icon" type="image/x-icon" href="logo.png">
    <link rel="stylesheet" href="style.css">
</head>
<body class="register-page">

<?php include 'inc/navbar.php'; ?>

<div class="register-content-wrapper">
        <div class="register-box">
            <h2>Регистрация</h2>

            <form action="" method="POST" name="login">
                <label>Потребителско име:</label>
                <input type="text" name="username" required>

                <label>Парола:</label>
                <input type="password" name="password" required>

                <label>Име:</label>
                <input type="text" name="first_name" required>

                <label>Фамилия:</label>
                <input type="text" name="last_name" required>

                <label>Телефон:</label>
                <input type="text" name="number" required pattern="([0-9]{10})" placeholder="0881234567">

                <label>Е-поща:</label>
                <input type="text" name="mail" required placeholder="example@mail.com">

                <label>Адрес:</label>
                <input type="text" name="address" required placeholder="гр. Варна, ул. Пирин 18">

                <input type="submit" class="submit-btn" name="submit" value="Регистрирай се">
            </form>

            <a class="login-link" href="login.php">Вече имате профил? Влезте</a>

            <?php
            include_once 'inc/db.php';
            include_once 'conf/settings.php';

            if(isset($_POST['submit'])) {
                if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['first_name']) && isset($_POST['last_name'])
                    && isset($_POST['number']) && isset($_POST['mail']) && isset($_POST['address'])) {

                    $querycheck = "SELECT username_potrebitel FROM potrebiteli WHERE username_potrebitel = '{$_POST['username']}'";
                    $resultcheck = mysqli_query($connect, $querycheck);
                    $rowcheck = mysqli_fetch_assoc($resultcheck);
                    if($rowcheck)
                    {
                        echo '<div class="error-msg">Вече съществува потребител с това име!</div>';
                    }
                    else{
                        $username = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['username']));
                        $password = htmlspecialchars(mysqli_real_escape_string($connect,md5($_POST['password'].$salt)));
                        $first_name = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['first_name']));
                        $last_name = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['last_name']));
                        $number = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['number']));
                        $mail = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['mail']));
                        $address = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['address']));
                        $query = "INSERT INTO `potrebiteli`(`ime_potrebitel`, `familiq_potrebitel`, `username_potrebitel`, `parola_potrebitel`, `telefon_potrebitel`, `email_potrebitel`, `adres_potrebitel`, `rank_id`) VALUES ('$first_name','$last_name','$username','$password', '$number', '$mail', '$address', '1')";
                        $result = mysqli_query($connect, $query);
                        if($result) {
                            echo '<div class="success-msg">Регистрацията завърши успешно! Пренасочване...</div>';
                            echo '<meta http-equiv="refresh" content="2; url=login.php" />';
                        }
                        else {
                            echo '<div class="error-msg">Проблем при регистрацията!</div>';
                        }
                    }
                }
            }
            ?>
        </div>
    </div>


    <img src="chb3.png" class="right-image">

    <script>
        $(".error-msg, .success-msg").fadeIn(200).delay(3500).fadeOut(2000);
        
        function toggleMenu() {
            const navMenu = document.getElementById('navMenu');
            navMenu.classList.toggle('active');
        }
    </script>

<?php include 'inc/footer.php'; ?>

</body>
</html>