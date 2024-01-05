let mediaRecorder;
let audioChunks = [];

$(document).ready(function() {
    $("#startRecord").click(function() {
        navigator.mediaDevices.getUserMedia({ audio: true })
            .then(stream => {
                mediaRecorder = new MediaRecorder(stream);
                mediaRecorder.ondataavailable = function(e) {
                    audioChunks.push(e.data);
                };
                mediaRecorder.onstop = async function() {
                    const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                    const audioUrl = URL.createObjectURL(audioBlob);
                    $("#audio").attr("src", audioUrl);
                    $("#recordingStatus").hide();


                    // 編集・削除ボタンの表示
                    $("#editRecording").show();
                    $("#deleteRecording").show();                    

                    // 録音データをBase64に変換してフォームに設定
                    const reader = new FileReader();
                    reader.readAsDataURL(audioBlob);
                    reader.onloadend = function() {
                        const base64data = reader.result;
                        $("#audioData").val(base64data);
                   };
                };
                mediaRecorder.start();
                $("#startRecord").prop("disabled", true);
                $("#stopRecord").prop("disabled", false);
                $("#recordingStatus").show();
                audioChunks = [];
            });
    });

    $("#stopRecord").click(function() {
        mediaRecorder.stop();
        $("#startRecord").prop("disabled", false);
        $("#stopRecord").prop("disabled", true);
    });
});
