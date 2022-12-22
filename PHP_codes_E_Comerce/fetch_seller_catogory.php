<?php
    header('Content-Type:application/json');
    $conn = mysqli_connect("sql102.epizy.com", "epiz_29834564", "T3QA4lOI3h", "epiz_29834564_user");

    function getdata($page,$conn,$page_limit,$limit,$city,$catogery)
    {
                    global $conn,$page_limit,$limit,$city,$catogery;
                    $arr = array();
                    echo "\n";
                    //echo $city;
                    // z@a ommoo@b , 

                    //print($pa/);
                    if($page<=$page_limit)
                    {
                    $start = ($page - 1)* $limit;
                    $sql1 = "SELECT S.email,S.timing_start,S.timing_end,S.banner_url,A.street_lane,S.shop_name,S.avg_rating
                             FROM Seller as S,Address as A
                             WHERE A.email =  S.email AND A.flag_seller = '1' AND S.service_city = '$city' AND S.category = '$catogery'                             
                             limit $start, $limit";
                    $result1 = $conn->query($sql1);

                    echo mysqli_error($conn);
                    // $arr[] = [];
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
                    // else
                    // {
                    //     echo("ERROR:".json_encode(['message'=>'Soory out of range']));
                    // }
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
                                        $city = $_POST['city'];
                                        $catogery = $_POST['category'];
                                        $sql = "SELECT email FROM Seller WHERE service_city= '$city'";

                                        $result = $conn->query($sql);
                                        $start = 0;
                                        $limit = 4;    
                                        $total = $result->num_rows;
                                       // print($total);
                                        $page_limit = ceil($total/$limit);  
                                        
                                        if(isset($_POST['city']))
                                        {
                                            if(isset($_POST['category']))
                                            {
                                            if(isset($_POST['pagetoken']))
                                            {
                                                
                                                $pagetoken = $_POST['pagetoken'];
                                                $catogery = $_POST['category'];
                                                //print($pagetoken);
                                                
                                                if($pagetoken==$page_limit)
                                                {
                                                    $arr = getdata($pagetoken,$conn,$page_limit,$limit,$city,$catogery);
                                                    print(json_encode(['data'=>$arr,'pagetoken'=>null]));
                                                }
                                                else if($pagetoken<$page_limit)
                                                {
                                                    
                                                    $arr = getdata($pagetoken,$conn,$page_limit,$limit,$city,$catogery);
                                                    $pagetoken = $pagetoken + 1;
                                                    print(json_encode(['data'=>$arr,'pagetoken'=>$pagetoken]));
                                                }
                                                else
                                                {

                                                    print('{"data":[],"pagetoken":null}');
                                                }
                                            }

                                            else
                                            {
                                               // echo "Hello";
                                                global $conn,$page_limit,$limit,$city,$catogery;
                                               // echo $city;
                                                $arr = getdata(1,$conn,$page_limit,$limit,$city,$catogery);
                                                if(is_null($arr))
                                                {
                                                   print("ERROR:".json_encode(['message'=>'invalid city or null data']));
                                                }
                                                else
                                                {
                                                print(json_encode(['data'=>$arr,'pagetoken'=>2]));
                                                }
                                            
                                            }
                                           }
                                           else
                                           {

                                                print("ERROR".json_encode(['message'=>'category is not entered']));
                                           }
                                        }
                                        else
                                        {
                                            echo("ERROR:".json_encode(['message'=>'City is missing ']));
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