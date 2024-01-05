<?php
// var_dump($_POST);
// exit();

include('functions.php');
$pdo = connect_to_db();

if (
  !isset($_POST['audioData']) || $_POST['audioData'] === ''
) {
  exit('ParamError');
}

$encodedData=$_POST["audioData"];
$decodeDate=base64_decode(preg_replace('#^data:audio/\w+;base64,#i', '', $encodedData));

// 各種項目設定
$dbn ='mysql:dbname=php_1222_f14;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';

// DB接続
try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

// echo "DB接続成功";
// exit();

// SQL作成&実行
$sql = 'INSERT INTO voice_table (id, content, created_at, updated_at) VALUES (NULL, :content, now(), now())';

$stmt = $pdo->prepare($sql);

// バインド変数を設定
$stmt->bindValue(':content', $decodeDate, PDO::PARAM_LOB);

// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header('Location:input.php');
exit();

?>