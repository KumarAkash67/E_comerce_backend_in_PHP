<?php

$conn = mysqli_connect("sql102.epizy.com", "epiz_29834564", "T3QA4lOI3h", "epiz_29834564_user");

if ($conn->connect_error) {
    die("Connection failure: ". $conn->connect_error);
} 

else{

    $contact = 123;
    $password = 322;

   // echo "Succuss buddy  ";

        $sql = "SELECT * FROM user";

        $result = mysqli_query($conn,$sql); 

        if($result){
            
            while ($row = mysqli_fetch_array($result)) {

                echo "\n";
                echo $row['contact'];
                echo nl2br("\r\n");
                echo $row['password'];
            }
        }
        
        else{
            echo "Error sorry buddy";
        }
}

?>