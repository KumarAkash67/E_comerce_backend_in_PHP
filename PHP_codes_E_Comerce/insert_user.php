<?php

$conn = mysqli_connect("sql102.epizy.com", "epiz_29834564", "T3QA4lOI3h", "epiz_29834564_user");

if ($conn->connect_error) {
    die("Connection failure: ". $conn->connect_error);
} 

else{

    //$contact = '999';
    //$password = '455';

    $contact = $_GET["contact"];
    $password = $_GET["password"];

    //echo "Succuss buddy  ";
    //echo nl2br("\r\n");
    echo nl2br("\r\n");

        $sql = "INSERT INTO user (contact,password) VALUES ('$contact','$password')";
        $result = mysqli_query($conn,$sql); 

        if($result){
            
           // echo "Succuss buddy  ";
            echo nl2br("\r\n");

            $sql1 = "SELECT * FROM user WHERE contact='$contact'";
            $result1 = mysqli_query($conn,$sql1);

            while ($row = mysqli_fetch_array($result1)) {

                echo $row['contact'];
                echo "\n";
                echo $row['password'];
                echo nl2br("\r\n");
            }
        }
        
        else{
            echo "Error sorry buddy";
        }
}

?>