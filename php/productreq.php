<?php
session_start(); 
include('db.php');
// require_once('signup.php');

$student =  $_SESSION['studentID'];
$manager = 2020039063;
$product_name = '';
$product_content = '';
$confirm_pname = '';
$confirm_check = false;

if(isset($_POST['confirm'])){
    $product_name = $_POST['title'];
    $confirm_pname = "SELECT P_Name FROM product WHERE P_Name = '$product_name'";
    $order = mysqli_query($db, $confirm_pname); //db 접속, 명령을 입력해
    
    if(mysqli_num_rows($order) > 0){    // 가로들의 개수를 세줌
        echo 
            "<script>
                window.alert('해당 물품이 이미 존재합니다');
                history.go(-1);
            </script>";
    } else {
        echo 
            "<script>
                window.alert('물품 신청이 가능합니다');
                history.go(-1);
            </script>";
    }
}

if(isset($_POST['save'])){
	$product_name = $_POST['title'];
	$product_content = $_POST['content'];
    date_default_timezone_set('Asia/Seoul');
    $time = date('Y-m-d H:i:s', time());

    $req_query = "INSERT INTO requisition (Req_Pname, Req_Content, MID, SID, Request_Date) VALUES('$product_name','$product_content', $manager, 2020039001, '$time')";
    $result = mysqli_query($db, $req_query);

    if($result){
        echo 
            "<script>
                window.alert('물품 신청에 성공했습니다');
                location.replace('../layout/product_req.php');
            </script>";
    }else{
        echo 
            "<script>
                window.alert('물품 신청에 실패했습니다');
                location.replace('../layout/product_req.php');
            </script>";
    }
}
?>