<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="utf-8" />
    <title>SPA Комплекс – Резервации</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .datetime-input {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 10px;
            margin-top: 10px;
        }
        input[type="date"], input[type="time"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }
        .service-section {
            margin-bottom: 25px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 12px;
            border-left: 4px solid #d4265b;
        }
        .service-section h3 {
            margin-top: 0;
            color: #d4265b;
        }
    </style>
</head>
<body>
    <nav class="navbar">
    <div class="nav-container">
        <div class="logo">СПА "Cherry"</div>
        
        <div class="hamburger" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        
        <ul class="nav-menu" id="navMenu">
            <li><a href="usercp.php">Нова резервация</a></li>
            <li><a href="userorders.php">Моите резервации</a></li>
            <li><a href="contacts.php">Контакти</a></li>
            <li><a href="logout.php">Изход</a></li>
        </ul>
    </div>
</nav>
<?php
require_once 'inc/db.php';
session_start();

// Зареждане на СПА услугите
$spa_therapies = mysqli_query($connect, "SELECT * FROM spa_services WHERE service_type='СПА Терапии'");
$massages = mysqli_query($connect, "SELECT * FROM spa_services WHERE service_type='Масажи'");
$facials = mysqli_query($connect, "SELECT * FROM spa_services WHERE service_type='Козметични процедури'");
$body_treatments = mysqli_query($connect, "SELECT * FROM spa_services WHERE service_type='Грижа за тяло'");
$wellness = mysqli_query($connect, "SELECT * FROM spa_services WHERE service_type='Уелнес програми'");

// Добавяне на резервация
if(isset($_POST['submit'])){
    $payment = $_POST['payment_method'];
    $reservation_date = date('Y-m-d H:i:s');
    $has_reservation = false;

    function addReservation($connect, $user_id, $service_id, $qty, $payment, $date, $service_datetime){
        if($service_id && $qty > 0 && !empty($service_datetime)){
            $query = "INSERT INTO reservations (id_potrebitel, id_service, quantity, payment_method, reservation_date, service_datetime, status) VALUES ('$user_id','$service_id','$qty','$payment','$date','$service_datetime','pending')";
            return mysqli_query($connect, $query);
        }
        return false;
    }

    if(!empty($_POST['spa_therapy']) && !empty($_POST['qty_spa_therapy']) && !empty($_POST['date_spa_therapy']) && !empty($_POST['time_spa_therapy'])){
        $service_datetime = $_POST['date_spa_therapy'] . ' ' . $_POST['time_spa_therapy'] . ':00';
        if(addReservation($connect, $_SESSION['uid'], $_POST['spa_therapy'], $_POST['qty_spa_therapy'], $payment, $reservation_date, $service_datetime)){
            $has_reservation = true;
        }
    }
    if(!empty($_POST['massage']) && !empty($_POST['qty_massage']) && !empty($_POST['date_massage']) && !empty($_POST['time_massage'])){
        $service_datetime = $_POST['date_massage'] . ' ' . $_POST['time_massage'] . ':00';
        if(addReservation($connect, $_SESSION['uid'], $_POST['massage'], $_POST['qty_massage'], $payment, $reservation_date, $service_datetime)){
            $has_reservation = true;
        }
    }
    if(!empty($_POST['facial']) && !empty($_POST['qty_facial']) && !empty($_POST['date_facial']) && !empty($_POST['time_facial'])){
        $service_datetime = $_POST['date_facial'] . ' ' . $_POST['time_facial'] . ':00';
        if(addReservation($connect, $_SESSION['uid'], $_POST['facial'], $_POST['qty_facial'], $payment, $reservation_date, $service_datetime)){
            $has_reservation = true;
        }
    }
    if(!empty($_POST['body_treatment']) && !empty($_POST['qty_body_treatment']) && !empty($_POST['date_body_treatment']) && !empty($_POST['time_body_treatment'])){
        $service_datetime = $_POST['date_body_treatment'] . ' ' . $_POST['time_body_treatment'] . ':00';
        if(addReservation($connect, $_SESSION['uid'], $_POST['body_treatment'], $_POST['qty_body_treatment'], $payment, $reservation_date, $service_datetime)){
            $has_reservation = true;
        }
    }
    if(!empty($_POST['wellness']) && !empty($_POST['qty_wellness']) && !empty($_POST['date_wellness']) && !empty($_POST['time_wellness'])){
        $service_datetime = $_POST['date_wellness'] . ' ' . $_POST['time_wellness'] . ':00';
        if(addReservation($connect, $_SESSION['uid'], $_POST['wellness'], $_POST['qty_wellness'], $payment, $reservation_date, $service_datetime)){
            $has_reservation = true;
        }
    }
    
    if($has_reservation){
        echo '<script>alert("Резервацията е добавена успешно!");</script>';
    } else {
        echo '<script>alert("Моля, изберете услуга, количество, дата и час!");</script>';
    }
}

