<?php   
        require_once 'MongoDB/DatabaseManager.php';
        require_once 'MongoDB/Querybuilder.php';
        require_once 'System/Main.php';

        $m = new com\arkhamhorrordb\API\System\Main();
        $result = $m->connect();
?>

