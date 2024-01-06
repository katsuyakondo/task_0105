<!DOCTYPE html>
<html>

<head>
    <title>音声録音アプリ</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>音声録音</h1>
     <!-- 音声データをサーバーに送信するためのフォーム -->
    <form action="voice_create.php" method="post" enctype="multipart/form-data">
     
        <button type="button" id="startRecord">録音開始</button>
    
        <button type="button" id="stopRecord" disabled>録音停止</button>
     <!-- 録音された音声を再生するためのオーディオ要素 --> 
        <audio id="audio" controls></audio>
     
        <div id="recordingStatus" style="display: none;">録音中...</div>
     <!-- 録音された音声データをサーバーに送信するための隠しフィールド -->
        <input type="hidden" name="audioData" id="audioData">
     
        <input type="submit" value="録音データを送信">

    </form>
    <a href="read.php">履歴</a>
    <script src="app.js"></script>
</body>

</html>