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
        // TODO: MAKE A BETTER ONE
        function getTasks(){
            $query_result = $this->query("SELECT * FROM Task");
            $formated_array = [];
            
            while($row = $query_result->fetchArray()){
                $formated_array[$row['ID']] = $row['task'];
            }

            return $formated_array;
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