<?php
include_once('db.php');

header('Content-Type: application/json');

$db = new TaskDB();

$data = $db->getTasks();

echo json_encode($data);

?>