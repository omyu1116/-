
<html>
<head>
  <title>掲示板</title>
  <link rel="stylesheet" href="style.css">

</head>
<body>

<h1 align = "center">掲示板</h1>
  <h2 align = "center">ルール</h2>
  <li align = "center">空のデータを送らない</li>
  <li align = "center">Admin,omyuの名前は勝手に使わない</li>

<form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
<p>ここに名前を入力</p>
  <input type="text" name="personal_name" align = "center"><br><br>
<p>投稿したい文を入力</p>
  <textarea name="contents" rows="8" cols="40">
</textarea><br><br>
<input type="submit" name="btn1" value="ここを押して投稿">
</form>

<?php
  date_default_timezone_set('Asia/Tokyo');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    writeData();
}

readData();

function readData(){
    $keijban_file = 'keijiban.txt';

    $fp = fopen($keijban_file, 'rb');

    if ($fp){
        if (flock($fp, LOCK_SH)){
            while (!feof($fp)) {
                $buffer = fgets($fp);
                print($buffer);
            }

            flock($fp, LOCK_UN);
        }else{
            print('ファイルロックに失敗しました');
        }
    }

    fclose($fp);
}

function writeData(){
    $personal_name = $_POST['personal_name'];
    $contents = $_POST['contents'];
    $contents = nl2br($contents);

    $data = "<hr>\r\n";
    $data = $data."<p>投稿者:".$personal_name."</p>\r\n";
    $data = $data."<p>内容:</p>\r\n";
    $data = $data."<p>".$contents."</p>\r\n";

    $keijban_file = 'keijiban.txt';

    $fp = fopen($keijban_file, 'ab');

    if ($fp){
        if (flock($fp, LOCK_EX)){
            if (fwrite($fp,  $data) === FALSE){
                print('ファイル書き込みに失敗しました');
            }

            flock($fp, LOCK_UN);
        }else{
            print('ファイルロックに失敗しました');
        }
    }

    fclose($fp);
}

?>
</body>
</html>
