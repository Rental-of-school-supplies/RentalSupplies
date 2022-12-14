<?php

session_start();  

include('db.php');

if (isset($_POST['signIn'])){

  // 보안을 더욱 강화 (시큐어코딩, 보안코딩)
  $role = $_POST['role'];
  $studentID = mysqli_real_escape_string($db, $_POST['studentID']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  // 에러 체크 
  if(empty($studentID)){
    echo 
        "<script>
            window.alert('반드시 학번을 입력해주세요');
            location.replace('../layout/singIn_Up.php');
        </script>";
  }else if(empty($password)){
    echo 
        "<script>
            window.alert('반드시 비밀번호를 입력해주세요');
            location.replace('../layout/singIn_Up.php');
        </script>";
  }else{ 
      
    $sql = "";
    // 로그인시키는 코딩 
    if($role == 'generalMember'){
      $_SESSION['isManager'] = false;
      $sql = "SELECT * FROM User WHERE SID = '$studentID'";
    }else if($role == 'manager'){
      $_SESSION['isManager'] = true;
      $sql = "SELECT * FROM Manager WHERE MID = '$studentID'";
    }
    
    $result = mysqli_query($db, $sql);
    if(mysqli_num_rows($result) === 1){

      $row = mysqli_fetch_assoc($result);  // 결과값 저장
      $hash = $row['Password']; // DB안에 있는 암호화된 값을 가져 옴

      $_SESSION['isSuccessLogin'] = false;
      // password와 hash를 매핑시킴
      if(password_verify($password, $hash)){
        if(($_SESSION['isManager'] != false)){
          $_SESSION['studentID'] = $row['SID'];
        }else{
          $_SESSION['studentID'] = $row['MID'];
        }
        $_SESSION['name'] = $row['Name'];

        $_SESSION['isSuccessLogin'] = true;

        if($_SESSION['isManager']){
          echo 
          "<script>
              window.alert('로그인에 성공했습니다');
              location.replace('../layout/main_M.php');
          </script>";
        }else{
          echo 
          "<script>
              window.alert('로그인에 성공했습니다');
              location.replace('../layout/main.php');
          </script>";
        }
        
      }else{
        echo 
          "<script>
              window.alert('비밀번호가 잘못 입력되었습니다');
              location.replace('../layout/main.php');
          </script>";
      }

    }else{
      echo 
          "<script>
              window.alert('아이디가 잘못 입력되었습니다');
              location.replace('../layout/main.php');
          </script>";
    }
  }    
}else{
  // 에러 메시지 
  echo 
      "<script>
          window.alert('알 수 없는 오류가 발생했습니다');
          location.replace('../layout/singIn_Up.php');
      </script>";
}
?>