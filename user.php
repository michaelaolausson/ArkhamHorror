<!DOCTYPE html>
<html>
    <header>
        <title>TEST</title>
    </header>
    <body>
        <?php   
            require_once 'API/MongoDB/Manager.php';
            require_once 'API/MongoDB/UserManager.php';
            require_once "API/MongoDB/User.php";
            require_once 'API/MongoDB/Querybuilder.php';
            require_once 'API/System/KeyGenerator.php';
            require_once 'API/System/Main.php';
            //$m = new com\arkhamhorrordb\API\System\Main;
            $u = new com\arkhamhorrordb\API\MongoDB\UserManager;
        ?>
    </body>
    <div>
    <hr>
        <form method="post" action="user.php">
            <fieldset>
                <label>Username: </label>
                    <input type="username" name="username"></input><br>
                <label>E-mail: </label>
                    <input type="email" name="email"></input><br>
                <label>Password: </label>
                    <input type="password" name="password1"></input><br>
                <label>Confirm Password: </label>
                    <input type="password" name="password2"></input><br>

                    <input type="submit" value="submit"></input><br>
            </fieldset>
        </form>
    </div>
    <hr>
</html>
