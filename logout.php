<?php
// Стартиране на сесията
session_start();

// Проверка дали има активна сесия
if(isset($_SESSION)) {
    // Изтриване на всички сесийни променливи
    $_SESSION = array();
    
    // Унищожаване на сесийните cookies
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-42000, '/');
    }
    
    // Унищожаване на сесията
    session_destroy();
    
    // Изчистване на всички сесийни данни
    unset($_SESSION);
    
    // Пренасочване към началната страница с кратко съобщение
    echo '<!DOCTYPE html>
    <html lang="bg">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="refresh" content="2; url=login.php">
        <title>Изход</title>

        <link rel="stylesheet" href="style.css">
    </head>
    <body class="logout-page">
        <div class="logout-box">
            <div class="icon">👋</div>
            <h1>Успешно излязохте от системата!</h1>
            <p>Благодарим, че използвахте СПА Комплекс "Cherry"</p>
            <p>Ще бъдете пренасочени към началната страница...</p>
        </div>
    </body>
    </html>';
    
    exit();
}
else {
    // Ако няма активна сесия, пренасочи директно
    header('Location: login.php');
    exit();
}
?>