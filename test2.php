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

    $stmt = $mysqli->prepare('select id from users where email = ?');
    $stmt->execute([$data['email']]);
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $response['errors'][] = ['code'=>'1','message' => 'Email already registered'];
    }  
    $stmt = $mysqli->prepare('select id from users where userID = ?');
    $stmt->execute([$data['user_id']]);
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $response['errors'][] = ['code' =>'5','message' => 'UserID already registered'];
    } 
    if (empty($response['errors'])) {
        $response = ['status' => 'success'];
    }
    
    

echo json_encode($response);
$mysqli->close();

?>
