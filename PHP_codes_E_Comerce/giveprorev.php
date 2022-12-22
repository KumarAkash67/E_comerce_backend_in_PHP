<?php
    
    header('Content-Type:application/json');
    $conn = mysqli_connect("sql102.epizy.com", "epiz_29834564", "T3QA4lOI3h", "epiz_29834564_user");
    // Check connection
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }
    $id = $_POST['id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];
    $parent = $_POST['parent'];
    $sql = "INSERT INTO Review(parent_id,rating,review,id) VALUES('$parent','$rating','$review','$id')";
    //$sql = "SELECT * FROM Review WHERE parent_id = 'bhavin121'";
    $result = $conn->query($sql);
    //$a = array();
    // print($result->num_rows);
    if($result==true)
    {
       print(json_encode(['message'=>'Successful']));
    }
    else
    {
       print("ERROR".json_encode(['message'=>'Error']));
    }

    

    
?>