let mediaRecorder;
let audioChunks = [];

$(document).ready(function() {
    // 「録音開始」ボタンがクリックされた時の処理
    $("#startRecord").click(function() {
        // ユーザーのオーディオデバイスへのアクセスを要求
        navigator.mediaDevices.getUserMedia({ audio: true })
            .then(stream => {
                // MediaRecorderのインスタンスを作成
                mediaRecorder = new MediaRecorder(stream);
                // 録音データが利用可能になった時の処理
                mediaRecorder.ondataavailable = function(e) {
                    // 録音データを配列に追加
                    audioChunks.push(e.data);
                };
                // 録音が停止された時の処理
                mediaRecorder.onstop = async function() {
                    // 録音データをBlobとしてまとめる
                    const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                    // BlobからオーディオURLを作成
                    const audioUrl = URL.createObjectURL(audioBlob);
                    // オーディオプレーヤーのソースを設定
                    $("#audio").attr("src", audioUrl);
                    // 録音状態表示を隠す
                    $("#recordingStatus").hide();

                    // 編集・削除ボタンの表示（これらはHTML部分に依存）
                    $("#editRecording").show();
                    $("#deleteRecording").show();                    

                    // 録音データをBase64に変換
                    const reader = new FileReader();
                    reader.readAsDataURL(audioBlob);
                    reader.onloadend = function() {
                        const base64data = reader.result;
                        // 変換されたBase64データをフォームに設定
                        $("#audioData").val(base64data);
                    };
                };
                // 録音を開始
                mediaRecorder.start();
                // 録音開始ボタンを無効化し、停止ボタンを有効化
                $("#startRecord").prop("disabled", true);
                $("#stopRecord").prop("disabled", false);
                // 録音状態表示を表示
                $("#recordingStatus").show();
                // 録音データ用の配列を初期化
                audioChunks = [];
            });
    });

    // 「録音停止」ボタンがクリックされた時の処理
    $("#stopRecord").click(function() {
        // 録音を停止
        mediaRecorder.stop();
        // 録音開始ボタンを有効化し、停止ボタンを無効化
        $("#startRecord").prop("disabled", false);
        $("#stopRecord").prop("disabled", true);
    });
});
