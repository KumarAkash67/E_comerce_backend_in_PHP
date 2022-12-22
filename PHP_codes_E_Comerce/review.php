<?php
    header('Content-Type:application/json');
    $conn = mysqli_connect("sql102.epizy.com", "epiz_29834564", "T3QA4lOI3h", "epiz_29834564_user");

    function getdata($page,$conn,$page_limit,$limit,$email_id)
    {
              $arr = array();
              global $limit,$page_limit,$conn,$email_id;
              //print($page_limit);
              
              if($page<=$page_limit)
              {
              $start = ($page - 1)* $limit;
              $sql1 = "SELECT U.first_name,U.last_name,R.review,R.rating FROM Review as R ,User as U WHERE  U.email = R.id AND R.id= '$email_id' limit $start,$limit";
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
              // print(json_encode(['data'=>$arr]));
              }
             }
             else
             {
                 $a = array();
                 return $a;
             }
            // else
            // {
            //     echo("ERROR:".json_encode(['message'=>'']));
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

                                $email_id = $_POST['email'];
                                //$page = $_POST['pagetoken'];
                                $sql = "SELECT review,rating FROM Review WHERE id= '$email_id'";
                                $result = $conn->query($sql);
                                $start = 0;
                                $limit = 4;    
                                $total = $result->num_rows;
                                $page_limit = ceil($total/$limit);
                                // print($total);
                                //print($result->num_rows);
                                 if(isset($_POST['pagetoken']))
                                {
                                    $pagetoken = $_POST['pagetoken'];
                                    
                                    if($pagetoken==$page_limit)
                                    {
                            
                                        $arr = getdata($page,$conn,$page_limit,$limit,$email_id);
                                        print(json_encode(['data'=>$arr,'pagetoken'=>null]));
                                    }
                                    else if($pagetoken<$page_limit)
                                    {
                                        $arr = getdata($page,$conn,$page_limit,$limit,$email_id);
                                        $pagetoken = $pagetoken +1;
                                        if($arr==null)
                                        {
                                            print(json_encode(['data'=>[],'pagetoken'=>$pagetoken]));
                                        }
                                        else
                                        {
                                           print(json_encode(['data'=>$arr,'pagetoken'=>$pagetoken]));
                                        }
                                    }
                                    else
                                    {
                                        print(json_encode(['data'=>$arr,'pagetoken'=>null]));
                                    }
                                }
                                else
                                {
                                    $arr = getdata(1,$conn,$page_limit,$limit,$email_id);
                                    if($arr==null)
                                    {
                                       print(json_encode(['data'=>$arr,'pagetoken'=>null])); 
                                    }
                                    else
                                    {
                                      print(json_encode(['data'=>$arr,'pagetoken'=>2])); 
                                    }
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