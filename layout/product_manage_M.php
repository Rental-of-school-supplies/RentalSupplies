<!DOCTYPE html>
<?php 
    session_start();
    if(!isset($_SESSION['isSuccessLogin'])){
        $_SESSION['isSuccessLogin'] = false;
    }
?>
<html>

<head>
    <title>Rental-Of-school-supplies</title>
    <link rel="stylesheet" href="../css/product_manage_M.css" type="text/css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nanum+Gothic&display=swap');
    </style>
    <script src="../js/main.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="../jquery-fadethis-master/libs/jquery/jquery.js"></script>
    <script src="../jquery-fadethis-master/dist/jquery.fadethis.min.js"></script>
</head>

<body>
    <p class="main">충북대학교<span class="main_dep"> 소프트웨어학부</span></p>
    <div class="logo">
        <a href="main_M.php"><img src="../src/logo.PNG" alt="logo" height="120px"></a>
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
            <li><a href="product_list_M.html">물품 목록</a></li>
            <li><a href="product_req_M.php">물품 신청</a></li>
            <li><a href="product_manage_M.php">물품 관리</a></li>
            <li><a href="team_intro_M.html">팀 소개</a></li>
        </ul>
    </nav>

    <section class="current_product">
        <div class="container">
            <h3 class="table-name">물품 리스트</h3>
            <button id="insertButton" onclick="location.href='product_add_M.php'" >물품 추가하기</button>
            
            <?php 
                $result = $db->query("select * from product")or die($db->error);
                $cnt = 1;
            ?>
            
            <table class="product-table">
                <colgroup>
                    <col style="width: 5%;" span="1">
                </colgroup>
                <thead>
                    <tr>
                        <th></th>
                        <th>물품명</th>
                        <th>전체 개수</th>
                        <th>남은 수량</th>
                        <th>수정</th>
                        <th>삭제</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $cnt; $cnt++;?></td>
                        <td><?php echo $row['P_Name']?></td>
                        <td><?php echo $row['Total_Quantity']?></td>
                        <td><?php echo $row['Left_Quantity'] ?></td>
                        <td><a href="product_manage_M.php?edit=<?php echo $row['PID']; ?>" class="btn btn-info">EDIT</a></td>
                        <td><a href="../php/productManage.php?delete=<?php echo $row['PID']; ?>" class="btn btn-danger">DELETE</a></td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.4/js/tether.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>
</html>