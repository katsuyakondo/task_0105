<?php
include('functions.php');
$pdo = connect_to_db();

$sql = 'SELECT * FROM voice_table'; // 必要に応じて 'SELECT id, content, created_at FROM voice_table' などとします
$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = "";
foreach ($result as $record) {
  $output .= "
     <ul class='centered-list'>
    <li class='flex-item'>
       <p class='date-text'>" . htmlspecialchars($record['content'], ENT_QUOTES, 'UTF-8') . " - " . $record['updated_at'] . "</p>
       <audio controls class='audio-controls'>
         <source src='play_audio.php?id=" . $record['id'] . "' type='audio/wav'>
         このブラウザはオーディオ要素をサポートしていません。
       </audio>
        <div class='edit-delete-links'>
        <a href='voice_edit.php?id={$record["id"]}'>編集</a>    
        <a href='voice_delete.php?id={$record["id"]}' onclick='return confirmDelete()'>削除</a>
      </div>
        </li>
     </ul>
  ";
}

?>

<script>
function confirmDelete() {
  return confirm("本当に削除してもよろしいですか？");
}
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>history</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<h1>履歴一覧</h1>
<tbody>
  <?= $output ?>
</tbody>
</html>
