<!-- TODO: Prepare UI -->
<div class="h-full w-full">
  <div class="py-2 px-4 bg-neutral-800">
    <h1 class="text-3xl font-semibold text-white">Snippetter</h1>
  </div>
  
  <form method="POST" id="snippet-form" class="w-full h-96 px-4">
    <div id="editor" class="h-full"></div>
    <div class="py-2 opacity-80">
      <p class="text-white text-lg font-semibold">Optional Paste Settings</p>
    </div>
    <hr class="my-2 border-neutral-400">

    <!-- Settings -->
    <div class="w-2/5 h-fit py-2 flex flex-col space-y-2">
      <div class="w-full flex items-center justify-start space-x-10">
        <label for="syntax-highlighting" class="text-sm text-neutral-100 w-2/5">
          Syntax Highlighting:
        </label>
        <select name="syntax-highlighting" id="syntax-highlighting" class="flex-1 px-2 py-1 bg-neutral-700 text-white/70">
          <option value="none" selected>None</option>
          <option value="javascript">Javascript</option>
          <option value="php">PHP</option>
          <option value="java">Java</option>
          <option value="c">C</option>
          <option value="ruby">Ruby</option>
          <option value="python">Python</option>
        </select>
      </div>
      <div class="w-full flex items-center justify-start space-x-10">
        <label for="paste-expiration" class="text-sm text-neutral-100 w-2/5">
          Paste Expiration:
        </label>
        <select name="paste-expiration" id="paste-expiration" class="flex-1 px-2 py-1 bg-neutral-700 text-white/70">
          <option value="never" selected>Never</option>
          <option value="ten-minutes">10 Minutes</option>
          <option value="one-hour">1 Hour</option>
          <option value="one-day">1 Day</option>
        </select>
      </div>
      <div class="w-full flex items-center justify-start space-x-10">
        <label for="password" class="text-sm text-neutral-100 w-2/5">
          Password:
        </label>
        <input type="password" name="password" id="password" class="flex-1 w-full px-2 py-1 bg-neutral-700 text-white/70" />
      </div>
      <div class="w-full flex justify-end items-center">
        <button type="submit" class="py-2 px-3 bg-neutral-700 text-white text-sm font-semibold rounded-sm hover:opacity-75">Create New Paste</button>
      </div>
    </div>
    
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/monaco-editor@0.40.0/min/vs/loader.js"></script>
<!-- TODO: Prepare Js code -->
<script>
  let editor;

require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.40.0/min/vs' } });
require(['vs/editor/editor.main'], function() {
// エディターを初期化
editor = monaco.editor.create(document.getElementById('editor'), {
    value: '',
    language: 'markdown',
    theme: 'vs-light',
    automaticLayout: true
  })
});


const submitSnippet = async() => {
  const formData = new FormData();
  formData.append('snippet' ,editor.getValue());

  const syntaxHighlighting = document.getElementById('syntax-highlighting').value;
  formData.append('syntaxHighlighting' ,syntaxHighlighting);

  const pasteExpiration = document.getElementById('paste-expiration').value;
  formData.append('pasteExpiration' ,pasteExpiration);

  const password = document.getElementById('password').value;
  formData.append('password' ,password);

  const response = await fetch('http://localhost:8000/create', {
      method: "POST",
      body: formData
    });
    
    const data = await response.json();
    window.location.href = data.url;
}

const snippetForm = document.getElementById('snippet-form');
snippetForm.addEventListener('submit', (e) => {
  e.preventDefault();
  submitSnippet();
})
  


</script>