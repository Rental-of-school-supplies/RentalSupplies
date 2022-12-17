<?php

session_start();
include('db.php');

$category= 0;
$product= 0;
$student = $_SESSION['studentID'];

$delay_query = $db->query("SELECT Overdue_status AS 연체여부, Overdue_End_Date AS 종료일 FROM user WHERE SID = $student");
$delay = $delay_query->fetch_assoc();

date_default_timezone_set('Asia/Seoul');
$time = date('Y-m-d H:i:s', time());

if(isset($_POST['reserve'])){
    $product = $_POST['check_pid'];
    $category_query = $db->query("SELECT PID, CID, P_Name FROM product WHERE PID = $product");
    $result = $category_query->fetch_assoc();
    $product = $result['PID'];

    if ($time > $delay['종료일']){
        $delay['연체여부'] = "0";
        $delay['종료일'] = NULL;
        $db->query("
            update user
            set Overdue_status = '0', Overdue_End_Date = NULL
            where SID = ".$student.";") or die($db->error);
    }
        

    if($delay['연체여부'] == "0") {
        $db->query("INSERT INTO reservation (SID, Reserve_Date, CID, PID) VALUES($student, '$time', $category, $product)") or die($db->error);
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
    $product = $_POST['check_pid'];
    $category_query = $db->query("SELECT PID, CID, P_Name FROM product WHERE PID = ".$product."");
    $result = $category_query->fetch_assoc();
    $category = $result['CID'];

    if ($time > $delay['종료일']){
        $delay['연체여부'] = "0";
        $delay['종료일'] = NULL;
        $db->query("
            update user
            set Overdue_status = '0', Overdue_End_Date = NULL
            where SID = ".$student.";") or die($db->error);
    }

    $duplicate_query = $db->query("SELECT PID, SID, Out_Date FROM rental WHERE PID=$product AND SID = $student;");
    $duplicate = $duplicate_query->fetch_assoc();

    if($delay['연체여부'] == "0") {
        if($duplicate){
            echo 
                "<script>
                    window.alert('이미 대여 중인 물품입니다. \\n대여일: ".$duplicate['Out_Date']."');
                    location.replace('../layout/product_list_All.php');
                </script>";
        }
        else {
            $db->query("INSERT INTO rental (Out_Date, Return_Date, SID, CID, PID) 
                        VALUES('$time', DATE_ADD('$time', INTERVAL 7 DAY), $student, $category, $product)") or die($db->error);
            $db->query("UPDATE product SET Left_Quantity = Left_Quantity - 1 WHERE PID = $product");
            echo 
                "<script>
                    window.alert('".$catagory_query['P_Name']." 대여 성공하셨습니다.');
                    location.replace('../layout/product_list_All.php');
                </script>";
        }
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