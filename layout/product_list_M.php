<!DOCTYPE html>
<?php 
    session_start(); 
    include('../php/db.php');    
    include('../php/returnAndReserve.php');

    if(!isset($_SESSION['isSuccessLogin'])){
        $_SESSION['isSuccessLogin'] = false;
    }
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
                if($_SESSION['isSuccessLogin']){ //로그인 성공시 -> 로그아웃 출현 
                    echo '<li><a href="../php/logout.php">log out</a></li>';
                }else{
                    echo '<li><a href="./singIn_Up.php">sign in / sign up</a></li>';
                }  
            ?>         
        </ul>
    </div>

    <nav class="navbar">
        <ul>
            <li><a href="product_list_M.php">물품 목록</a></li>
            <li><a href="product_req_M.php">물품 신청</a></li>
            <li><a href="product_manage_M.php">물품 관리</a></li>
            <li><a href="team_intro_M.html">팀 소개</a></li>
        </ul>
    </nav>

    <section>
        <div class="container">
            <?php 
                        
                $resultRental = $db->query("
                    CREATE OR REPLACE VIEW rentalView 
                    as select rental.rentalid as 대여id, product.pid as 물품id, product.p_name as 대여물품, rental.sid as 빌린학생, rental.in_date, rental.return_date  
                    from manager, manages, product, rental 
                    where manager.mid = manages.mid 
                    and manages.cid = product.cid and manages.pid = product.pid 
                    and product.cid = rental.cid and product.pid = rental.pid
                    order by product.pid, rental.return_date;
                    ") or die($db->error);
                

                $resultReserve = $db->query("
                    CREATE OR REPLACE VIEW reserveView
                    as select reservation.reserveid as 예약id, product.pid as 물품id, product.p_name as 대기물품, reservation.sid as 대기학생, reservation.reserve_date as 대기일  
                    from manager, manages, product, reservation 
                    where manager.mid = manages.mid 
                    and manages.cid = product.cid and manages.pid = product.pid 
                    and product.cid = reservation.cid and product.pid = reservation.pid
                    order by product.pid, reservation.reserve_date;
                    ") or die($db->error);


                $currentSelectPID = 1;  //물품 id인 pid는 1부터 시작함
                $isEmptyProductTable = false;   
                
                $select_query = $db->query("select pid from product order by pid desc limit 1;") or die($db->error);
                $result = $select_query->fetch_assoc();
                $lastPID = $result['pid'];
                

                while(true):    // product_list 반복문 
                    echo '<div class="product_list">';

                    // $cntRental :  class Product의 개수가 4개이상부터는 class Product_List가 시작되도록 정보를 제공하는 변수 
                    for($cntRental = 0; $cntRental <= 2; ): // product 반복문 => $currentSelectPID = RentalTable의 PID = ReservationTable의 PID와 동일
                        
                        if($lastPID < $currentSelectPID){
                            $isEmptyProductTable = true;
                            break;
                        }

                        // 해당 인덱스에 해당하는 물품id가 존재확인 여부
                        $isExsistsProductId_query = $db->query("
                            select exists(
                                select 1
                                from product
                                where pid = '$currentSelectPID'
                            ) as cnt;
                        ") or die($db->error);
                        $result = $isExsistsProductId_query->fetch_assoc();
                        $isExsistsProductId = $result['cnt'];
                        if($isExsistsProductId == "0"){  //해당 물품 존재X
                            $currentSelectPID++;
                            continue;
                        }else{  // 존재
                            $currentSelectPID++;
                            $cntRental ++;
                        }

                        echo "<div class='product'>";
                        $select_query = $db -> query("select P_Name from product where pid = $currentSelectPID") or die($db->error);
                        $result = $select_query->fetch_assoc();
                        $productName = $result['P_Name'];
                        echo "<h3>".$productName."</h3>";

                        $resultRental = $db->query("select * from rentalView where 물품id = $currentSelectPID and in_date is null") or die($db->error); 
                        $resultReserve = $db->query("select * from reserveView where 물품id = $currentSelectPID") or die($db->error);

                        $idxOfRentalTable = 0;
                        while($rowRental=$resultRental->fetch_assoc()):   //rental table 반복문 
                            if($idxOfRentalTable == 0){
                                echo "<table class='rental-table'><tbody>";  
                            }
                            echo   "<tr>                                        
                                        <td>".$rowRental['빌린학생']."</td>
                                        <td>".$rowRental['return_date']."</td>"?>
                                        <form action="../php/returnAndReserve.php" method="post">
                                        <input type='hidden' name='returnID' value='<?php echo $rowRental['대여id']?>'>
                                        <td><button class='btn-rent' type='submit' name = 'return'>반납</button></td>
                                        </form>
                            <?php echo "</tr>";

                            $idxOfRentalTable++;
                        endwhile;
                        echo "</tbody></table>";

                        $idxOfReservationTable = 0;
                        while($rowReserve=$resultReserve->fetch_assoc()):    //reservation table 반복문
                            if($idxOfReservationTable == 0){
                                echo "<table class='reserve-table'><tbody>";  
                            }
                            echo   "<tr>
                                        <td>".$rowReserve['대기학생']."</td>
                                        <td>".$rowReserve['대기일']."</td>"?>
                                        <form action="../php/returnAndReserve.php" method="post">
                                        <input type='hidden' name='reserveID' value='<?php echo $rowRental['대여id']?>'>
                                        <td><button class='btn-reserve' type='submit' name = 'stand'>대기</button></td>
                                        </form>
                            <?php echo "</tr>";

                            $idxOfReservationTable++;
                        endwhile;
                        echo "</tbody></table>";

                    echo "</div>";
                    endfor;
                    echo "</div>";
                    
                    if($isEmptyProductTable == "1"){
                        break;
                    }

                endwhile;
                echo "</div>";
                // echo "</form>";
            ?>            
        </div>  <!-- container 끝 -->
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