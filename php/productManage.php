<?php

include("db.php");

$category = 1;
$product_ID = '';
$product_name = '';
$product_content = '';
$image_path = '';
$quantity = 0;
$confirm_pname = '';


if(isset($_POST['save'])){
	$product_name = $_POST['title'];
	$product_content = $_POST['explanation'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];
    $uploaded_file_name_tmp = $_FILES['myfile']['tmp_name'];
    $uploaded_file_name = $_FILES['myfile']['name'];
    $upload_folder = "../src/";
    $image_path = $upload_folder . $uploaded_file_name;
    move_uploaded_file( $uploaded_file_name_tmp, $image_path );

    $confirm_pname = "SELECT P_Name FROM product WHERE P_Name = '$product_name'";
    $order = mysqli_query($db, $confirm_pname); //중복 확인

    if(mysqli_num_rows($order) > 0){
        echo 
            "<script>
                window.alert('해당 물품이 이미 존재합니다');
                history.go(-1);
            </script>";
    } else {
        $req_query = "INSERT INTO product (CID, P_Name, Content, Image_Path, Total_Quantity, Left_Quantity) 
                  VALUES($category,'$product_name', '$product_content', '$image_path', $quantity, $quantity)";
        $result = mysqli_query($db, $req_query);
        if($result){
            echo 
                "<script>
                    window.alert('물품 신청에 성공했습니다');
                    location.replace('../layout/product_manage_M.php');
                </script>";
        }else{
            echo 
                "<script>
                    window.alert('물품 신청에 실패했습니다');
                    location.replace('../layout/product_manage_M.php');
                </script>";
        }
    }
}

if(isset($_GET['deleteCID']) && isset($_GET['deletePID'])){
    $deleteCID=$_GET['deleteCID'];
    $deletePID=$_GET['deletePID'];
    $db->query("DELETE FROM product WHERE pid=$deletePID")or die($db->error);

    header("location:../layout/product_manage_M.php");
}

 ?>
