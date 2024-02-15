<div class="w-full h-fit flex flex-col items-center pt-20 pb-10">
  <div id="editor-container" class="monaco-container" style="width: 800px; height: 600px; border: 1px solid grey;"></div>
</div>
<div class="flex justify-center">
  <button id="new-snippet" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
    <a href="http://localhost:8000/newSnippet">New Snippet</a>
  </button>
  <button id="copy-url" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-4">Copy URL</button>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.41.0/min/vs/loader.min.js"></script>
<script>
  require.config({
    paths: {
      vs: "https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.41.0/min/vs",
    },
  });

  require(["vs/editor/editor.main"], function() {
    const editor = monaco.editor.create(
      document.getElementById("editor-container"), {
        value: <?= json_encode($data['snippet']) ?>,
        language: <?= json_encode($data['language']) ?>,
        automaticLayout: true,
        readOnly: true
      }
    );
    const copyBtn = document.getElementById("copy-url");
    // ボタンがクリックされたときにURLをクリップボードにコピーする関数
    function copyUrlToClipboard() {
      const url = window.location.href; // 現在のURLを取得
      navigator.clipboard.writeText(url); // クリップボードにURLをコピー
      copyBtn.innerHTML = 'Copied'; // ボタンの文字変更
      setTimeout(() => (copyBtn.innerHTML = 'Copy URL'), 1000); // ボタンの文字を戻す
    }

    // Copy URL ボタンにクリックイベントを追加
    document.getElementById("copy-url").addEventListener("click", copyUrlToClipboard);
  });
</script>
