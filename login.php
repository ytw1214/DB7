<?php
session_start();
?>
<?php

$db = '
(DESCRIPTION =
    (ADDRESS_LIST=
        (ADDRESS = (PROTOCOL = TCP) (HOST = 203.249.87.57) (PORT = 1521))
    )
    (CONNECT_DATA =
    (SID = orcl)
        )
)';
$username = "DBA2022G7";
$password = "test12345";
$conn = oci_connect($username,$password,$db);

$userid = $_POST['login_id'];
$userpw = $_POST['login_password'];
$_SESSION['id'] = $userid;
$sql = "select * from member where MEMBERID = '$userid' and MEMBERPASSWORD = '$userpw'";
$stid = oci_parse($conn,$sql);
oci_execute($stid);
$result = oci_fetch_array($stid,OCI_ASSOC);
	if(empty($userid) || empty($userpw)) {
		echo '<script> alert("아이디나 비밀번호를 입력하세요");history.back();</script>';
	}

if($result > 0) {
    $sql = "select MEMBERPASSWORD from member where MEMBERPASSWORD = '$userpw'";
    $stid = oci_parse($conn, $sql);
    oci_execute($stid);
    $pw_check = oci_fetch_array($stid,OCI_ASSOC);
    if( $pw_check['MEMBERPASSWORD'] == $userpw) {
	    echo '<script> alert("로그인 성공");</script>';
	    echo '<script> location.href = "1112.php";</script>';
    }
    else {
	    echo '<script> alert("로그인 실패");</script>';
	    echo '<script> history.back();</script>';
    }
}
else {
	echo '<script> alert("아이디가 존재하지 않습니다.");history.back(); </script>';
}
    /* if(empty($userid) || empty($userpw)) {
            echo '<script> alert("아이디나  패스워드를 입력하세요."); history.back();</script>';
    }
    if($result['MEMBERID'] != $userid || $result['MEMBERPASSWORD'] != $userpw) {
            echo '<script> alert("아이디나 패스워드가 일치하지 않습니다."); history.back();</script>';
    }
    else {
            echo '<script> alert("이동");</script>';
    }
     */
?>

