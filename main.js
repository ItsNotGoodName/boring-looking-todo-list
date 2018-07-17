var todoInput = document.getElementById('TODO-TextInput');
var todoList = document.getElementById('TODO-List');
var todoJSON = {};

function httpGetAsync(theUrl, callback) // https://stackoverflow.com/questions/247483/http-get-request-in-javascript
{
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
            callback(xmlHttp.responseText);
    }
    xmlHttp.open("GET", theUrl, true); // true for asynchronous 
    xmlHttp.send(null);
}

function httpPostAsync(theUrl, callback,data) // https://stackoverflow.com/questions/6396101/pure-javascript-send-post-data-without-a-form
{
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            callback();
        }
    }
    xhr.open("POST", theUrl, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(data);
}

function sendEntry(string){
    httpPostAsync('todo_add.php', queryServer,'task='+string);
}

function deleteEntry(id){
    httpPostAsync('todo_delete.php',queryServer, 'id='+id );
}

// Adds string to the todo list
function addEntry(id, string){
    todoJSON[id] = string;

    var listItem = document.createElement('li');
    
    listItem.setAttribute("id", id);// sets id
    listItem.setAttribute('onclick', 'deleteEntry(this.id)');

    listItem.innerText = string;
    todoList.appendChild(listItem);
}
// Removes all todos that are displayed
function clearEntries(){
    while (todoList.firstChild) {
        todoList.removeChild(todoList.firstChild);
    }
}

function removeEntry(id){
    var entry = document.getElementById(id);
    entry.remove();
}

function queryServer(){
    httpGetAsync('todo_list.php', receiveServerData)
}

function receiveServerData(data){
    // Adds new entry that show up in new data
    var jsonData = JSON.parse(data);
    for(var id in jsonData){
        if(todoJSON[id] == undefined)
           addEntry(id, jsonData[id]);
    }
    // Removes the entry that do not show up in new data
    for(var id in todoJSON){
        if(jsonData[id] == undefined){
            removeEntry(id);
            delete todoJSON[id];
        }
    }
}

function clearEntry(){
    httpPostAsync('todo_clear.php',queryServer, '' );
}

todoInput.addEventListener("keyup",(event) =>{
    if(event.keyCode == 13){
        sendEntry(todoInput.value);
        todoInput.value = '';
    }
});

document.getElementById("TODO-ButtonClear").setAttribute('onclick', 'clearEntry()');

setInterval(queryServer, 5000);
queryServer();