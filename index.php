<?php

const DATA = 'data.json';

function getAllTask() {
    if(file_exists(DATA)) {
        return json_decode(file_get_contents(DATA), true);
    } else {
        file_put_contents(DATA, json_encode([]));
    }
}

function storeTask($datas) {
    file_put_contents(DATA, json_encode($datas, JSON_PRETTY_PRINT));
}

function getTasks($datas) {
    if(!empty($datas)) {
        foreach($datas as $data) {
            echo json_encode($data);
        }
    }
}


function addNewTask(&$datas) {

    echo "Enter description: ";
    $desc = trim(fgets(STDIN));

    if(empty($desc)) {
        echo "Desc must not be empty";
        return;
    }

    $datas[] = [
        "id" => uniqid(),
        "desc" => $desc,
        "status" => "pending",
        "created_at" => date('Y-m-d H:i:s')
    ];
}

function setTaskCompleted(&$datas) {
    echo "enter id: ";
    $id= trim(fgets(STDIN));

    foreach($datas as &$data) {
        if($data['id'] === $id) {
            $data['status'] = 'completed';
            echo "task completed successfully";
            return;
        }
    }

    echo "task not found";
}


function removeTask(&$datas) {
    echo "enter id: ";
    $id= trim(fgets(STDIN));

    foreach($datas as $key => $data){
        if($data['id'] === $id) {
            unset($data[$key]);
            $datas = array_values($datas);
            storeTask($datas);
            echo "removed successfully";
            return;
        }
    }

    echo "task not found";

}


$datas = getAllTask();

while (true) {

    $category = trim(fgets(STDIN)); // enter the numbers here

    // view all task
    if($category == 1) {
        getTasks($datas);
    }

    // add new task
    if($category == 2) {
        addNewTask($datas);
        storeTask($datas);
    }

    // set task to completed
    if($category == 3) {
        setTaskCompleted($datas);
        storeTask($datas);
    }

    // delete task
    if($category == 4) {
        removeTask($datas);
        storeTask($datas);
    }

    // stop the script
    if($category == 5) {
        echo "done";
        exit;
    }
}