<?php
	header('Content-Type:application/json');
    $conn = mysqli_connect("sql102.epizy.com", "epiz_29834564", "T3QA4lOI3h", "epiz_29834564_user");
    // Check connection
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }
    //$email_user = $_POST['email_user'];
    //$page = $_POST['pagetoken'];
    if(isset($_POST['selleremail']))
    {
        // for seller avgrating updation
        $sellerid = $_POST['selleremail'];
        $sql = "UPDATE Seller SET avg_rating = 
        (SELECT AVG(rating) as rat
          FROM Review as R
          WHERE R.parent_id = '$sellerid')";
        $result = $conn->query($sql);
        if($result==true)
        {
            print(json_encode(['message'=>'Done']));
        }
        else
        {
            print("ERROR".json_encode(['message'=>'Error']));
        }
   
    }
    else if(isset($_POST['proid']))
    {
        // for product avg rating updating 
        $proid = $_POST['proid'];
        $sql = "UPDATE Product SET avg_rating = 
        (SELECT AVG(rating) as rat
          FROM Review as R
          WHERE R.parent_id = '$proid')";
        $result = $conn->query($sql);
        if($result==true)
        {
            print(json_encode(['message'=>'Done']));
        }
        else
        {
            print("ERROR".json_encode(['message'=>'Error']));
        } 
    }
    $conn->close();
?>