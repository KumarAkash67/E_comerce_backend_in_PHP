<?php
    header('Content-Type:application/json');
    $conn = mysqli_connect("sql102.epizy.com", "epiz_29834564", "T3QA4lOI3h", "epiz_29834564_user");

    function getdata($page,$conn,$page_limit,$limit,$string,$service_city)
            {
                    global $conn,$page_limit,$limit,$string;
                    $arr = array();
                    echo "\n";
                    //echo $city;
                    // z@a ommoo@b , 
                    // echo $page_limit;
                    // $city = "Pindwara";

                    //print($pa/);
                    if($page<=$page_limit)
                    {
                        // echo "Hello";
                        // echo $string;
                    $start = ($page - 1)* $limit;
                    
                    $sql1 = "SELECT S.email,S.timing_start,S.timing_end,S.banner_url,A.street_lane,S.shop_name,S.avg_rating,S.category
                             FROM Seller as S,Address as A
                             WHERE S.email=A.email AND S.shop_name LIKE '%$string%' AND S.service_city='$service_city' AND A.flag_seller = '1'                           
                             limit $start, $limit ";
                             

                    // $sql1 = "SELECT * FROM Seller";

                    $result1 = $conn->query($sql1);
                   
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
                    else
                    {
                        return $arr;
                    }
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

                if($count2>0){
                        $checkRow = mysqli_fetch_assoc($checkRes);
                        if($checkRow['status']==1){
                            
                            if($checkRow['hit_count']>$checkRow['hit_limit']){

                                echo json_encode(['status'=>'false','data'=>'API hit limit exceeded']);
                                die();
                            }else
                            {
                                        $string = $_POST['string'];
                                        $service_city = $_POST['service_city'];
                                        
                                        $sql = "SELECT email FROM Seller WHERE shop_name LIKE '$string%'AND service_city='$service_city'";

                                        $result = $conn->query($sql);
                                        $start = 0;
                                        $limit = 4;    
                                        $total = $result->num_rows;
                                        //echo "Hello".$total;
                                        //print($total);

                                        $page_limit = ceil($total/$limit);  
                                        
                                        if(isset($_POST['string']))
                                        {
                                            if(isset($_POST['pagetoken']))
                                            {
                                                
                                                $pagetoken = $_POST['pagetoken'];
                                                //print($pagetoken);
                                                
                                                if($pagetoken==$page_limit)
                                                {
                                                    $arr = getdata($pagetoken,$conn,$page_limit,$limit,$string, $service_city);
                                                    print(json_encode(['data'=>$arr,'pagetoken'=>null]));
                                                    //echo "1 Hello";
                                                }
                                                else if($pagetoken<$page_limit)
                                                {
                                                    
                                                    $arr = getdata($pagetoken,$conn,$page_limit,$limit,$string, $service_city);
                                                    $pagetoken = $pagetoken + 1;
                                                    print(json_encode(['data'=>$arr,'pagetoken'=>$pagetoken]));
                                                    echo "2 Hello";
                                                }
                                                else
                                                {

                                                    print('{"data":[],"pagetoken":null}');
                                                    //echo "3 Hello";
                                                }
                                            }
                                            else
                                            {
                                               // echo "Hello";
                                                global $conn,$page_limit,$limit,$string;
                                               // echo $city;
                                                $arr = getdata(1,$conn,$page_limit,$limit,$string, $service_city);
                                                print(json_encode(['data'=>$arr,'pagetoken'=>2]));
                                            
                                            }
                                        }
                                        else
                                        {
                                            echo("ERROR:".json_encode(['message'=>'string is missing ']));
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

                $obj->message="TOKEN key not entered";
                                                    $json = json_encode($obj);
                                                    echo "ERROR:".$json;
            }
    }
?>