<?php
include_once('db.php');

if(isset($_POST['task'])){
    $db = new TaskDB();

    if(!$db->taskInDatabase($_POST['task'])){
        echo $db->writeTask($_POST['task']);
    } else{
        echo -1;
    }
} else{
    echo "Task not set";
}
?>