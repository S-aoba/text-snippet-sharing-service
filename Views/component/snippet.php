<div class="w-full h-fit flex flex-col items-center pt-20 pb-10">
  <div id="editor-container" class="monaco-container" style="width: 800px; height: 600px; border: 1px solid grey;"></div>
</div>
<div class="flex justify-center">

  <button id="new-snippet" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
    <a href="http://localhost:8000/newSnippet">New Snippet</a>
  </button>
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
  });
</script>
