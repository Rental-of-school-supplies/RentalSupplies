<!DOCTYPE html>
<html>

<head>
    <title>product_req</title>
    <link rel="stylesheet" href="../css/product_add_M.css" type="text/css">
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

    <section class="product_req">

        <div class="container">
            <form action="../php/productadd.php" method="post" enctype="multipart/form-data">
                <div class="product_name">
                    <label class="title_text" for="title">추가할 물품 이름</label>
                    <input class="title_input" type="text" name="title" maxlength="100" required="required" pattern=".{1,100}">
                </div>

                <div class="product_quantity">
                    <label class="quantity_text" for="quantity">전체 수량</label>
                    <input class="quantity_input" type="text" name="quantity" maxlength="100" required="required" pattern=".{1,2}">
                </div>

                <div class="product_explanation">
                    <label class="explanation_text" for="explanation">물품 설명</label>
                    <input class="explanation_input" type="text" name="explanation" maxlength="100" required="required" pattern=".{4,100}">
                </div>

                <div class="category">
                    <label class="category_text" for="cate">카테고리</label>
                    <select class="category-list" for="category-list" name="category">
                        <option value="2">생필품</option>
                        <option value="3">전자기기</option>
                        <option value="4">운동기구</option>
                        <option value="5">문구류</option>
                    </select>
                </div>

                <div class="attach_file">
                    <label class="file_text" for="file">파일 첨부</label>
                    <input class="file_input" type="file" name="myfile" maxlength="100" required="required">
                        <br>
                        <img src="" width="100" style="display:none;" />
                        <br>
                </div>

                <button class="btn_submit" type="submit" name="save">제출하기</button>
            </form>
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