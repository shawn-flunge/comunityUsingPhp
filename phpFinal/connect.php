<?php
    $hostName = "localhost";
    $userName = "user2019";
    $userPassword = "php";
    $dbName = "CSE2";

    $conn = mysql_connect($hostName, $userName, $userPassword);

    if(!$conn){
        echo("데이터베이스에 연결 할 수 없습니다.");
        exit;
    }

    $db = mysql_select_db($dbName);
    if(!$db){
        echo("데이터베이스를 선택할 수 없습니다.");
        exit;
    }

?>