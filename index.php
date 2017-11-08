<?php
    require './connection.php';


    $db = new DB_Connection();

    $connection = $db->get_connection();
    mysqli_set_charset($connection,"utf8");

    $query = "select mota from product_detail limit 0, 50";
    $result = mysqli_query($connection,$query);
    $count = 0;
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $url = $row["mota"];
            print  html_entity_decode($url);
        }
    }
?>