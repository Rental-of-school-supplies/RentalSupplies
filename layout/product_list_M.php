<!DOCTYPE html>
<?php session_start(); ?>
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
            <li><a href="#">물품 목록</a></li>
            <li><a href="#">물품 신청</a></li>
            <li><a href="#">물품 관리</a></li>
            <li><a href="#">팀 소개</a></li>
        </ul>
    </nav>

    <section>
        <div class="container">
            <div class="product_list">
                <div class="product">
                    <h3 class="table-name">보조 배터리</h3>
                    <table class="rental-table">
                        <tbody>
                            <tr>
                                <td>2020039022</td>
                                <td>2022-12-03</td>
                                <td><button class="btn-rent" type="submit">반납</button></td>
                            </tr>
                            <tr>
                                <td>2020039022</td>
                                <td>2022-12-04</td>
                                <td><button class="btn-rent" type="submit">반납</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="reserve-table">
                        <tbody>
                            <tr>
                                <td>2020039022</td>
                                <td>2022-12-03</td>
                                <td><button class="btn-reserve" type="submit">대여</button></td>
                            </tr>
                            <tr>
                                <td>2020039022</td>
                                <td>2022-12-04</td>
                                <td><button class="btn-reserve" type="submit">대여</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="product">
                    <h3 class="table-name">우산</h3>
                    <table class="rental-table">
                        <tbody>
                            <tr>
                                <td>2020039022</td>
                                <td>2022-12-03</td>
                                <td><button class="btn-rent" type="submit">반납</button></td>
                            </tr>
                            <tr>
                                <td>2020039022</td>
                                <td>2022-12-04</td>
                                <td><button class="btn-rent" type="submit">반납</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="reserve-table">
                        <tbody>
                            <tr>
                                <td>2020039022</td>
                                <td>2022-12-03</td>
                                <td><button class="btn-reserve" type="submit">대여</button></td>
                            </tr>
                            <tr>
                                <td>2020039022</td>
                                <td>2022-12-04</td>
                                <td><button class="btn-reserve" type="submit">대여</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="product">
                    <h3 class="table-name">담요</h3>
                    <table class="rental-table">
                        <tbody>
                            <tr>
                                <td>2020039022</td>
                                <td>2022-12-03</td>
                                <td><button class="btn-rent" type="submit">반납</button></td>
                            </tr>
                            <tr>
                                <td>2020039022</td>
                                <td>2022-12-04</td>
                                <td><button class="btn-rent" type="submit">반납</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="reserve-table">
                        <tbody>
                            <tr>
                                <td>2020039022</td>
                                <td>2022-12-03</td>
                                <td><button class="btn-reserve" type="submit">대여</button></td>
                            </tr>
                            <tr>
                                <td>2020039022</td>
                                <td>2022-12-04</td>
                                <td><button class="btn-reserve" type="submit">대여</button></td>
                            </tr>
                        </tbody>
                    </table>
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