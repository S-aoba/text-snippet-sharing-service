  <div class="w-full h-full flex justify-center flex-col items-center">
    <div class="w-11/12 h-full flex items-center flex-col">
      <div id="editor-container" class="monaco-container h-3/6 w-11/12 flex justify-center"></div>
      <div class="py-10 flex flex-col items-center space-y-4 w-full">
        <h2 class="text-3xl font-bold text-center text-white">
          Optional Settings
        </h2>
        <div class="w-2/4 max-w-3xl h-fit bg-white rounded shadow p-5">
          <div class="w-full h-full">
            <ul class="text-lg flex justify-start flex-col">
              <li class="mb-2">Language: </li>
              <select class="w-full p-1 border border-gray-300" name="planeText">
                <option value="plaintext">
                  plaintext
                </option>
                <option value="python">
                  python
                </option>
                <option value="javascript">
                  javascript
                </option>
                <option value="php">
                  php
                </option>
                <option value="java">
                  java
                </option>
                <option value="c_cpp">
                  c_cpp
                </option>
                <option value="c_sharp">
                  c_sharp
                </option>
                <option value="go">
                  go
                </option>
                <option value="ruby">
                  ruby
                </option>
                <option value="rust">
                  rust
                </option>
                <option value="swift">
                  swift
                </option>
                <option value="kotlin">
                  kotlin
                </option>
              </select>
              <li class="my-2">Snippet Expiration: </li>
              <select class="w-full p-1 border border-gray-300" name="expire">
                <option value="10">
                  10分
                </option>
                <option value="60">
                  1時間
                </option>
                <option value="1440">
                  1日
                </option>
                <option value="Never">
                  Never
                </option>
              </select>
            </ul>
            <div class="mt-5">
              <button class="p-3 border border-blue-500 bg-blue-500 text-white rounded hover:bg-blue-600">Create Snippet</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.41.0/min/vs/loader.min.js"></script>
  <script>
    require.config({
      paths: {
        'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.41.0/min/vs'
      }
    });
    require(['vs/editor/editor.main'], function() {
      var editor = monaco.editor.create(document.getElementById('editor-container'), {
        // value: '<?php echo htmlspecialchars("Hello World"); ?>',
        language: 'plaintext' // エディターの言語を設定
      });
    });
  </script>
