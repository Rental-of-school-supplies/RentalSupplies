<?php

    session_start();  

    session_unset();    // 세션 해제 

    session_destroy();  // 세션 파괴

    header("location: signIn_Up.html");
    exit();

?>