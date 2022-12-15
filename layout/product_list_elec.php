<!DOCTYPE html>
<?php 
    session_start(); 
    include('../php/db.php');
    include('../php/productrent.php'); 
?>
<html>

<head>
    <title>Rental-Of-school-supplies</title>
    <link rel="stylesheet" href="../css/product_list.css" type="text/css">
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
        <a href="main.php"><img src="../src/logo.PNG" alt="logo" height="120px"></a>
        <span class="title">학생회 <span>물품대여</span></span>
    </div>
    <div class="sub_title">
        <ul>
            <li><a href="#">sign in / sign up</a></li>
            <li><a href="#">my page</a></li>
        </ul>
    </div>

    <nav class="navbar">
        <ul>
            <li><a href="product_list_All.php">물품 목록</a></li>
            <li><a href="product_req.php">물품 신청</a></li>
            <li><a href="location.html">찾아오시는 길</a></li>
            <li><a href="team_intro.html">팀 소개</a></li>
        </ul>
    </nav>

    <div class="container">
        <nav class="navbar2">
            <ul>
                <li><a href="product_list_All.php">전체</a></li>
                <li><a href="product_list_Daily.php">생필품</a></li>
                <li><a href="product_list_elec.php" style="color: #4568DC;">전자기기</a></li>
                <li><a href="product_list_health.php">운동기구</a></li>
                <li><a href="product_list_stationery.php">문구</a></li>
            </ul>
        </nav>    
    </div>

    <section>
        <div class="container">
        <?php
            $CID = 3;
            $category_cnt = $db->query("select CID, COUNT(PID) as 해당물품수 from product where CID = $CID group by CID;");
            $cnt_result = $category_cnt->fetch_assoc();
            
            $select_query = $db->query("select PID from product where CID = $CID order by pid limit 1;") or die($db->error());
            $result = $select_query->fetch_assoc();
            $check_pid = $result['PID'];
            $product_cnt = 1;

            echo "<h4 class='product_count'>해당 물품 ".$cnt_result['해당물품수']."개</h4>";
            echo "<div class='row'>";?>
            <?php while(true): // product 반복문 

                $select_query = $db->query("select * from product where PID = $check_pid order by pid desc limit 1;") or die($db->error());
                $result = $select_query->fetch_assoc();
                $avail_query = $db->query("select Left_Quantity as 남은수량 from product where pid = $check_pid") or die($db->error());
                $availability = $avail_query->fetch_assoc();

                echo "<div class='product col-md-4 col-sm-4'>
                      <img class='product-img' src=".$result['Image_Path']." alt=".$result['P_Name']." style='width: 300px; height:200px;'>
                      <p class='product-name'>".$result['P_Name']."</p>
                      <p class='product-count'>(전체 개수: ".$result['Total_Quantity']." / 남은 수량: ".$result['Left_Quantity'].")</p>
                      <p class='product-info'>".$result['Content']."</p>"; ?>

                <?php if ($availability['남은수량'] == 0): ?>
                <form action="../php/productrent.php" method="post">
                <input type="hidden" name="check_pid" value="<?php echo $check_pid?>">
                <button class='btn-reserve' type='submit' name='reserve'>예약하기</button>
                </form> 
    
                <?php else: ?>
                <form action="../php/productrent.php" method="post">
                <input type="hidden" name="check_pid" value="<?php echo $check_pid?>">
                <button class='btn-rent' type='submit' name='rent'>대여하기</button>
                </form> 
                <?php endif ?>
                
                <?php echo "</div>"; // product div 닫음
                
                $check_pid++;
                if($result['PID'] != NULL) $product_cnt++;
                if ($product_cnt > $cnt_result['해당물품수']) break; ?>
                
            <?php endwhile ?>
                </div>
            </div>
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