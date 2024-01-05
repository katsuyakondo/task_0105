<?php
include('functions.php');
$pdo = connect_to_db();

// クエリパラメータからIDを取得
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// 指定されたIDに対応する音声データを取得
$sql = 'SELECT content FROM voice_table WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$audio = $stmt->fetch(PDO::FETCH_ASSOC);

// 音声データが見つからなかった場合の処理
if (!$audio) {
    echo "音声データが見つかりません";
    exit;
}

// 音声データをブラウザに送信
header('Content-Type: audio/wav'); // 音声データの形式に合わせて変更
echo $audio['content'];
exit();
