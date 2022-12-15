<?php

include('db.php');

$category= 0;
$product= 0;
$student = 2020039002;

$delay_query = $db->query("SELECT Overdue_status AS 연체여부, Overdue_End_Date AS 종료일 FROM user WHERE SID = $student");
$delay = $delay_query->fetch_assoc();

date_default_timezone_set('Asia/Seoul');
$time = date('Y-m-d H:i:s', time());

if(isset($_POST['reserve'])){
    $check_pid = $_POST['check_pid'];
    $category_query = $db->query("SELECT PID, CID, P_Name FROM product WHERE PID = $check_pid");
    $result = $category_query->fetch_assoc();
    $category = $result['CID'];
    $product = $result['PID'];

    if($delay['연체여부'] == "0") {
        $db->query("INSERT INTO reservation (SID, Reserve_Date, CID, PID) VALUES($student, '$time', $category, $product)") or die($db->error());
        echo 
            "<script>
                window.alert('".$catagory_query['P_Name']." 예약 성공하셨습니다.');
                location.replace('../layout/product_list_All.php');
            </script>";
    }
    else {
        echo 
            "<script>
                window.alert('연체 기간이 아직 종료되지 않았습니다. \\n종료일: ".$delay['종료일']."');
                location.replace('../layout/product_list_All.php');
            </script>";
    }	
}

if(isset($_POST['rent'])){
    $check_pid = $_POST['check_pid'];
    $category_query = $db->query("SELECT PID, CID, P_Name FROM product WHERE PID = ".$check_pid."");
    $result = $category_query->fetch_assoc();
    $category = $result['CID'];
    $product = $result['PID'];

    if($delay['연체여부'] == "0") {
        $db->query("INSERT INTO rental (Out_Date, Return_Date, SID, CID, PID) 
                    VALUES('$time', DATE_ADD('$time', INTERVAL 7 DAY), $student, $category, $product)") or die($db->error());
        $db->query("UPDATE product SET Left_Quantity = Left_Quantity - 1 WHERE PID = $check_pid ");
        echo 
            "<script>
                window.alert('".$catagory_query['P_Name']." 대여 성공하셨습니다.');
                location.replace('../layout/product_list_All.php');
            </script>";
    }
    else {
        echo 
            "<script>
                window.alert('연체 기간이 아직 종료되지 않았습니다. \\n종료일: ".$delay['종료일']."');
                location.replace('../layout/product_list_All.php');
            </script>";
    }
}
?>