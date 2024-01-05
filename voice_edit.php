<?php
include("functions.php");

$id = $_GET['id'];

$pdo = connect_to_db();

$sql = 'SELECT * FROM voice_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$record = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<head>
    <title>編集画面</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>編集画面</h1>
    <form action="voice_update.php" method="post" enctype="multipart/form-data">
        <button type="button" id="startRecord">録音開始</button>
        <button type="button" id="stopRecord" disabled>録音停止</button>
        <audio id="audio" controls></audio>
        <div id="recordingStatus" style="display: none;">録音中...</div>
  
        <input type="hidden" name="id" value="<?= $record['id'] ?>">
        <input type="hidden" name="audioData" id="audioData">
        <input type="submit" value="録音データを送信">
      </form>
        <a href="read.php">履歴</a>
        <script src="app.js"></script>
</body>
