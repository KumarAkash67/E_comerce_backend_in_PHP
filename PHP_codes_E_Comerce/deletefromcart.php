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

                                                $email = $_POST['email'];
                                                $product_id = $_POST['pro_id'];
                                                // $color = $_GET['color'];
                                                // $size = $_GET['size'];
                                                // $quan = $_GET['quantity'];

                                                // print($product_id);
                                                // $user_id = $_GET['user_id'];
                                                // $id = $_GET['id'];
                                                
                                                $sql = "DELETE FROM Cart WHERE email = '$email' AND product_id = '$product_id'";
                                                $result = $conn->query($sql);
                                                print($result->num_rows);
                                                //$sql = "INSERT INTO Cart(id,user_id) VALUES ('$id','$user_id')";
                                                if($result==true)
                                                {
                                                print(json_encode(['message'=>'Deleted successfully']));
                                                }
                                                else
                                                {
                                                    print("ERROR".json_encode(['message'=>'Error has occured']));
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