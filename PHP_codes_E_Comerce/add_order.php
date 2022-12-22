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

                                        if(isset($_POST['address_id'])){

                                            $order_id = uniqid();
                                            $date_and_time = $_POST['date_and_time'];
                                            $total_products = $_POST['total_products'];
                                            $address_id = $_POST['address_id'];
                                            $buyer = $_POST['email'];
                                            $seller_id = $_POST['seller_id'];
                                            
                                            $sql = "SELECT * FROM `Orders`";
                                            $result1 = mysqli_query($conn,$sql);
                                            $count2 = mysqli_num_rows($result1);

                                            $sql1 = "INSERT INTO `Orders` (`order_id`, `delivery_status`, `date_and_time`, `payment_status`, 
                                            `total_products`, `payment_id`, `address_id`, `buyer`, `seller_id`) VALUES 
                                            ('$order_id', '0', '$date_and_time', '0', '$total_products', NULL, '$address_id', '$buyer', '$seller_id');";

                                            $result = mysqli_query($conn,$sql1);
                                            echo mysqli_error($conn);

                                            $result2 = mysqli_query($conn,$sql);
                                            $count3 = mysqli_num_rows($result2);

                                            if($count3-$count2>0){

                                                   // $email = $_POST['email'];
                                                    $product_id_arr = $_POST['pro_id'];
                                                    $color_arr = $_POST['color'];
                                                    $size_arr = $_POST['size'];
                                                    $quantity_arr = $_POST['quantity'];

                                                    $i=0;

                                                    while($product_id_arr[$i]!=null){

                                                                $product_id = $product_id_arr[$i];
                                                                $color = $color_arr[$i];
                                                                $size = $size_arr[$i];
                                                                $quantity = $quantity_arr[$i];
                                                        
                                                                $sql6 = "INSERT INTO `Order_product` (`quantity`, `order_id`, `product_id`, `email`, `size`, `colour`) VALUES ('$quantity', '$order_id', '$product_id', '$buyer', '$size', '$color');";

                                                                $result = mysqli_query($conn, $sql6);
                                                                echo mysqli_error($conn);

                                                            $i++;

                                                        }

                                                    if($result== true)
                                                    {
                                                        $obj->message="Order Added";
                                                        $obj->data=$order_id;
                                                        $json = json_encode($obj);
                                                        echo $json;
                                                    }
                                                    else
                                                    {
                                                        print("ERROR:".json_encode(['message'=>'Error has occured']));
                                                    }


                                            }else{
                                                
                                                $obj->message="Order not entered";
                                                $json = json_encode($obj);
                                                echo "ERROR:".$json;

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