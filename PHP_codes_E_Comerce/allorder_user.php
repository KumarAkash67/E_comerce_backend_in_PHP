<?php
    header('Content-Type:application/json');
    $conn = mysqli_connect("sql102.epizy.com", "epiz_29834564", "T3QA4lOI3h", "epiz_29834564_user");

    function getdata($page,$conn,$page_limit,$limit,$email)
     {

        global $conn,$page_limit,$limit,$email;
        $arr = array();
        //   print($email);
        // print($page_limit);
                    // echo "\n";
                    //echo $city;
                    // z@a ommoo@b , 
                    // print($page);
                    //print($pa/);
                    // print($page_limit);
                    if($page<=$page_limit)
                    {
                    $start = ($page - 1)* $limit;
                    $sql1 = "SELECT O.order_id,O.date_and_time,O.delivery_status,O.payment_status,P.amount FROM Payment as P,Orders as O WHERE P.order_id=O.order_id AND O.buyer='$email'";
                    $result1 = $conn->query($sql1);
                    
                    echo mysqli_error($conn);
                    $arr[] = [];
                    $i = 0;
                    if($result1->num_rows > 0)
                    {
                    while($row = $result1->fetch_assoc())
                    {                        
                    $arr[$i] = $row;
                    $i++;
                    }
                        return $arr;
                    // 
                    }
                    }

                    return $arr;
        

     }

    if ($conn->connect_error) {
        die("Connection failure: ". $conn->connect_error);
    } 
    else{

        if(isset($_POST['key'])){
            
                $key=mysqli_real_escape_string($conn,$_POST['key']);

                $sql2 = "SELECT * FROM api_token WHERE token='$key'";
                $checkRes=mysqli_query($conn,$sql2);
                $count2 = mysqli_num_rows($checkRes);

                //echo "hi".$key;

                if($count2>0){
                        $checkRow = mysqli_fetch_assoc($checkRes);
                        if($checkRow['status']==1){
                            
                            if($checkRow['hit_count']>$checkRow['hit_limit']){

                                echo json_encode(['status'=>'false','data'=>'API hit limit exceeded']);
                                die();
                            }else{

                                                $email = $_POST['email'];
                                                //$user_id = $_GET['user_id'];
                                                $sql = "SELECT order_id FROM Orders as O WHERE O.buyer = '$email'";
                                                $result = $conn->query($sql);
                                                $start = 0;
                                                $limit = 3;
                                                $result = $conn->query($sql);
                                                $total = $result->num_rows;

                                                $page_limit = ceil($total/$limit);
                                                // print($total);
                                                
                                                // else
                                                // {
                                                //     print("ERROR".json_encode(['message'=>'Error has occured']));
                                                // }
                                                if(isset($_POST['pagetoken']))
                                                {
                                                    $pagetoken = $_POST['pagetoken'];
                                                    //print($pagetoken);
                                                    
                                                    if($pagetoken==$page_limit)
                                                    {
                                                        $arr = getdata($pagetoken,$conn,$page_limit,$limit,$email);
                                                        print(json_encode(['totalorders'=>$total,'data'=>$arr,'pagetoken'=>null]));
                                                    }
                                                    else if($pagetoken<$page_limit)
                                                    {
                                                        
                                                        $arr = getdata($pagetoken,$conn,$page_limit,$limit,$email);
                                                        $pagetoken = $pagetoken + 1;
                                                        print(json_encode(['totalorders'=>$total,'data'=>$arr,'pagetoken'=>$pagetoken]));
                                                    }
                                                    else
                                                    {

                                                        print('{"totalorders":0,"data":[],"pagetoken":null}');
                                                    }
                                                }
                                                else
                                                {
                                                    global $conn,$page_limit,$limit,$email;
                                                        // print($email);
                                                    // echo $city;
                                                        $arr = getdata(1,$conn,$page_limit,$limit,$email);
                                                        
                                                        print(json_encode(['totalorders'=>$total,'data'=>$arr,'pagetoken'=>2]));
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
