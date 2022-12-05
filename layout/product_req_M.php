<!DOCTYPE html>
<html>

<head>
    <title>product_req_M</title>
    <link rel="stylesheet" href="../css/product_req_M.css" type="text/css">
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
    <?php session_start(); ?>
    <?php require_once '../php/process.php'; ?>
    <p class="main">충북대학교<span class="main_dep"> 소프트웨어학부</span></p>
    <div class="logo">
        <img src="../src/logo.PNG" alt="logo" height="120px">
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
            <li><a href="#">물품 목록</a></li>
            <li><a href="#">물품 신청</a></li>
            <li><a href="#">물품 관리</a></li>
            <li><a href="#">팀 소개</a></li>
        </ul>
    </nav>
    <?php
    $mysqli = new mysqli('localhost:3306', 'root', '010510', '3idiots') or die(mysqli_error($mysqli));
    $result = $mysqli->query("SELECT * FROM requestion") or die($mysqli->error);
    ?>
    <section class="product_req">
        <div class="container">
            <h3 class="table-name">물품 신청 내역</h3>
            <table class="rental-table">
                <colgroup>
                    <col style="width: 5%;" span="1">
                </colgroup>
                <thead>
                    <tr>
                        <th></th>
                        <th>물품명</th>
                        <th>신청 사유</th>
                        <th>신청자</th>
                        <th>신청일</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()):?>
                    <tr>
                        <td><?php echo $row['ReqID']; ?></td>
                        <td><?php echo $row['Req_Pname']; ?></td>
                        <td><?php echo $row['Req_Content']; ?></td>
                        <td><?php echo $row['SID']; ?></td>
                        <td><?php echo $row['Request_Date']; ?></td>
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

</html>