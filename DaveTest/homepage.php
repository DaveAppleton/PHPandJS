<?php

    require_once("dbinfo.php");

    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') '
                . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare('select * from listing where listingTime > NOW() limit 7');
    $stmt->execute();

    $count = 0;
    $result = $stmt->get_result();

    $response['status'] = "success";
    $response['header'] = [] ;
    $response['highlight'] = [];

    while ($row = mysqli_fetch_assoc($result)) {
        if ($count < 3) {
            $response['header'][] = $row;
        } else if ($count < 7) {
            $response['highlight'][] = $row;
        } else {
            break;
        }
        $count++;
    }

    echo json_encode($response);


?>
