<?php
    header('Content-Type:application/json');
    $conn = mysqli_connect("sql102.epizy.com", "epiz_29834564", "T3QA4lOI3h", "epiz_29834564_user");

    if ($conn->connect_error) {
        die("Connection failure: ". $conn->connect_error);
    } 
    else{

        $sql = "select * from Payment ";

        $result4 = mysqli_query($conn,$sql);

        while($row=mysqli_fetch_assoc($result4)){
            $arr4[]=$row;
        }

        //$obj5->address=$arr4[0];

        echo json_encode($arr4[0]);

            //  $car=$_GET['cars'];
            //  $obj->bike=$car[0];

            // $i=0;
            // echo $i;
            // while($car[$i]!=null){
            //  echo $car[$i];
            //  echo "\n";
            //     $i++;
            // }


            // echo "Hello".json_encode($obj);
       
    }
?>