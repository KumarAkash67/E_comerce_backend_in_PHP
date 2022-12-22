<?php

     header('Content-Type:application/json');
     $conn = mysqli_connect("sql102.epizy.com", "epiz_29834564", "T3QA4lOI3h", "epiz_29834564_user");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failure: ". $conn->connect_error);
    } 
    else{

        if(isset($_POST['key']))
        {
            
                $key=mysqli_real_escape_string($conn,$_POST['key']);

                $sql2 = "SELECT * FROM api_token WHERE token='$key'";
                $checkRes=mysqli_query($conn,$sql2);
                $count2 = mysqli_num_rows($checkRes);

                if($count2>0){
                        $checkRow = mysqli_fetch_assoc($checkRes);
                        if($checkRow['status']==1){
                            
                            if($checkRow['hit_count']>$checkRow['hit_limit']){

                                echo json_encode(['status'=>'false','data'=>'API hit limit exceeded']);
                                die();
                            }else
                            {
                                $email = $_POST['email'];
                                $shop_name = $_POST['shopname'];
                                $timestart = $_POST['timestart'];
                                $timeend = $_POST['timeend'];
                                $bannerurl = $_POST['bannerurl'];
                                $category = $_POST['category'];
                                $sql = "UPDATE Seller SET shop_name='$shop_name',timing_start='$timestart',timing_end='$timeend',banner_url='$bannerurl',category='$category'  WHERE email = '$email'";
                                $result = $conn->query($sql);
                                if($result==true)
                                {
                                    print(json_encode(['message'=>'Success']));
                                }
                                else
                                {
                                    print("ERROR:".json_encode(['message'=>'sorry error']));
                                }
                               
                                // shopname,timing,banneruril,catrgoty
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

                $obj->message="TOKEN key not entered";
                                                    $json = json_encode($obj);
                                                    echo "ERROR:".$json;
            }
    }


    
    
?>