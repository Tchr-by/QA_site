<?php 
 get_header();

/* Осуществляем проверку вводимых данных и их защиту от враждебных  
скриптов */ 
if(isset( $_POST["name"], $_POST["email"], $_POST["phone"], $_POST["choice"] )) {
    $name = htmlspecialchars($_POST["name"]); 
    $email = htmlspecialchars($_POST["email"]); 
    $phone = htmlspecialchars($_POST["phone"]); 
    $course = $_POST["choice"];
}



/* Проверяем заполнены ли обязательные поля ввода, используя check_input  
функцию */ 
if(empty($name) || empty($email) || empty($phone) || empty($course)) { //если что то не ввели
     echo 'Вы заполнили не все поля!';
    }
    else {
        $name = check_input($_POST["name"], "Введите ваше имя!"); 
        $phone = check_input($_POST["phone"], "Укажите тему сообщения!"); 
        $email = check_input($_POST["email"], "Введите ваш e-mail!"); 
        $course = check_input($_POST["choice"], "Выберите форму обучения!");
}



/* Проверяем правильно ли записан e-mail */ 
if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)) 
{ 
show_error("<br /> Е-mail адрес не существует"); 
}; ?>

<h1>slfjbelkjfbsejfb</h1>


<label for="choice1">Дневная форма обучения</label>
<label for="choice2">Вечерняя форма обучения</label>


<html>
<body>
<p>Ваше сообщение было успешно отправлено!</p> 
<p>На <a href="index.php">Главную >>></a></p> 
</body>
</html>


<?php 
/* Если при заполнении формы были допущены ошибки сработает  
следующий код: */ 

function check_input($data, $problem = "") { 

    $data = trim($data); 
    $data = stripslashes($data); 
    $data = htmlspecialchars($data); 
        if ($problem && strlen($data) == 0) 
        { 
        show_error($problem); 
        } 
        return $data; 
        } 
        
function show_error($myError) { ?> 

<html> 
    <body> 
        <p>Пожалуйста исправьте следующую ошибку:</p> 
        <?php echo $myError; ?> 
    </body> 
</html> 
<?php exit(); 
} ?>



<?php get_footer();