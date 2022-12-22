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

                                        if(isset($_GET['name'])){

                                                // $email = $_GET['email'];

                                                $name=$_GET['name'];
                                                $offer = $_GET['offer'];
                                                $description = $_GET['description'];
                                                $price = $_GET['price'];
                                                $available_units = $_GET['available_units'];
                                                $minimum_selling_quantity = $_GET['minimum_selling_quantity'];
                                                $unit_of_selling = $_GET['unit_of_selling'];
                                                $increment_size = $_GET['increment_size'];

                                                $product_id = uniqid();
                                                // $address = $address_id;

                                                // for Address

                                                $sqlProduct = " INSERT INTO `Product` (`product_id`, `name`, `offer`, `description`, `price`, `available_units`, `minimum_selling_quantity`, `unit_of_selling`, `increment_size`) VALUES ('$product_id', '$name', '$offer', '$description', '$price', '$available_units', '$minimum_selling_quantity', '$unit_of_selling', '$increment_size'); ";

                                                $result = mysqli_query($conn, $sqlProduct);
                                                echo mysqli_error($conn);

                                                                                              
                                                $sql = "select * from Product where product_id = '$product_id' ";
                                                $result = mysqli_query($conn,$sql);
                                                $count = mysqli_num_rows($result);

                                                // to check if Product is entered

                                                if($count>0){

                                                        // collor
                                                        $color_id = uniqid();
                                                        $Name = $_GET['colorName'];
                                                        $color = $_GET['color'];
                                                        //$product_id = $_GET['product_id'];

                                                        $sqlColor = "INSERT INTO `Color` (`color_id`, `Name`, `color`, `product_id`) VALUES ('$color_id', '$Name', '$color', '$product_id')" ;  
                                                        $result = mysqli_query($conn, $sqlColor);
                                                        echo mysqli_error($conn);

                                                        $sql1 = "select * from Color where color_id = '$color_id' ";
                                                        $result1 = mysqli_query($conn,$sql1);
                                                        $count1 = mysqli_num_rows($result1);

                                                        // to check if Color is entered
                                                        
                                                        if($count1>0){

                                                                // photo

                                                                
                                                                $photo_id = uniqid();
                                                                $url = $_GET['url'];
                                                                //$product_id = $_GET['product_id'];

                                                                $sqlPhotos = "INSERT INTO `Photos` (`photo_id`, `url`, `product_id`) VALUES ('$photo_id', '$url', '$product_id')";
                                                                $result = mysqli_query($conn, $sqlPhotos);
                                                                echo mysqli_error($conn);

                                                                $sql2 = "select * from Photos where photo_id = '$photo_id' ";
                                                                $result2 = mysqli_query($conn,$sql2);
                                                                $count2 = mysqli_num_rows($result2);

                                                                // to check if Photo is entered
                                                                
                                                                if($count2>0){

                                                                        // size
                                                                        $size_id = uniqid();
                                                                        $value = $_GET['value'];
                                                                        // $value = $_GET['value'];

                                                                         $sqlSize = "INSERT INTO `Size` (`size_id`, `value`, `product_id`) VALUES ('$size_id', '$value', '$product_id')";
                                                                         $result = mysqli_query($conn, $sqlSize);
                                                                         echo mysqli_error($conn);

                                                                         $sql3 = "select * from Size where size_id = '$size_id' ";
                                                                         $result3 = mysqli_query($conn,$sql3);
                                                                         $count3 = mysqli_num_rows($result3);
                                                                         

                                                                        // to check if Size is entered
                                                                        // Product entered successfuly

                                                                        if($count3>0){

                                                                            $obj->message="Product Entered";
                                                                            $json = json_encode($obj);
                                                                            echo $json;

                                                                        }else{

                                                                            $obj->message="Size Not Entered";
                                                                            $json = json_encode($obj);
                                                                            echo $json;

                                                                            $obj->message="Product Not Entered";
                                                                            $json = json_encode($obj);
                                                                            echo $json;

                                                                            // delete photos

                                                                            $sql = "DELETE FROM `Photos` WHERE `Photos`.`photo_id` = '$photo_id' ";

                                                                            $obj->message="new created Photos deleted";
                                                                            $json = json_encode($obj);
                                                                            echo "ERROR:".$json;

                                                                            // delete color

                                                                            $sql = "DELETE FROM `Color` WHERE `Color`.`color_id ` = '$color_id' ";

                                                                            $obj->message="new created Color deleted";
                                                                            $json = json_encode($obj);
                                                                            echo "ERROR:".$json;

                                                                            // delete Product

                                                                            $sql = "DELETE FROM `Product` WHERE `Product`.`product_id ` = '$product_id' ";

                                                                            $obj->message="new created Product deleted";
                                                                            $json = json_encode($obj);
                                                                            echo "ERROR:".$json;
                                                                        }

                                                                }else{

                                                                            $obj->message="Photo Not Entered";
                                                                            $json = json_encode($obj);
                                                                            echo $json;

                                                                            $obj->message="Product Not Entered";
                                                                            $json = json_encode($obj);

                                                                            // delete color

                                                                            $sql = "DELETE FROM `Color` WHERE `Color`.`color_id ` = '$color_id' ";

                                                                            $obj->message="new created Color deleted";
                                                                            $json = json_encode($obj);
                                                                            echo "ERROR:".$json;

                                                                            // delete Product

                                                                            $sql = "DELETE FROM `Product` WHERE `Product`.`product_id ` = '$product_id' ";

                                                                            $obj->message="new created Product deleted";
                                                                            $json = json_encode($obj);
                                                                            echo "ERROR:".$json;
                                                                }

                                                        }else{

                                                                $obj->message="Photo Not Entered";
                                                                $json = json_encode($obj);
                                                                echo $json;

                                                                $obj->message="Product Not Entered";
                                                                $json = json_encode($obj);

                                                                // delete Product

                                                                $sql = "DELETE FROM `Product` WHERE `Product`.`product_id ` = '$product_id' ";

                                                                $obj->message="new created Product deleted";
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