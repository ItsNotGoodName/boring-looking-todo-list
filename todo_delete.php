<?php
include_once('db.php');

if(isset($_POST['id'])){
    $db = new TaskDB();

    $db->deleteTaskByID($_POST['id']);
    http_response_code(200);
}
?>