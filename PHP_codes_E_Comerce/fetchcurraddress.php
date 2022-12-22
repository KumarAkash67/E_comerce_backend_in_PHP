<?php
    
    $servername = "127.0.0.1";
    $username = "root";
    $password = "Sachin@9413";
    $dbname = "market";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }
    $email = $_POST['email'];
    $sql = "SELECT A.pincode,A.city,A.state,A.country,street_lane,phone_no FROM Address as A,Seller as S WHERE A.flag_seller = '1' AND A.address_id = S.address AND email = '$email'";
    $result = $conn -> query($sql);
    $i=0;
    $arr[] = [];
    if($result->num_rows > 0 )
    { 
      print(json_encode(['data'=>$arr]));
    }
    else
    {
        print("ERROR".json_encode(['message'=>'Please add address']));
    }
?>