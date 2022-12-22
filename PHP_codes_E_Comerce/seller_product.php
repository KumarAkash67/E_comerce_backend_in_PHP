<?php
    header('Content-Type:application/json');
    $conn = mysqli_connect("sql102.epizy.com", "epiz_29834564", "T3QA4lOI3h", "epiz_29834564_user");

    function getdata($page,$conn,$limit,$page_limit,$email)
    {
        
        global $page_limit,$limit,$conn,$email;
        if($page<=$page_limit)
        {
        $start = ($page-1)*$limit;
       
        $sql = "SELECT pr.name,pr.product_id,pr.price,pr.offer,pr.avg_rating,pr.display_photo_url,pr.minimum_selling_quantity 
        FROM Product as pr
        WHERE pr.email = '$email' LIMIT $start,$limit";
        $result = $conn->query($sql);
        //print($result->num_rows);
        $i=0;
        $arr[] = [];
        while($row=$result->fetch_assoc())
        {
          $arr[$i] = $row;
          $i++;
        } 
        return $arr;
        }
        else
        {
            $a = array();
            return $a;
        }
    } 

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
                                $email = $_POST['email'];
    
                                $start = 0;
                                $limit = 10;
                                $sql = "SELECT email FROM Product as P WHERE P.email = '$email'";
                                $result = $conn->query($sql);
                                $total = $result->num_rows;
                                
                                $page_limit = ceil($total/$limit);
                                //print($page_limit);
                                if(isset($_POST['pagetoken']))
                                {
                                    $page = $_POST['pagetoken'];
                                    if($page==$page_limit)
                                    {
                                        //global $page_limit,$page,$limit,$conn,$email;
                                        $arr = getdata($page,$conn,$limit,$page_limit,$email);
                                        //$page = $page+1;
                                        print(json_encode(['data'=>$arr,'pagetoken'=>null]));
                                    }
                                    else if($page<$page_limit)
                                    {
                                       // global $page_limit,$page,$limit,$conn,$email;
                                        $arr = getdata($page,$conn,$limit,$page_limit,$email);
                                        $page = $page+1;
                                        if($arr==null)
                                        {
                                            print(json_encode(['data'=>[],'pagetoken'=>$page]));
                                        }
                                        else
                                        {
                                           print(json_encode(['data'=>$arr,'pagetoken'=>$page]));
                                        }
                                    }
                                    else
                                    {
                                        print(json_encode(['data'=>[],'pagetoken'=>null]));
                                    }
                                }
                                else
                                {
                                    //global $page_limit,$page,$limit,$conn,$email;
                                    $arr = getdata(1,$conn,$limit,$page_limit,$email);
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