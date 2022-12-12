<?php
    include('db.php');   

    function returnAndReserveFun($rentalID){  
        
        global $db;

        /* Rental table에서 In_Date 시간 설정 */
        $sql_set_inDate = $db -> query("
            update rental
            set in_date = now()	 -- 현재 시간 
            where rentalID = ".$rentalID.
            ";") or die($db->error);        

        /* 연체 여부 확인 */
        // rental table과 user table join 
        $sql_check_overdueStatus = $db -> query("
            update user inner join rental 
            on user.sid = rental.sid 
            set user.Overdue_status = True, user.Overdue_End_Date = (SELECT DATE_ADD(NOW(), INTERVAL 7 DAY)) -- 연체일: 반납일 기준으로 7일 더함 
            where rental.rentalID = ".$rentalID." and rental.in_date > rental.return_date
            ;") or die($db->error);

        /* Product table의 Left_Quantity 1증가 */
        $sql_plus_leftQuantity = $db -> query("
            update product inner join rental 
            on product.cid = rental.cid and product.pid = rental.pid
            set Left_Quantity = Left_Quantity + 1
            where rental.rentalID = ".$rentalID."
            ;") or die($db->error);

        /* Reservation table 예약대기가 존재할 경우, 자동으로 해당 물품 대여로 처리 */
        /* 이후에 row개수 = 1인지 확인하기 (1이면 A코스 진행) */
        $sql_check_reservationTable = $db -> query("
            CREATE OR REPLACE VIEW reservationCntView 
            as select res.reserveID, res.sid, res.reserve_date, res.cid, res.pid
            from reservation as res, rental
            where res.cid = rental.cid and res.pid = rental.pid and rental.rentalID = ".$rentalID."
            order by Reserve_Date
            limit 1;") or die($db->error);
        
        $result = $db->query("select * from reservationCntView");
        $set_rental_from_reservation = $result->fetch_assoc();
        // if($set_rental_from_reservation['reservationID']{   // 존재하지 않는 경우 
        //     return false;   // pass -> 함수 끝내기 
        // })

        if(isset($set_rental_from_reservation['reservationID'])){   // 존재하는 경우 => A 코스 진행
            /* Rental table에 row 추가 */
            
            // rental row : RentalID, Out_Date, In_Date, Return_Date, SID, CID, PID
            // reservation row : ReserveID, SID, Reserve_Date, CID, PID
            $sql_progress_Acourse = $db -> query("
            insert into rental(Out_Date, Return_Date, SID, CID, PID) 
            values (
                select now(), date_add(now(), INTERVAL 7 DAY), SID, CID, PID
                from reservationCntView);") or die($db->querry);

            // $sql_progress_Acourse = $db -> query("
            // insert into rental(RentalID, Out_Date, Return_Date, SID, CID, PID) 
            // select ReserveID, now(), date_add(now(), INTERVAL 7 DAY), SID, CID, PID
            // from reservation
            // where reserveID = reservationCntView.ReserveID;       
            // ") or die($db->querry);



            /* Reservation view의 tuple을 삭제하여 origin table인 Reservation table의 tuple 삭제 */
            $sql_deleteReservationTable = $db -> query("
                delete from reservationCntView;") or die($db->querry);

            // $sql_deleteReservationTable = $db -> query("
            //     delete from reservationCntView 
            //     where reservationCntView.ReserveID = ".$rentalID.";
            //     ") or die($db->querry);
        }
    }
?>