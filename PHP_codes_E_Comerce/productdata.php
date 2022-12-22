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

                                        if(isset($_POST['productid'])){

                                                    $proid = $_POST['productid'];
                                                    $sql = "SELECT *
                                                            FROM Product as pr
                                                            WHERE pr.product_id = '$proid' limit 1";                                                                                                                                    
                                                    $result = $conn->query($sql);   
                                                    // print('hello');
                                                    //print($result->num_rows);     
                                                    // $a = array();
                                                    // $j = 0;
                                                    while($row = mysqli_fetch_object($result))
                                                    {
                                                        $a[] = $row;
                                                        // $a[$j] = $row;
                                                        // $j = $j+1;
                                                    }   
                                                    //sql for url for all url;

                                                    $ob = $a[0];
                                                    $sql1 = "SELECT P.url FROM Photos as P WHERE P.product_id = '$proid'";
                                                    $result1 = $conn->query($sql1);
                                                    // $arr = array();
                                                    // $i = 0;
                                                    while($row = mysqli_fetch_assoc($result1))
                                                    {
                                                        $arr[] = $row;
                                                    }   
                                                    
                                                    $sql3 = "SELECT Name,color FROM Color WHERE product_id = '$proid'";
                                                    $result3 = $conn->query($sql3);
                                                    while($row = mysqli_fetch_assoc($result3))
                                                    {
                                                        $arr1[] = $row;
                                                    } 
                                                    // $ob->color = $arr1;
                                                    $sql4 = "SELECT value FROM Size WHERE product_id = '$proid'";
                                                    $result4 = $conn->query($sql4);
                                                    while($row = mysqli_fetch_assoc($result4))
                                                    {
                                                        $arr2[] = $row;
                                                    } 
                                                    // $ob->size = $arr2;
                                                    // $ob->photos = $arr;
                                                    if($result==true)
                                                    {
                                                        print(json_encode(['product'=>$a[0],'color'=>$arr1,'size'=>$arr2,'photos'=>$arr]));
                                                    }
                                                    else
                                                    {
                                                        print("ERROR:".json_encode(['message'=>'Error has occured']));
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