<div class="h-full w-full">
  <div class="py-2 px-4 bg-neutral-800">
    <h1 class="text-3xl font-semibold text-white">Snippetter</h1>
  </div>
  
  <div id="snippet-form" class="w-full h-96 px-4">
    <div id="editor" class="h-full"></div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/monaco-editor@0.40.0/min/vs/loader.js"></script>
<script>
  const snippet = <?= json_encode($data) ?>;
    
  require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.40.0/min/vs' } });
  require(['vs/editor/editor.main'], function() {
    // エディターを初期化
    const editor = monaco.editor.create(document.getElementById('editor'), {
      value: snippet['snippet'],
      language: 'markdown',
      theme: 'vs-light',
      automaticLayout: true
    })
  });
</script>