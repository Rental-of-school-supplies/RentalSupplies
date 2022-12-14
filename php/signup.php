<?php

session_start();  

include('db.php');

if (isset($_POST['signUp'])){

    // 보안을 더욱 강화 (시큐어코딩, 보안코딩)
    $studentID = mysqli_real_escape_string($db, $_POST['studentID']);
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $email = mysqli_real_escape_string($db, $_POST['email']);

    
    // 에러 체크 
    if(empty($studentID)){
        echo 
            "<script>
                window.alert('반드시 학번을 입력해주세요');
                location.replace('../layout/singIn_Up.html');
            </script>";
    }else if(empty($name)){
        echo 
            "<script>
                window.alert('반드시 이름을 입력해주세요');
                location.replace('../layout/singIn_Up.html');
            </script>";
    }else if(empty($password)){
        echo 
            "<script>
                window.alert('반드시 비밀번호를 입력해주세요');
                location.replace('../layout/singIn_Up.html');
            </script>";
    }else if(empty($phone)){
        echo 
            "<script>
                window.alert('반드시 전화번호를 입력해주세요');
                location.replace('../layout/singIn_Up.html');
            </script>";
    }else if(empty($email)){
        echo 
            "<script>
                window.alert('반드시 이메일을 입력해주세요');
                location.replace('../layout/singIn_Up.html');
            </script>";
    }else{ 
        
        // 암호화 
        $password = password_hash($password, PASSWORD_DEFAULT); // 단방향 암호화 

        // 아이디 또는 닉네임, 또는 아이디와 동시에 닉네임 중복체크 
        $sql_same = "SELECT * FROM User WHERE SID = $studentID";
        $order = mysqli_query($db, $sql_same); //db 접속, 명령을 입력해
    
        if(mysqli_num_rows($order) > 0){    // 가로들의 개수를 세줌
            echo 
                "<script>
                    window.alert('학번이 이미 존재합니다');
                    location.replace('../layout/singIn_Up.html');
                </script>";
        }else{

            // 에러가 없다면 insert into 삽입 시킴 
            $sql_insert = "INSERT INTO User (SID, Name, Password, Phone, Email) VALUES('$studentID', '$name', '$password', '$phone', '$email')";
            $result = mysqli_query($db, $sql_insert);
            print_r($result);

            if($result){
                echo 
                    "<script>
                        window.alert('회원가입에 성공했습니다');
                        location.replace('../layout/singIn_Up.html');
                    </script>";
            }else{
                echo 
                    "<script>
                        window.alert('회원가입에 실패했습니다');
                        location.replace('../layout/singIn_Up.html');
                    </script>";
            }
        }
    }    
}else{
    // 에러 메시지 
    echo 
        "<script>
        window.alert('알 수 없는 오류가 발생했습니다');
            location.replace('../layout/singIn_Up.html');
        </script>";
}
?>