<?php
    header('Content-Type:application/json');
    $conn = mysqli_connect("sql102.epizy.com", "epiz_29834564", "T3QA4lOI3h", "epiz_29834564_user");

    if ($conn->connect_error) {
        die("Connection failure: ". $conn->connect_error);
    } 
    else{
        if(isset($_POST['key'])){
            
                $key=mysqli_real_escape_string($conn,$_POST['key']);
                // echo $key;
                // echo "\n";

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
                                    //    echo "hello";
                                    //     echo "\n";
                                        if(isset($_POST['email']) && isset($_POST['password'])){

                                            // echo "hello";
                                            //  echo "\n";

                                                $email = $_POST['email'];
                                                $first_name=$_POST['first_name'];
                                                $last_name = $_POST['last_name'];
                                                $gender = $_POST['gender'];
                                                $password = $_POST['password'];
                                                $contact_no=$_POST['contact_no'];

                                                // echo $email;
                                                // echo "\t";                                           
                                                // echo $first_name;
                                                // echo "\t";
                                                // echo $last_name;
                                                // echo "\t";
                                                // echo $gender;
                                                // echo "\t";
                                                // echo $curr_address;
                                                // echo "\t";
                                                // echo $flag_seller;
                                                // echo "\t";
                                                // echo $password;
                                                // echo "\t";
                                                // echo $contact_no;
                                                // echo "\n";

                                                // $curr_address="NULL";
                                                // $flag_seller = 0;
                                                
                                                $sql = "select * from User";
                                                $result1 = mysqli_query($conn,$sql);
                                                $count2 = mysqli_num_rows($result1);

                                                // $sql1 = "INSERT INTO User (email,first_name,last_name,gender,curr_address,flag_seller,password,contact_no) VALUES ('$email','$first_name','$last_name','$gender','$curr_address',$flag_seller,'$password','$contact_no')";

                                                $sql1 = "INSERT INTO User (email,first_name,last_name,gender,curr_address,flag_seller,password,contact_no) VALUES ('$email','$first_name','$last_name','$gender','2',0,'$password','$contact_no')";

                                                $result = mysqli_query($conn,$sql1);

                                                $result2 = mysqli_query($conn,$sql);
                                                $count3 = mysqli_num_rows($result2);

                                                // echo "\n";
                                                // echo $count2;
                                                // echo "\t";
                                                // echo $count3;
                                                // echo "\n";

                                                if($count3-$count2>0){

                                                        $obj->message="Account created";
                                                        $json = json_encode($obj);
                                                        echo $json;

                                                        // while($row=mysqli_fetch_assoc($result2)){
                                                        //     $arr[]=$row;
                                                        // }
                                                        // // echo "\n";
                                                        // echo json_encode($arr);

                                                }else{
                                                    
                                                    $obj->message="Account already exists";
                                                    $json = json_encode($obj);
                                                    echo "ERROR:".$json;

                                                }
                                        }

                                         else{

                                            $obj->message="USER DATA not entered";
                                                    $json = json_encode($obj);
                                                    echo "ERROR:".$json;

                                         }

                                        // $sql1 = "SELECT * FROM user";
                                        // $result1 = mysqli_query($conn,$sql1);
                                        
                                        // echo "\n";

                                        // while ($row = mysqli_fetch_array($result1)) {

                                        //     echo $row['email'];
                                        //     echo "\t";
                                        //     echo $row['password'];
                                        //     echo "\n";
                                        // }

                               // mysqli_query($conn,"update api_token set hit_count=hit_count+1 where token='$key'");
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