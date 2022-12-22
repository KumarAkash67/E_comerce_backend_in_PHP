<?php
    
    
     header('Content-Type:application/json');
     $conn = mysqli_connect("sql102.epizy.com", "epiz_29834564", "T3QA4lOI3h", "epiz_29834564_user");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failure: ". $conn->connect_error);
    } 
    else{

        if(isset($_POST['key']))
        {
            
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
                            }else
                            {
                                $seller_id = $_POST['sellerid'];

                                $sql = "SELECT Count(order_id) as number FROM Orders as O WHERE O.seller_id = '$seller_id'";
                                
                                $result = $conn->query($sql);
                                // mysqli_fetch_object($result) 
                                // THIS FUNCTION WILL RETURN SQL ROW AS OBJECT
                                // BECAUSE WE CAN ACCESS THE ATTRIBUTES EASILY
                                while($row = mysqli_fetch_object($result))
                                {
                                   $a[] = $row; 
                                }

                                $sql2 = "SELECT Sum(amount) as amount FROM Orders as O,Payment as P WHERE P.order_id=O.order_id AND O.seller_id='$seller_id'";

                                 $result2 = $conn->query($sql2);
                                  while($row1 = mysqli_fetch_object($result2))
                                    {
                                        $a1[] = $row1;
                                    }
                                // WE CAN ACCESS THE ATTRIBUTES OF OBJECT EASILY
                                // THEREFORE OBJECT IS IMPORTANT
                                $b = $a[0]->number;
                                $b1 = $a1[0]->amount;

                                $obj -> number = $b;
                                $obj  -> amount = $b1;
                               
                                if($result==true && $result2==true)
                                {
                                   print(json_encode($obj));
                                }
                                else
                                {
                                    print("ERROR".json_encode(['data'=>'Error has occured']));
                                }
                                
                                    $conn->close();
                                     

                            }
                        }

                }else{
                        $obj->message="TOKEN key invalid";
                                                    $json = json_encode($obj);
                                                    echo "ERROR:".$json;
                }      

            }
            else{
                // print('hwllo');

                $obj->message="TOKEN key not entered";
                                                    $json = json_encode($obj);
                                                    echo "ERROR:".$json;
            }
    }
?>