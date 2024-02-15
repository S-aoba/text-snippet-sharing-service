<div class="w-full h-fit flex flex-col items-center pt-20 pb-10">
  <div id="editor-container" class="monaco-container" style="width: 800px; height: 600px; border: 1px solid grey;"></div>
</div>
<div class="flex justify-center items-center pt-10 space-x-5">
  <select type="text" id="language" class="border border-gray-400 p-2 mr-2" placeholder="言語">
    <?php echo generateLanguageOptions("PlainText"); ?>
  </select>
  <select type="text" id="expiration" class="border border-gray-400 p-2 mr-2" placeholder="期限">
    <?php echo generateExpirationOptions("10分"); ?>
  </select>

  <button id="create-btn" type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">作成</button>
</div>


<!-- Monaco Editor のスクリプトローダーを読み込む -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.41.0/min/vs/loader.min.js'></script>
<script>
  const createBtn = document.getElementById("create-btn");

  require.config({
    paths: {
      vs: "https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.41.0/min/vs",
    },
  });

  require(["vs/editor/editor.main"], function() {
    const editor = monaco.editor.create(
      document.getElementById("editor-container"), {
        value: "ここに共有したいテキストを入力してください。\n\n",
        language: "plaintext",
        automaticLayout: true,
      }
    );

    const languages = monaco.languages.getLanguages();

    createBtn.addEventListener("click", async function(event) {
      event.preventDefault();

      const snippet = editor.getValue();
      const language = document.getElementById("language").value;
      const expiration = document.getElementById("expiration").value;

      const response = await fetch("/snippet/create", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          snippet: snippet,
          language: language,
          expiration: expiration,
        }),
      });

      const result = await response.json();

      // messageが存在する場合
      if (result.message) {
        alert(result.message);
        // TODO 作成した画面に遷移する
        console.log(result.data);
        window.location.href = result.data['url'];
      }

      // エラーが発生した場合
      if (result.error) {
        alert(result.error);
      }
    });
  });
</script>
<?php
// プログラミング言語の選択肢を生成する関数
function generateLanguageOptions($selectedLanguage = "")
{
  // プログラミング言語のリスト
  $languages = array("PlainText", "Java", "Python", "JavaScript", "Ruby", "PHP");

  // 選択された言語のオプションを生成
  $options = "";
  foreach ($languages as $language) {
    $isSelected = ($selectedLanguage === $language) ? "selected" : "";
    $options .= "<option value='$language' $isSelected>$language</option>";
  }

  return $options;
}

// 期限の選択肢を生成する関数
function generateExpirationOptions($selectedExpiration = "")
{
  // 期限と値の連想配列
  $expiration_values = array(
    "1分" => "1 minute",
    "10分" => "10 minutes",
    "1時間" => "1 hour",
    "5時間" => "5 hours",
    "期限なし" => "none"
  );

  // 選択された期限のオプションを生成
  $options = "";
  foreach ($expiration_values as $expiration => $value) {
    $isSelected = ($selectedExpiration === $expiration) ? "selected" : "";
    $options .= "<option value='$value' $isSelected>$expiration</option>";
  }

  return $options;
}

?>
