<?php
include('db.php');

$category= 0;
$product= 0;

if(isset($_POST['reserve'])){
    $category_query = $db->query("SELECT PID, CID, P_Name FROM product WHERE PID = ".$check_pid."");
    $result = $category_query->fetch_assoc();
    $category = $result['CID'];
    $product = $result['PID'];

	$db->query("INSERT INTO reservation (SID, Reserve_Date, CID, PID) 
                VALUES('$studentID', now(), '$category', '$product'") or die($db->error());

	echo 
        "<script>
            window.alert('".$catagory_query['P_Name']." 예약 성공하셨습니다.');
            location.replace('../layout/product_list_All.php');
        </script>";
}

if(isset($_POST['rent'])){
    $category_query = $db->query("SELECT PID, CID, P_Name FROM product WHERE PID = ".$check_pid."");
    $result = $category_query->fetch_assoc();
    $category = $result['CID'];
    $product = $result['PID'];

	$db->query("INSERT INTO rental (Out_Date, Return_Date, SID, CID, PID) 
                VALUES(now(), DATE_ADD(NOW(), INTERVAL 7 DAY), '$studentID', '$category', '$product'") or die($db->error());

	echo 
        "<script>
            window.alert('".$catagory_query['P_Name']." 대여 성공하셨습니다.');
            location.replace('../layout/product_list_All.php');
        </script>";
}
?>