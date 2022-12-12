<?php

    session_start();  
    session_unset();    // 세션 해제 
    session_destroy();  // 세션 파괴

    echo 
          "<script>
              window.alert('로그아웃에 성공했습니다');
              location.replace('../layout/main.php');
          </script>";
    exit();

?>