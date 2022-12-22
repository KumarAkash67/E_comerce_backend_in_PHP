<?php

     header('Content-Type:application/json');
    $conn = mysqli_connect("sql102.epizy.com", "epiz_29834564", "T3QA4lOI3h", "epiz_29834564_user");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failure: ". $conn->connect_error);
    } 
    else{

        // print('hwllo');

        if(isset($_POST['key']))
        {
            
                $key=mysqli_real_escape_string($conn,$_POST['key']);

                $sql2 = "SELECT * FROM api_token WHERE token='$key'";
                $checkRes=mysqli_query($conn,$sql2);
                $count2 = mysqli_num_rows($checkRes);

                if($count2>0)
                {
                        $checkRow = mysqli_fetch_assoc($checkRes);
                        if($checkRow['status']==1){
                            
                            if($checkRow['hit_count']>$checkRow['hit_limit']){

                                echo json_encode(['status'=>'false','data'=>'API hit limit exceeded']);
                                die();
                            }else
                            {
                                $email = $_POST['email'];
                                $sql = "SELECT * FROM Seller WHERE email = '$email'"; 
                                $result = $conn->query($sql);
                                // $arr = array();
                                 while($row = $result->fetch_assoc())
                                 {
                                   $arr[] = $row;
                                 }
    
                                    if($result==true)
                                    {
                                        print(json_encode($arr[0]));
                                    }
                                    else
                                    {
                                        print("ERROR:".json_encode(['message'=>'Some error']));
                                    }
                                    $conn->close();
                                
                            
                                                                   
                                        
                                        

                            }
                        }

                }else{
                        $obj->message="TOKEN key invalid";
                                                    $json = json_encode($obj);
                                                    echo "ERROR:".$json;
                }      

            }
            else{
            //        print('hwllo');

               $obj->message="TOKEN key not entered";
               $json = json_encode($obj);
               echo "ERROR:".$json;
            }
    }


    
    
?>