<?php   
    include_once('db.php');

    $db = new TaskDB();

    echo $db->getTasks2();
?>