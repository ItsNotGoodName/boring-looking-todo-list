<?php
    class TaskDB extends SQLite3{
        function __construct(){
            $this->open('tasks.db'); // TODO: Move to external
        }

        // Return true or false if execute successfully
        function deleteTaskByID($id){
            return $this->exec( 'DELETE FROM Task WHERE "ID"='.$id.';');
        }

        function taskInDatabase($task){
            if($this->query('SELECT task FROM Task WHERE task="'.$task.'"')->fetchArray()){
                return true;
            }
            return false;
                
        }

        // Return id or null
        function writeTask($entry){
            // check if write worked
            $add = $this->exec("INSERT INTO `Task` (`task`) VALUES ('".$entry."')");
            if($add){ 
                // Return the id it generated
                return $this->querySingle('select last_insert_rowid()');
            }
            return null; // Did not work
        }
        // Returns array of all the tasks
        function getTasks(){
            $result = array();

            // Get all the ids from table
            $ids = $this->query('SELECT ID FROM Task');
            $taskStatement = $this->prepare('SELECT task FROM Task WHERE ID=:ID');

            // Iterate til ids is empty
            while($ID = $ids->fetchArray()){ 
                // Get the id value
                $ID = $ID['ID']; 
                // Use id to execute statement
                $taskStatement->bindValue(':ID', $ID);
                $task = $taskStatement->execute();
                // Apply data to array and reset statement
                $result[$ID] = $task->fetchArray()['task'];
                $taskStatement->reset();
            }
            return $result;
        }
        // TODO: MAKE A BETTER ONE
        function getTasks2(){

        }

        function clearTasks(){
            $this->exec('DELETE FROM Task WHERE 1=1;');
        }

        function createTable(){
            $this->exec('CREATE TABLE `Task` (
                `ID`	INTEGER,
                `task`	TEXT,
                PRIMARY KEY(`ID`)
            );');
        }
    }
?>