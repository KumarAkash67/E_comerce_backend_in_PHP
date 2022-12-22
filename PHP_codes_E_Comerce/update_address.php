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
                                                $phone = $_GET['Phone'];
                                                $city = $_GET['city'];
                                                $state = $_GET['state'];
                                                $country = $_GET['country'];
                                                $address_id = $_GET['add_id'];
                                                $pin = $_GET['pin'];
                                                $street = $_GET['street'];
                                                $latitude = $_GET['latitude'];
                                                $longitude = $_GET['longitude'];

                                                // for Address

                                                 $sqlAddress = "UPDATE Address SET phone_no='$phone',pincode='$pin',city='$city',state='$state',country='$country',street_lane='$street',latitude='$latitude',longitude='$longitude' WHERE email = '$email' AND address_id = '$address_id' ";

                                                $result = mysqli_query($conn, $sqlAddress);
                                                echo mysqli_error($conn);

                                                $obj->message="Address Updated";
                                                            $obj->data=$addressid;
                                                            $json = json_encode($obj);
                                                            echo $json;

                                                                                              
                                                // $sql = "select * from Address where address_id = '$address_id' ";
                                                // $result = mysqli_query($conn,$sql);
                                                // $count = mysqli_num_rows($result);

                                                // to check if Address is entered

                                                // if($count>0){
                                                             
                                                //             $obj->message="Address Entered";
                                                //             $obj->data=$address_id;
                                                //             $json = json_encode($obj);
                                                //             echo $json;
            

                                                // }
                                                // // if Address is not entered
                                                // else{

                                                //         $obj->message="Address not Entered";
                                                //         $json = json_encode($obj);
                                                //         echo "ERROR:".$json;

                                                // }


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