if(isset($_POST['pay'])){
    // Проверка дали има чакащи резервации
    $check_query = "SELECT COUNT(*) as count FROM reservations WHERE id_potrebitel = '{$_SESSION['uid']}' AND status = 'pending'";
    $check_result = mysqli_query($connect, $check_query);
    $check_row = mysqli_fetch_assoc($check_result);
    
    if($check_row['count'] > 0){
        header('Location: payconfirm.php'); 
        exit;
    } else {
        echo '<script>alert("Нямате резервации за плащане! Моля, добавете поне една услуга.");</script>';
    }
}
?>

<div class="container">
    <h1>SPA Комплекс – Резервация на услуги</h1>

    <div class="card">
        <form method="POST">
            <div class="service-section">
                <h3>СПА Терапии</h3>
                <label>Изберете услуга:</label>
                <select name="spa_therapy">
                    <option value="">Не желая</option>
                    <?php while($st=mysqli_fetch_assoc($spa_therapies)){ echo "<option value='{$st['id_service']}'>{$st['service_name']} – {$st['duration']} мин. – {$st['price']} лв.</option>";} ?>
                </select>
                
                <div class="row" style="margin-top: 10px;">
                    <div>
                        <label>Брой процедури:</label>
                        <input type="number" name="qty_spa_therapy" min="1" max="10" placeholder="Брой">
                    </div>
                </div>
                
                <div class="datetime-input">
                    <div>
                        <label>Дата:</label>
                        <input type="date" name="date_spa_therapy" min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div>
                        <label>Час:</label>
                        <input type="time" name="time_spa_therapy" min="09:00" max="20:00">
                    </div>
                </div>
            </div>

            <div class="service-section">
                <h3>Масажи</h3>
                <label>Изберете услуга:</label>
                <select name="massage">
                    <option value="">Не желая</option>
                    <?php while($m=mysqli_fetch_assoc($massages)){ echo "<option value='{$m['id_service']}'>{$m['service_name']} – {$m['duration']} мин. – {$m['price']} лв.</option>";} ?>
                </select>
                
                <div class="row" style="margin-top: 10px;">
                    <div>
                        <label>Брой процедури:</label>
                        <input type="number" name="qty_massage" min="1" max="10" placeholder="Брой">
                    </div>
                </div>
                
                <div class="datetime-input">
                    <div>
                        <label>Дата:</label>
                        <input type="date" name="date_massage" min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div>
                        <label>Час:</label>
                        <input type="time" name="time_massage" min="09:00" max="20:00">
                    </div>
                </div>
            </div>

            <div class="service-section">
                <h3>Козметични процедури</h3>
                <label>Изберете услуга:</label>
                <select name="facial">
                    <option value="">Не желая</option>
                    <?php while($f=mysqli_fetch_assoc($facials)){ echo "<option value='{$f['id_service']}'>{$f['service_name']} – {$f['duration']} мин. – {$f['price']} лв.</option>";} ?>
                </select>
                
                <div class="row" style="margin-top: 10px;">
                    <div>
                        <label>Брой процедури:</label>
                        <input type="number" name="qty_facial" min="1" max="10" placeholder="Брой">
                    </div>
                </div>
                
                <div class="datetime-input">
                    <div>
                        <label>Дата:</label>
                        <input type="date" name="date_facial" min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div>
                        <label>Час:</label>
                        <input type="time" name="time_facial" min="09:00" max="20:00">
                    </div>
                </div>
            </div>

            <div class="service-section">
                <h3>Грижа за тяло</h3>
                <label>Изберете услуга:</label>
                <select name="body_treatment">
                    <option value="">Не желая</option>
                    <?php while($bt=mysqli_fetch_assoc($body_treatments)){ echo "<option value='{$bt['id_service']}'>{$bt['service_name']} – {$bt['duration']} мин. – {$bt['price']} лв.</option>";} ?>
                </select>
                
                <div class="row" style="margin-top: 10px;">
                    <div>
                        <label>Брой процедури:</label>
                        <input type="number" name="qty_body_treatment" min="1" max="10" placeholder="Брой">
                    </div>
                </div>
                
                <div class="datetime-input">
                    <div>
                        <label>Дата:</label>
                        <input type="date" name="date_body_treatment" min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div>
                        <label>Час:</label>
                        <input type="time" name="time_body_treatment" min="09:00" max="20:00">
                    </div>
                </div>
            </div>

            <div class="service-section">
                <h3>Уелнес програми</h3>
                <label>Изберете услуга:</label>
                <select name="wellness">
                    <option value="">Не желая</option>
                    <?php while($w=mysqli_fetch_assoc($wellness)){ echo "<option value='{$w['id_service']}'>{$w['service_name']} – {$w['duration']} мин. – {$w['price']} лв.</option>";} ?>
                </select>
                
                <div class="row" style="margin-top: 10px;">
                    <div>
                        <label>Брой процедури:</label>
                        <input type="number" name="qty_wellness" min="1" max="10" placeholder="Брой">
                    </div>
                </div>
                
                <div class="datetime-input">
                    <div>
                        <label>Дата:</label>
                        <input type="date" name="date_wellness" min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div>
                        <label>Час:</label>
                        <input type="time" name="time_wellness" min="09:00" max="20:00">
                    </div>
                </div>
            </div>

            <label>Начин на плащане</label>
            <select name="payment_method">
                <option value="card">С карта</option>
                <option value="cash">В брой</option>
            </select>

            <button class="btn" name="submit">Добави</button>
            <button class="btn" name="pay">Преглед и плащане</button>
        </form>
    </div>
</div>
    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>За Нас</h3>
                <p>СПА Комплекс "Cherry" е водещ луксозен СПА център във Варна, предлагащ изключителни wellness услуги от 2015 година.</p>
            </div>
            <div class="footer-section">
                <h3>Бързи връзки</h3>
                <a href="#services">Услуги</a>
                <a href="gallery.php">Галерия</a>
                <a href="contacts.php">Контакти</a>
            </div>
            <div class="footer-section">
                <h3>Контакти</h3>
                <p>📞 +359 52 123 456</p>
                <p>📧 info@spa-edelweiss.bg</p>
                <p>📍 бул. "Цар Освободител" 125, Варна</p>
            </div>
            <div class="footer-section">
                <h3>Социални мрежи</h3>
                <a href="#">Facebook</a>
                <a href="#">Instagram</a>
                <a href="#">TripAdvisor</a>
            </div>
        </div>
        <div class="copyright">
            &copy; 2024 СПА Комплекс "Cherry". Всички права запазени.
        </div>
    </footer>

<script>
function toggleMenu() {
    const navMenu = document.getElementById('navMenu');
    navMenu.classList.toggle('active');
}
</script>
</body>
</html>