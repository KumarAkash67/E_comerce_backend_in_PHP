<?php
    header('Content-Type:application/json');
    $conn = mysqli_connect("sql102.epizy.com", "epiz_29834564", "T3QA4lOI3h", "epiz_29834564_user");

    if ($conn->connect_error) {
        die("Connection failure: ". $conn->connect_error);
    } 
    else{

        if(isset($_GET['key'])){
            
                $key=mysqli_real_escape_string($conn,$_GET['key']);

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

                                        if(isset($_GET['email'])){

                                                $email = $_GET['email'];

                                                $shop_name=$_GET['shop_name'];
                                                $registration_date = $_GET['reg_date'];
                                                $timing_start = $_GET['start_timing'];
                                                $timing_end = $_GET['end_timing'];
                                                $banner_url=$_GET['banner_url'];
                                                $gst_no=$_GET['gst_no'];
                                                $service_city = $_GET['city'];
                                                $category = $_GET['category'];

                                                $pincode = $_GET['pinCode'];
                                                $state = $_GET['state'];
                                                $country = $_GET['country'];
                                                $street_lane = $_GET['street'];
                                                $flag_seller = $_GET['seller_flag'];
                                                $phone_no = $_GET['phone'];
                                                $latitude = $_GET['lat'];
                                                $longitude = $_GET['lng'];

                                                $address_id = uniqid();
                                                $address = $address_id;

                                                // for Address

                                                $sqlAddress = "INSERT INTO `Address` (`address_id`, `pinode`, `city`, `state`, `country`, `street_lane`, `latitude`, `longitude`, `phone_no`, `flag_seller`, `email`) VALUES ('$address_id', '$pinode', '$service_city', '$state', '$country', '$street_lane', '$latitude', '$longitude', '$phone_no', b'$flag_seller', '$email') ";

                                                $result = mysqli_query($conn,$sqlAddress);
                                                echo mysqli_error($conn);

                                                                                              
                                                $sql = "select * from Address where address_id = '$address_id' ";
                                                $result = mysqli_query($conn,$sql);
                                                $count = mysqli_num_rows($result);

                                                // to check if Address is entered

                                                if($count>0){
                                                             
                                                                $sql = "select * from Seller";
                                                                $result1 = mysqli_query($conn,$sql);
                                                                $count2 = mysqli_num_rows($result1);

                                                                // for Seller

                                                                $sqlSeller = " INSERT INTO `Seller` (`email`, `address`, `shop_name`, `registration_date`, `timing_start`, `timing_end`, `banner_url`, `gst_no`, `service_city`, `category`, `rating_id`, `review_id`, `fulfilled_orders`) VALUES ('$email', '$address', '$shop_name', '$registration_date', '$timing_start', '$timing_end', '$banner_url', '$gst_no', '$service_city', '$category', '0', '0', '0') ";

                                                                $result = mysqli_query($conn,$sqlSeller);
                                                                echo mysqli_error($conn);

                                                                $sql10 = "select * from Seller";
                                                                $result10 = mysqli_query($conn,$sql10);
                                                                $count3 = mysqli_num_rows($result10);

                                                                if($count3-$count2>0){

                                                                        $obj5->message="Seller Registered";

                                                                        $sql4 = " SELECT * FROM Address where address_id = '$address'";
                                                                        
                                                                        $result4 = mysqli_query($conn,$sql4);
                                                                        while($row=mysqli_fetch_assoc($result4)){
                                                                            $arr4[]=$row;
                                                                        }

                                                                        $obj5->address=$arr4[0];

                                                                        $sql5 = " SELECT * FROM Seller where email = '$email'";
                                                                        
                                                                        $result5 = mysqli_query($conn,$sql5);
                                                                        while($row=mysqli_fetch_assoc($result5)){
                                                                            $arr5[]=$row;
                                                                        }

                                                                        $obj5->seller=$arr5[0];
                                                                        echo json_encode($obj5);

                                                                }else{
                                                                    
                                                                    $obj->message="Account already exists";
                                                                    $json = json_encode($obj);
                                                                    echo "ERROR:".$json;

                                                                    $sql = "DELETE FROM `Address` WHERE `Address`.`address_id` = '$address_id' ";

                                                                    $obj->message="new created Address deleted";
                                                                    $json = json_encode($obj);
                                                                    echo "ERROR:".$json;

                                                                }

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