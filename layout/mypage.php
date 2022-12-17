<!DOCTYPE html>
<?php 
    session_start();
    include('../php/db.php');
    include('../php/productrent.php'); 
    
    if(!isset($_SESSION['isSuccessLogin'])){
        $_SESSION['isSuccessLogin'] = false;
    }

    $studentID = $_SESSION['studentID'];
?>
<html>

<head>
    <title>Rental-Of-school-supplies</title>
    <link rel="stylesheet" href="../css/mypage.css" type="text/css">
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
            <?php 
                if($_SESSION['isSuccessLogin']){ //로그인 성공시 -> 로그아웃 출현 
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
            <li><a href="product_list_All.php">물품 목록</a></li>
            <li><a href="product_req.php">물품 신청</a></li>
            <li><a href="location.html">찾아오시는 길</a></li>
            <li><a href="team_intro.html">팀 소개</a></li>
        </ul>
    </nav>

    <?php
    $record_cnt = 1;
    $result = $db->query("SELECT p.P_Name AS 물품명, r.Out_Date AS 대여일, r.Return_Date AS 반납기한
                          FROM product AS p, rental AS r 
                          WHERE SID = $studentID 
                          AND p.PID = r.PID
                          AND In_Date is NULL") or die($mysqli->error);

    $result_cnt = $db->query("SELECT COUNT(p.P_Name) AS 개수 
                              FROM product AS p, rental AS r 
                              WHERE p.PID = r.PID
                              AND In_Date is NULL
                              GROUP BY SID
                              Having SID = $studentID") or die($mysqli->error);
    $query = $result_cnt->fetch_assoc();
    ?>
    <section class="current_rental">
        <div class="container">
            <h3 class="table-name">현재 대여 중인 물품</h3>
            <h3 class="quantity"><?php echo $query['개수']?>개</h3>
            <table class="rental-table">
                <colgroup>
                    <col style="width: 5%;" span="1">
                </colgroup>
                <thead>
                    <tr>
                        <th></th>
                        <th>물품명</th>
                        <th>대여일</th>
                        <th>반납 기한</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()):?>
                    <tr>
                        <td><?php echo $record_cnt; $record_cnt++; ?></td>
                        <td><?php echo $row['물품명']; ?></td>
                        <td><?php echo $row['대여일']; ?></td>
                        <td><?php echo $row['반납기한']; ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>

    <?php
    $record_cnt = 1;
    $result = $db->query("SELECT p.P_Name AS 물품명, r.Out_Date AS 대여일, r.In_Date AS 반납일, r.Return_Date AS 반납기한
                          FROM product AS p, rental AS r 
                          WHERE SID = $studentID 
                          AND p.PID = r.PID
                          AND In_Date is NOT NULL") or die($mysqli->error);

    $result_cnt = $db->query("SELECT COUNT(p.P_Name) AS 개수 
                              FROM product AS p, rental AS r 
                              WHERE p.PID = r.PID
                              AND In_Date is NOT NULL
                              GROUP BY SID
                              Having SID = $studentID") or die($mysqli->error);
    $query = $result_cnt->fetch_assoc();
    ?>
    <section class="pre_rental">
        <div class="container">
            <h3 class="table-name">나의 물품 대여 내역</h3>
            <h3 class="quantity"><?php echo $query['개수']?>개</h3>
            <table class="rental-table">
                <colgroup>
                    <col style="width: 5%;" span="1">
                </colgroup>
                <thead>
                    <tr>
                        <th></th>
                        <th>물품명</th>
                        <th>대여일</th>
                        <th>반납일</th>
                        <th>연체 여부</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()):?>
                    <tr>
                        <td><?php echo $record_cnt; $record_cnt++; ?></td>
                        <td><?php echo $row['물품명']; ?></td>
                        <td><?php echo $row['대여일']; ?></td>
                        <td><?php echo $row['반납일']; ?></td>
                        <td>
                            <?php 
                            if($row['반납일'] > $row['반납기한']) echo '연체'; 
                            else echo '정상 반납'
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
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