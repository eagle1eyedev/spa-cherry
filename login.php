<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="utf-8" />
    <title>СПА Комплекс "Cherry"</title>
    <link rel="icon" type="image/x-icon" href="logo.png">
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">

<?php include 'inc/navbar.php'; ?>

    <div class="login-content-wrapper">
        <h1>SPA Комплекс "Cherry"</h1>

        <div class="login-box">
            <form action="" method="POST">
                <label>Потребителско име:</label>
                <input type="text" name="username" required>

                <label>Парола:</label>
                <input type="password" name="password" required>

                <input type="submit" class="submit-btn" name="submit" value="Вход">
                
            </form>

            <a class="login-link" href="register.php">Нямате профил? Регистрирайте се тук</a>

            <?php
            session_start();
            include_once 'inc/db.php';
            include_once 'conf/settings.php';

            if(isset($_POST['submit'])) {
                $username = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['username']));
                $password = htmlspecialchars(mysqli_real_escape_string($connect,md5($_POST['password'].$salt)));
                $query = "SELECT id_potrebitel, rank_id FROM potrebiteli WHERE username_potrebitel='$username' AND parola_potrebitel='$password'";
                $result = mysqli_query($connect, $query);
                $row = mysqli_fetch_assoc($result);

                if(mysqli_num_rows($result) === 1) {
                    $_SESSION['LoggedIn'] = true;
                    $_SESSION['uid'] = $row['id_potrebitel'];
                    $_SESSION['ur'] = $row['rank_id'];
                    echo '<meta http-equiv="refresh" content="0; url=inc/menu.php" />';
                }
                else{
                    echo '<div class="error-msg">Грешно потребителско име или парола!</div>';
                }
            }
            ?>
        </div>
        
        <img src="chb1.png" class="left-image">
    </div>


    <script>
        $(".error-msg").fadeIn(200).delay(3500).fadeOut(2000);
        
        function toggleMenu() {
            const navMenu = document.getElementById('navMenu');
            navMenu.classList.toggle('active');
        }
    </script>

<?php include 'inc/footer.php'; ?>

</body>
</html>