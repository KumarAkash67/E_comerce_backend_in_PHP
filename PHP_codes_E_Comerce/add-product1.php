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

                                        if(isset($_POST['name'])){

                                                // $email = $_GET['email'];
                                                $arr10 = $_POST['url'];

                                                $name=$_POST['name'];
                                                $offer = $_POST['offer'];
                                                $description = $_POST['description'];
                                                $price = $_POST['price'];
                                                $available_units = $_POST['available_units'];
                                                $minimum_selling_quantity = $_POST['minimum_selling_quantity'];
                                                $unit_of_selling = $_POST['unit_of_selling'];
                                                $increment_size = $_POST['increment_size'];
                                                $email = $_POST['email'];

                                                $product_id = uniqid();
                                                // $address = $address_id;

                                                // for Address

                                                $sqlProduct = " INSERT INTO `Product` (`product_id`, `name`, `offer`, `description`, `price`, `available_units`, `minimum_selling_quantity`, `unit_of_selling`, `increment_size`, `email`, `display_photo_url`) VALUES ('$product_id', '$name', '$offer', '$description', '$price', '$available_units', '$minimum_selling_quantity', '$unit_of_selling', '$increment_size', '$email', '$arr10[0]'); ";

                                                $result = mysqli_query($conn, $sqlProduct);
                                                echo mysqli_error($conn);

                                                                                              
                                                $sql = "select * from Product where product_id = '$product_id' ";
                                                $result = mysqli_query($conn,$sql);
                                                $count = mysqli_num_rows($result);

                                                // to check if Product is entered

                                                if($count>0)
                                                {

                                                        // collor

                                                        if(isset($_POST['color']))                                                       
                                                        {
                                                                $arr = $_POST['colorName'];
                                                                $brr = $_POST['color'];

                                                                //$obj->col=$arr;
                                                                //echo json_encode($obj);

                                                                $i=0;

                                                                while($arr[$i]!=null){

                                                                        $Name = $arr[$i]; 
                                                                        $color = $brr[$i]; 

                                                                        $color_id = uniqid();
                                                                
                                                                        $sqlColor = "INSERT INTO `Color` (`color_id`, `Name`, `color`, `product_id`) VALUES ('$color_id', '$Name', '$color', '$product_id')" ;  
                                                                        $result = mysqli_query($conn, $sqlColor);
                                                                        echo mysqli_error($conn);


                                                                    $i++;

                                                                }
                                                        }

                                                        // photo
                                                        if(isset($_POST['url']))
                                                        {
                                                            $arr = $_POST['url'];

                                                            $i=0;

                                                            while($arr[$i]!=null){

                                                            $url = $arr[$i];                                                                                                                      
                                                            $photo_id = uniqid();

                                                            $sqlPhotos = "INSERT INTO `Photos` (`photo_id`, `url`, `product_id`) VALUES ('$photo_id', '$url', '$product_id')";
                                                            $result = mysqli_query($conn, $sqlPhotos);
                                                            echo mysqli_error($conn);

                                                            

                                                            $i++;

                                                            }

                                                        
                                                        }

                                                        // size
                                                        if(isset($_POST['value']))
                                                        {
                                                            $arr = $_POST['value'];

                                                            $i=0;

                                                            while($arr[$i]!=null){

                                                                    $value = $arr[$i]; 
                                                                    $size_id = uniqid();
                                                            

                                                            $sqlSize = "INSERT INTO `Size` (`size_id`, `value`, `product_id`) VALUES ('$size_id', '$value', '$product_id')";
                                                            $result = mysqli_query($conn, $sqlSize);
                                                            echo mysqli_error($conn);

                                                            $i++;

                                                            }

                                                        }

                                                            $obj->data=$product_id;
                                                            $json = json_encode($obj);
                                                            echo $json;

                                                        }
                                                        else{

                                                                $obj->message="Product not entered";
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