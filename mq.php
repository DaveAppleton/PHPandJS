<?php
/*
* Change the value of $password if you have set a password on the root userid
* Change NULL to port number to use DBMS other than the default using port 3306
*
*/
    $user = 'root';
    $password = ''; //To be completed if you have set a password to root
    $database = 'mydb'; //To be completed to connect to a database. The database must exist.
    $port = NULL; //Default must be NULL to use default port
    $mysqli = new mysqli('127.0.0.1', $user, $password, $database, $port);

    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') '
                . $mysqli->connect_error);
    }

    $data = json_decode(file_get_contents('php://input'),true);

    if ($data['category'] != "None") {
        $stmt = $mysqli->prepare('select * from listing where categoryId = ?');
        $stmt->execute([$data['category']]);
    } else {
        $stmt = $mysqli->prepare('select * from listing');
        $stmt->execute();
    }

    $result = $stmt->get_result();
    while ($row = mysqli_fetch_assoc($result)) {
        $response['data'][] = $row;
    }  
    
    if (empty($response['data'])) {
        $response['status'] = 'fail';
    } else {
        $response['status'] = 'success';
    }
    

echo json_encode($response);
$mysqli->close();

?>
