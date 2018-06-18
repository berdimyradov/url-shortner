<?php
include 'Functions.php';
include 'Const.php';

$link = $_POST["link"];

if (!(strpos(mb_strtolower($link), 'www.') === false) && strpos(mb_strtolower($link), 'http://') === false) {
    $link = 'http://' . $link;
}

if (filter_var($link, FILTER_VALIDATE_URL)) {
    $shortLink = MakeShortLink(5);
    InsertLink($link, $shortLink);
    echo "Your shorted link: <br>";
    $shortLink = 'http://' . $ServerHost . '/' . $shortLink;
    echo "<a href='$shortLink'>$shortLink</a>";
} else {
    if (LinkExists($link)) {
        $redirect = GetOriginalLink($link);
        header('Location: ' . $redirect);
    } else {
        die('Link is not valid!');
    }
}
