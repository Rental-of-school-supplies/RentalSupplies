
<!DOCTYPE html>
<?php 
    session_start(); 
    include('../php/db.php');    
?>
<html>

<head>
    <title>Rental-Of-school-supplies</title>
    <link rel="stylesheet" href="../css/product_list_M.css" type="text/css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nanum+Gothic&display=swap');
    </style>
    <script src="../js/main.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="../jquery-fadethis-master/libs/jquery/jquery.js"></script>
    <script src="../jquery-fadethis-master/dist/jquery.fadethis.min.js"></script>

</head>

<body>
    <p class="main">충북대학교<span class="main_dep"> 소프트웨어학부</span></p>
    <div class="logo">
        <img src="../src/logo.PNG" alt="logo" height="120px">
        <span class="title">학생회 <span>물품대여</span></span>
    </div>
    <div class="sub_title">
        <ul>
            <?php 
                if($_SESSION['isSuccessLogin']){ 
                    echo '<li><a href="../php/logout.php">log out</a></li> 
                            <li><a href="./mypage.php">my page</a></li>';
                }else{
                    echo '<li><a href="./singIn_Up.php">sign in / sign up</a></li>';
                }  
            ?>         
        </ul>
    </div>

    <nav class="navbar">
        <ul>
            <li><a href="#">물품 목록</a></li>
            <li><a href="#">물품 신청</a></li>
            <li><a href="#">물품 관리</a></li>
            <li><a href="#">팀 소개</a></li>
        </ul>
    </nav>

    <!-- 
        1. GET 요청으로 데이터 조회하기
        2. 반납 / 대여 버튼을 누르면, POST 요청으로 데이터 보내기 
                + table 위치도 변경되어야 함 

     -->
    <section>
        <div class="container">
            <?php 
                $resultRental = $db->query("
                select rental.rentalid as 대여id, product.pid as 물품id, product.p_name as 대여물품, rental.sid as 빌린학생, rental.return_date as 반납일  
                from manager, manages, product, rental 
                where manager.mid = manages.mid 
                and manages.cid = product.cid and manages.pid = product.pid 
                and product.cid = rental.cid and product.pid = rental.pid
                order by product.pid, rental.return_date;
                    ") or die($db->error);

                // $resultReserve = $db->query("
                //     select product.p_name as 대기물품, reservation.sid as 대기학생, reservation.reserve_date as 대기일  
                //     from manager, manages, product, reservation 
                //     where manager.mid = manages.mid 
                //     and manages.cid = product.cid and manages.pid = product.pid 
                //     and product.cid = reservation.cid and product.pid = reservation.pid;
                //     ") or die($db->error);

                $productIndex = 0;
                $rowIndex = 0;
                $pastProductId = 0;
                $currentProductId = 0;
                $isJump = false;
                while($rowRental=$resultRental->fetch_assoc()):
                // while($rowReserve=$resultReserve->fetch_assoc()):
            ?>


            <?php
                if($rowIndex != 0){  //$index: 물품 분류하기 위해서 사용(조회되는 table의 row에서 어디부터 어디까지가 A물품이고, B물품인지 등을 구분하고자)  
                    $pastProductId = $currentProductId;
                }
                $currentProductId = $rowRental['물품id']; 
            ?>

            <?php if($pastProductId == $currentProductId ): ?> <!-- 대여물품이 같은 경우 -->
                <tr>
                    <td><?php echo $rowRental['빌린학생'] ?></td>
                    <td><?php echo $rowRental['반납일'] ?></td>
                    <td><button class="btn-rent" type="submit">반납</button></td>
                </tr>
            
            <?php else:  // 대여물품이 달라지는 경우 => 1. product_List 추가로, 즉 다음 행으로 이동하는 경우 2. 현재 행에 존재하는 경우 
                if($rowIndex != 0){
                    echo "</tbody></table></div>";  // <div class="product">의 짝꿍
                    

                    // Case 1.
                    if($productIndex%3 == 2){
                        $isJump = true;
                        echo '</div><div class="product_list">';
                    }else{   // Case2.
                        $isJump = false;
                    }
                    $productIndex++;
                }else{  // $rowIndex == 0인 경우 (첫 행인 경우)
                    echo '<div class="product_list">';    
                }
            ?>
                    <!-- reserve-table 관련 코드 -->
                <div class="product">
                    <?php $productName = $rowRental['대여물품']; ?>
                    <h3><?php echo $productName ?></h3>
                    <table class="rental-table">
                        <tbody>
                            <tr>
                                <td><?php echo $rowRental['빌린학생'] ?></td>
                                <td><?php echo $rowRental['반납일'] ?></td>
                                <td><button class="btn-rent" type="submit">반납</button></td>
                            </tr>

            <?php ?>    
            <?php endif; ?>
            <?php $rowIndex++; ?>
            <?php endwhile; ?>
            <?php echo "</tbody></table></div></div>"; ?> <!-- 맨 마지막 <div class="product_list"> 짝꿍 -->
            
        </div>
    </section>

    <!-- footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <h6>(Inc)3Idiots</h6>
                    <p class="text-justify">
                        Business registration number: 120-00-12345<br>
                        hosting services: 3Idiots Corporation | Student Council Rental Business Report Number:
                        1234-cbnu-56789<br>
                        28644 1, Chungdae-ro, Seowon-gu, Cheongju-si, Chungcheongbuk-do (S4-1, College of electrical and
                        computer engineering BID.3)<br>
                        Customer Service: 1, Chungdae-ro, Seowon-gu, Cheongju-si, Chungcheongbuk-do (S4-1, College of
                        electrical and computer engineering BID.3)</p>
                </div>
            </div>
            <hr>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-6 col-xs-12">
                    <p class="copyright-text">Copyright &copy; 2022 All Rights Reserved by.
                    </p>
                </div>
            </div>
        </div>
    </footer>
</body>