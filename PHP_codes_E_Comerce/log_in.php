
<?php
    header('Content-Type:application/json');
    $conn = mysqli_connect("sql102.epizy.com", "epiz_29834564", "T3QA4lOI3h", "epiz_29834564_user");

    if ($conn->connect_error) {
        die("Connection failure: ". $conn->connect_error);
    } 
    else{

        if(isset($_POST['key'])){
            
                $key=mysqli_real_escape_string($conn,$_POST['key']);

                $sql2 = "SELECT * FROM api_token WHERE token='$key'";
                $checkRes=mysqli_query($conn,$sql2);
                $count2 = mysqli_num_rows($checkRes);
                // echo "\n";

                if($count2>0){
                        $checkRow = mysqli_fetch_assoc($checkRes);
                        if($checkRow['status']==1){
                            
                            if($checkRow['hit_count']>$checkRow['hit_limit']){

                                echo json_encode(['status'=>'false','data'=>'API hit limit exceeded']);
                                die();
                            }else{

                                        if(isset($_POST['email']) && isset($_POST['password'])){

                                                $email = $_POST["email"];
                                                $password = $_POST["password"];

                                                $sql = "SELECT email, first_name, last_name, gender, curr_address, flag_seller, contact_no FROM User WHERE email='$email'AND password='$password'";
                                                
                                                // $sql = "SELECT * FROM User where password = '$password'";
                                                $result = mysqli_query($conn,$sql);
                                                $count3 = mysqli_num_rows($result);

                                                if($count3>0){

                                                        while($row=mysqli_fetch_object($result)){
                                                            $arr[]=$row;
                                                        }
                                                        // echo "\n";
                                                        $obj=$arr[0];

                                                        $sql = "SELECT * FROM `Address` WHERE email = '$email'";
                                                        $result1 = mysqli_query($conn,$sql);
                                                        while($row1=mysqli_fetch_assoc($result1)){
                                                            $arr1[]=$row1;
                                                        }

                                                        $obj->address=$arr1;

                                                        echo json_encode($obj);

                                                }else{
                                                    
                                                    $obj->message="Email or Password not matched";
                                                    $json = json_encode($obj);
                                                    echo "ERROR:".$json;

                                                }
                                        }

                                         else{
                                             echo "ERROR: Username/Password missing". myspli_connect_error();
                                         }


                                mysqli_query($conn,"update api_token set hit_count=hit_count+1 where token='$key'");
                            }
                        }

                }else{

                        $obj->message="Token key not matched";
                        $json = json_encode($obj);
                        echo $json;
                     
                }      

            }
            else{

                    $obj->message="Token not entered";
                    $json = json_encode($obj);
                    echo $json;

            }
    }
?>
