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

                if($count2>0)
                {
                        $checkRow = mysqli_fetch_assoc($checkRes);
                        if($checkRow['status']==1)
                        {
                            
                            if($checkRow['hit_count']>$checkRow['hit_limit'])
                            {

                                echo json_encode(['status'=>'false','data'=>'API hit limit exceeded']);
                                die();
                            }else
                            {
                                  $city = $_POST['city'];
                                  $sql = "SELECT * FROM Advertisement WHERE city ='$city'";
                                  $arr = array();
                                  $result = $conn->query($sql);

                                  if($result->num_rows >0)
                                  {
                                      $i = 0;
                                       while($row = $result->fetch_assoc())
                                       {
                                           $arr[$i++] = $row;

                                       }
                                       print(json_encode(['Advertise'=>$arr]));
                                  }
                                  else
                                  {
                                      print('{"Advertise"=>[]}');

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

                $obj->message="TOKEN key not entered";
                                                    $json = json_encode($obj);
                                                    echo "ERROR:".$json;
            }
    }


    
    
?>