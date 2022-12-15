<?php
    include('db.php');   
    global $db;

    date_default_timezone_set('Asia/Seoul');
    $time = date('Y-m-d H:i:s', time());

    if(isset($_POST['return'])){
        $rentalID = $_POST['returnID'];

        /* Rental table에서 In_Date 시간 설정 */
        $sql_set_inDate = $db -> query("
            update rental
            set in_date = '$time'	  
            where rentalID = ".$rentalID.";") or die($db->error);        

        /* 연체 여부 확인 */
        // rental table과 user table join 
        $sql_check_overdueStatus = $db -> query("
            update user inner join rental 
            on user.sid = rental.sid 
            set user.Overdue_status = True, user.Overdue_End_Date = (SELECT DATE_ADD('$time', INTERVAL 7 DAY)) 
            where rental.rentalID = ".$rentalID." and rental.in_date > rental.return_date;") or die($db->error);

        /* Product table의 Left_Quantity 1증가 */
        $sql_plus_leftQuantity = $db -> query("
            update product inner join rental 
            on product.cid = rental.cid and product.pid = rental.pid
            set Left_Quantity = Left_Quantity + 1
            where rental.rentalID = ".$rentalID.";") or die($db->error);

        /* Reservation table 예약대기가 존재할 경우, 자동으로 해당 물품 대여로 처리

            $rentalID를 통해서 rental table에서 cid, pid를 가져와야 함 
            => 가져온 cid, pid와 매칭되는걸 reservation table에서 찾는다. => 이것이 view로 표현
        */
        /* 이후에 row개수 = 1인지 확인하기 (1이면 A코스 진행) */
        $sql_check_reservationTable = $db -> query("
            CREATE OR REPLACE VIEW reservationCheckView 
            as select ReserveID, SID, Reserve_Date, CID, PID
            from reservation
            where CID = ( select cid from rental where rentalID = $rentalID) and PID = (select pid from rental where rentalID = $rentalID)
            order by Reserve_Date
            limit 1;") or die($db->error);

        $result = $db->query("select * from reservationCheckView");
        $set_rental_from_reservation = $result->fetch_assoc();

        if(isset($set_rental_from_reservation['ReserveID'])){   // 존재하는 경우 => A 코스 진행
            /* Rental table에 row 추가 */
            
            // rental row : RentalID, Out_Date, In_Date, Return_Date, SID, CID, PID
            // reservation row : ReserveID, SID, Reserve_Date, CID, PID
            $sql_progress_Acourse = $db -> query("
            insert into rental(Out_Date, Return_Date, SID, CID, PID) 
            select '$time', DATE_ADD('$time', INTERVAL 7 DAY), SID, CID, PID 
            from reservationCheckView;") or die($db->querry);

            /* Reservation view의 tuple을 삭제하여 origin table인 Reservation table의 tuple 삭제 */
            $sql_deleteReservationTable = $db -> query("delete from reservation where ReserveID = (select reserveID from reservationCheckView limit 1);") or die($db->querry);
        }

        echo 
        "<script>
            window.alert('성공적으로 반납되었습니다.');
            location.replace('../layout/product_list_M.php');
        </script>";
    }
?>