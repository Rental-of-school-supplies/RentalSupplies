<?php

session_start();  

include('db.php');

if (isset($_POST['return'])){
    $reserveID = $_POST['대여id'];

    /* Rental table에서 In_Date 시간 설정 */
    $sql_set_inDate = $db -> query("
        update rental
        set in_date = now()	 -- 현재 시간 
        where pid = (
            select 물품id
            from rentalView
            where 대여id = ".$reserveID." -- 반납처리 버튼을 누른 대여id값을 가져온다. 
        );") or die($db->error);

    /* 연체 여부 확인 */
    $sql_check_overdueStatus = $db -> query("
        update user
        set Overdue_status = True, Overdue_End_Date = (SELECT DATE_ADD(NOW(), INTERVAL 7 DAY)) -- 연체일: 반납일 기준으로 7일 더함
        where in_date > return_date 
        ;") or die($db->error);

    /* Product table의 Left_Quantity 1증가 */
    $sql_plus_leftQuantity = $db -> query("
        update product
        set Left_Quantity = Left_Quantity + 1
        where pid = (
            select 물품id
            from rentalView
            where 대여id = ".$reserveID." -- 반납처리 버튼을 누른 대여id값을 가져온다. 
        );") or die($db->error);

    /* Reservation table 예약대기가 존재할 경우, 자동으로 해당 물품 대여로 처리 */
    /* 이후에 row개수 = 1인지 확인하기 (1이면 A코스 진행) */
    $sql_check_reservationTable = $db -> query("
        CREATE OR REPLACE VIEW reservationCntView 
        as select *
        from reservation
        where pid = (
            select 물품id
            from rentalView
            where 대여id = ".$reserveID." -- 반납처리 버튼을 누른 대여id값을 가져온다. 
        )
        order by Reserve_Date
        limit 1;	-- 해당 물품에 대한 예약대기가 존재하는지 확인 
        ") or die($db->error);
    
    $result = $db->query("select * from reservationCntView");
    $set_rental_from_reservation = $result->fetch_assoc();
    if($set_rental_from_reservation['reservationID']{   // 존재하지 않는 경우 
        header("location:../layout/product_list_M.php");   // pass -> 본 php 끝내기 
    })

    /* 존재하는 경우 => A 코스 진행 
        -- Rental table에 row 추가 
    */
    $sql_progress_Acourse = $db -> query("
        insert into rental(RentalID, Out_Date, Return_Date, SID, CID, PID) -- RentalID, Out_Date, In_Date, Return_Date, SID, CID, PID
        select ReserveID, now(), date_add(now(), INTERVAL 7 DAY), SID, CID, PID
        from reservation	-- ReserveID, SID, Reserve_Date, CID, PID
        where reserveID = reservationCntView.ReserveID;       
        ") or die($db->querry);

    /* Reservation view의 tuple을 삭제하여 origin table인 Reservation table의 tuple 삭제 */
    $sql_deleteReservationTable = $db -> query("
        delete from reservationCntView 
        where reserveID = reservationCntView.ReserveID;
    ") or die($db->querry);
}
?>