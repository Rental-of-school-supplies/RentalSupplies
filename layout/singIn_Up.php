<!DOCTYPE html>
<?php session_start();?>
<html>

<head>
    <title>Rental-Of-school-supplies</title>
    <link rel="stylesheet" href="../css/singIn_Up.css" type="text/css">
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

    <!-- 로그인 및 회원가입 -->
    <div class="container">
        <div class="content_box">
            <div class="sign-in-container">
                <h1>SIGN IN</h1> <!-- 로그인 -->
                <form action="../php/login.php" , method="post">
                    <div class="radio_group">
                        <label class="form_radio"><input type="radio" class="roleRadio" id="generalMember" name="role"
                                value="generalMember" ondblclick="this.checked=false"> 학생</label>
                        <label class="form_radio" style="margin-left: 10%;"><input type="radio" class="roleRadio" id="manager" name="role"
                                value="manager" ondblclick="this.checked=false"> 관리자</label>
                    </div>
                    <label class="form_label">학번</label>
                    <input class="form_input" type="text" name="studentID" id="studentID"><br>
                    <label class="form_label" style="margin-top: 10%;">Password</label>
                    <input class="form_input" type="password" name="password" id="password"><br>
                    <button class="form_btn" style="margin-top: 36%;" name="signIn">Sign In</button>
                </form>
            </div>

            <div class="sign-up-container">
                <h1>SIGN UP</h1> <!-- 회원가입 -->
                <form action="../php/signup.php" , method="post">
                    <label class="form_label">학번</label>
                    <input class="form_input" type="text" name="studentID" id="studentID"><br>

                    <label class="form_label">이름</label>
                    <input class="form_input" type="text" name="name" id="name"><br>

                    <label class="form_label">Password</label>
                    <input class="form_input" type="password" name="password" id="password"><br>

                    <label class="form_label">Phone</label>
                    <input class="form_input" type="text" name="phone" id="phone"><br>

                    <label class="form_label">Email</label>
                    <input class="form_input" type="email" name="email" id="email"><br>
                    <button class="form_btn" name="signUp">Sign Up</button>
                </form>
            </div>
        </div>
    </div>

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