<?php
session_start();
?>
<html>
<body>
<?php

$db = '
(DESCRIPTION = 
        (ADDRESS_LIST=
                (ADDRESS = (PROTOCOL = TCP) (HOST = 203.249.87.57) (PORT = 1521)
)
        )
        (CONNECT_DATA = 
        (SID = orcl)
        )
)';

$username = "DBA2022G7";
$password = "test12345";
$connect = oci_connect($username, $password, $db);
$userid = $_SESSION['id'];
if(!$connect) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'],ENT_QUOTES),E_USER_ERROR);
}
 $sql = "select distinct book.BOOKNAME from book, member where book.BOOKCATEGORY = member.CATEGORY and MEMBERID = '$userid'";
// $sql = "select BOOKNAME from member, book where book.BOOKCATEGORY = member.CATEGORY";
//$sql = "select BOOKNAME from book, member where book.BOOKCATEGORY = member.CATEGORY";
$stid = oci_parse($connect, $sql);

oci_execute($stid);

echo "<table width='300' border='1' cellpadding='0' cellspacing='0'\n";

while($row = oci_fetch_array($stid,OCI_ASSOC+OCI_RETURN_NULLS)) {
    echo "<tr>\n";

    foreach($row as $item) {
    echo "  <td> ". ($item !== NULL ? htmlentities($item,ENT_QUOTES) : "&nbsp';") . "</td>\n";
    echo "</tr>\n";
    }
}
echo "</table>\n";
$SESSION['category'] = $row['MEMBER.CATEGORY'];

//$_SESSION['bookname'] = $row['bookname'];

//echo '<script> location.href = "book_intro.php?bookname='.$_SESSION['bookname'].'";</script>;';
oci_free_statement($stid);
oci_close($connect);
?>
</body>
</html>
