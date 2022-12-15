<?php

include('db.php');

$category= 0;
$product= 0;
date_default_timezone_set('Asia/Seoul');
$time = date('Y-m-d H:i:s', time());

if(isset($_POST['reserve'])){
    $check_pid = $_POST['check_pid'];
    $category_query = $db->query("SELECT PID, CID, P_Name FROM product WHERE PID = $check_pid");
    $result = $category_query->fetch_assoc();
    $category = $result['CID'];
    $product = $result['PID'];

	$db->query("INSERT INTO reservation (SID, Reserve_Date, CID, PID) VALUES(2020039002, '$time', $category, $product)") or die($db->error);

	echo 
        "<script>
            window.alert('".$catagory_query['P_Name']." 예약 성공하셨습니다.');
            location.replace('../layout/product_list_All.php');
        </script>";
}

if(isset($_POST['rent'])){
    $check_pid = $_POST['check_pid'];
    $category_query = $db->query("SELECT PID, CID, P_Name FROM product WHERE PID = ".$check_pid."");
    $result = $category_query->fetch_assoc();
    $category = $result['CID'];
    $product = $result['PID'];

	$db->query("INSERT INTO rental (Out_Date, Return_Date, SID, CID, PID) 
                VALUES('$time', DATE_ADD('$time', INTERVAL 7 DAY), 2020039002, $category, $product)") or die($db->error);

	echo 
        "<script>
            window.alert('".$catagory_query['P_Name']." 대여 성공하셨습니다.');
            location.replace('../layout/product_list_All.php');
        </script>";
}
?>