<?php
// 入力項目のチェック
// var_dump($_POST);
// exit();

include('functions.php');

if (
  !isset($_POST['id']) || $_POST['id'] === ''||
  !isset($_POST['audioData']) || $_POST['audioData'] === ''
) {
  exit('ParamError');
}

$id=$_POST['id'];
$encodedData=$_POST["audioData"];
$decodeDate=base64_decode(preg_replace('#^data:audio/\w+;base64,#i', '', $encodedData));


$pdo = connect_to_db();

$sql = 'UPDATE voice_table SET content=:content, updated_at=now() WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':content', $decodeDate, PDO::PARAM_LOB);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header('Location:read.php');
exit();

?>
