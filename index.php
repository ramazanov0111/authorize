<?php
    require_once 'captcha_class.php';
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'mysite');
    
    $mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_errno) exit('Ошибка соединения с БД');
    $mysqli->set_charset('utf8');

    if (isset($_POST['reg'])) {
        if (Captcha::check($_POST['captcha'])) echo 'Проверочный код введён верно!';
        else echo 'Проверочный код введён неверно!';
        $name = $mysqli->real_escape_string(htmlspecialchars($_POST['name']));
        $email = $mysqli->real_escape_string(htmlspecialchars($_POST['email']));
        $password = $mysqli->real_escape_string(htmlspecialchars($_POST['password']));
        $query = "INSERT INTO `users`
        (`name`, `email`, `password`)
        VALUES ('$name', '$email', MD5('$password'))";
        $result = $mysqli->query($query);
    }
    $mysqli->close();
    
?>

<?php if (isset($result)) { ?>
    <?php if ($result) { ?>
        <p>Здравствуйте, "<?=$name?></p>
    <?php } else { ?>
        <p>Ошибка при регистрации!</p>
    <?php } ?>
<?php } ?>
<form name='reg' action='index.php' method='post'>
    <p>
        Имя: <input type='text' name='name' />
    </p>
    <p>
        E-mail: <input type='text' name='email' />
    </p>
    <p>
        Пароль: <input type='password' name='password' />
    </p>
    <p>
        Проверочный код: <input type='text' name='captcha' />
    </p>
    <p>
        <img src='captcha.php' alt='' />
    </p>
    <p>
        <input type='submit' name='reg' value='Зарегистрироваться' />
    </p>
</form>