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

                if($count2>0){
                        $checkRow = mysqli_fetch_assoc($checkRes);
                        if($checkRow['status']==1){
                            
                            if($checkRow['hit_count']>$checkRow['hit_limit']){

                                echo json_encode(['status'=>'false','data'=>'API hit limit exceeded']);
                                die();
                            }else{

                                        if(isset($_POST['email'])){

                                                $payment_id = $_POST['payment_id'];
                                                $payment_mode = $_POST['payment_mode'];
                                                $amount = $_POST['amount'];
                                                $order_id = $_POST['order_id'];
                                                $email = $_POST['email'];
                                                $date_and_time = $_POST['date_and_time'];

                                                
                                                $sql = "INSERT INTO `Payment` (`payment_id`, `payment_mode`, `amount`, `order_id`, `email`, `date_and_time`) VALUES ('$payment_id', '$payment_mode', '$amount', '$order_id', '$email', '$date_and_time');";
                                                
                                                $result = $conn->query($sql);
                                                echo mysqli_error($conn);

                                                $sql = "UPDATE `Orders` SET `payment_status` = '1', `payment_id` = '$payment_id' WHERE `Orders`.`order_id` = '$order_id';";
                                                $result = $conn->query($sql);
                                                echo mysqli_error($conn);

                                                if($result== true)
                                                {
                                                    print(json_encode(['message'=>'Payment Entered successfully']));
                                                }
                                                else
                                                {
                                                    print("ERROR:".json_encode(['message'=>'Error has occured']));
                                                }
                                        }

                                         else{

                                            $obj->message="USER DATA not entered";
                                                    $json = json_encode($obj);
                                                    echo "ERROR:".$json;

                                         }

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