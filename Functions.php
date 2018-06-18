<?php
include 'Const.php';

function connectToDB()
{
    global $ServerHost;
    global $UserName;
    global $Password;
    global $DBase;
    $con = mysqli_connect($ServerHost, $UserName, $Password);
    mysqli_select_db($con, $DBase);
    return $con;
}

function InsertLink($OrgLink, $ShortLink)
{
    $conn = connectToDB();
    $n = strtotime(date('Y-m-d H:i:s'));
    $now = date('Y-m-d H:i:s', $n);
    $command = "INSERT INTO Links (LinkShorted,LinkOriginal,AddedTime) VALUES ('$ShortLink','$OrgLink','$now')";
    mysqli_query($conn, $command);
    mysqli_close($conn);
}

function DeleteLink($id)
{
    $conn = connectToDB();
    $command = "DELETE FROM Links WHERE id = '$id'";
    mysqli_query($conn, $command);
    mysqli_close($conn);
}

function LinkExists($adr)
{
    $conn = connectToDB();
    $command = "SELECT * FROM Links WHERE LinkShorted = '$adr'";
    $result = mysqli_query($conn, $command);
    $rowCount = mysqli_num_rows($result);
    mysqli_close($conn);
    return ($rowCount > 0);
}

function GetOriginalLink($Link)
{
    $conn = connectToDB();
    $command = "SELECT * FROM Links WHERE LinkShorted = '$Link'";
    $query = mysqli_query($conn, $command);
    $result = mysqli_fetch_array($query);
    mysqli_close($conn);
    return $result['LinkOriginal'];
}

function ClearOld($minutes)
{
    $sec = $minutes * 60;
    $conn = connectToDB();
    $command = "SELECT * FROM Links";
    $query = mysqli_query($conn, $command);
    $res = 0;
    while ($result = mysqli_fetch_array($query)) {
        $tm = strtotime($result['AddedTime']);
        $now = strtotime(date('Y-m-d H:i:s'));
        $dif = $now - $tm;

        if ($dif > $sec) {$id = $result['id'];
            $del_cmd = "DELETE FROM Links WHERE id = '$id'";
            mysqli_query($conn, $del_cmd);
            $res++;
        }

    }
    mysqli_close($conn);
    return $res;
}

function MakeShortLink($len)
{
    $result = '';
    while (strlen($result) < $len) {
        $Char = chr(rand(97, 122));
        $Num = rand(0, 9);
        $case = rand(1, 2);
        if ($case == 1) {
            $result .= $Char;
        } else {
            $result .= strval($Num);
        }
        ;
    }
    return $result;
}
