<?php
    
    header('Content-Type:application/json');
    $conn = mysqli_connect("sql102.epizy.com", "epiz_29834564", "T3QA4lOI3h", "epiz_29834564_user");
    // Check connection
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }
    $email_user = $_POST['email_user'];
    $email_seller = $_POST['email_seller'];
    $sql = "INSERT INTO Favourite(email_User,email_Seller) VALUES('$email_user','$email_seller')";
    $result = $conn->query($sql);
    //$sql = "SELECT Order_id,address_id,deleverystatuc,tran_id,date,paymentstatuc,user_id FROM Orders Where user_id = '$user_id'";
    if($result==true)
    {
    print(json_encode(['data'=>'Insert successfully']));
    }
    else
    {
        print("ERROR".json_encode(['message'=>'Error has occured']));
    }
?>