<?php
    header('Content-Type:application/json');
    $conn = mysqli_connect("sql102.epizy.com", "epiz_29834564", "T3QA4lOI3h", "epiz_29834564_user");

    if ($conn->connect_error) {
        die("Connection failure: ". $conn->connect_error);
    } 
    else{
        if(isset($_GET['key'])){

                $key=mysqli_real_escape_string($conn,$_GET['key']);
                echo $key;
                echo "\n";

                $sql2 = "SELECT * FROM api_token WHERE token='$key'";
                $checkRes=mysqli_query($conn,$sql2);
                $count2 = mysqli_num_rows($checkRes);
                echo "\n";

                if($count2>0){
                        $checkRow = mysqli_fetch_assoc($checkRes);
                        if($checkRow['status']==1){
                            
                            if($checkRow['hit_count']>$checkRow['hit_limit']){

                                echo json_encode(['status'=>'false','data'=>'API hit limit exceeded']);
                                die();
                            }else{                                      
                                        $sql1 = "SELECT * FROM user";
                                        $result1 = mysqli_query($conn,$sql1);

                                        while ($row = mysqli_fetch_array($result1)) {

                                            echo $row['contact'];
                                            echo "\t";
                                            echo $row['password'];
                                            echo "\n";
                                        }

                                mysqli_query($conn,"update api_token set hit_count=hit_count+1 where token='$key'");
                            }
                        }

                        $contact = $_GET["contact"];
                        $password = $_GET["password"];

                        $sql = "INSERT INTO user (contact,password) VALUES ('$contact','$password')";
                        $result = mysqli_query($conn,$sql);

                        $sql = "SELECT * FROM user";
                        $result = mysqli_query($conn,$sql); 
                        $count = mysqli_num_rows($result);

                        if($count>0){
                            while($row=mysqli_fetch_assoc($result)){
                                $arr[]=$row;
                            }
                            echo "\n";
                            echo json_encode(['status'=>'true','data'=>$arr,'result'=>'found']);
                        
                        }else{
                            echo json_encode(['status'=>'true','data'=>'No data found','result'=>'not']);
                        
                        }

                }else{
                        echo json_encode(['status'=>'false','data'=>'API key deactivated']);
                }      

            }
            else{

                echo json_encode(['status'=>'false','data'=>'API not entered']);
            }
    }
?>