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

                                        if(isset($_POST['pinCode'])){

                                                $email = $_POST['email'];
                                                $pincode = $_POST['pinCode'];
                                                $city = $_POST['city'];
                                                $state = $_POST['state'];
                                                $country = $_POST['country'];
                                                $street_lane = $_POST['street'];
                                                //$flag_seller = $_POST['seller_flag'];
                                                $phone_no = $_POST['phone'];
                                                $latitude = $_POST['lat'];
                                                $longitude = $_POST['lng'];

                                                $address_id = uniqid();
                                                $address = $address_id;

                                                // for Address

                                                $sqlAddress = "INSERT INTO `Address` (`address_id`, `pincode`, `city`, `state`, `country`, `street_lane`, `latitude`, `longitude`, `phone_no`, `flag_seller`, `email`) VALUES ('$address_id', '$pincode', '$city', '$state', '$country', '$street_lane', '$latitude', '$longitude', '$phone_no', 0, '$email') ";

                                                $result = mysqli_query($conn,$sqlAddress);
                                                echo mysqli_error($conn);

                                                                                              
                                                $sql = "select * from Address where address_id = '$address_id' ";
                                                $result = mysqli_query($conn,$sql);
                                                $count = mysqli_num_rows($result);

                                                // to check if Address is entered

                                                if($count>0){

                                                            $addressid = $address_id;                                                           
                                                            // $email = $_POST['email'];
                                                            $sql = "UPDATE User SET curr_address = '$addressid' WHERE email = '$email'";

                                                            $result = mysqli_query($conn,$sql);
                                                            echo mysqli_error($conn);
                                                             
                                                            $obj->message="Address Entered";
                                                            $obj->data=$address_id;
                                                            $json = json_encode($obj);
                                                            echo $json;
            

                                                }
                                                // if Address is not entered
                                                else{

                                                        $obj->message="Address not Entered";
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



