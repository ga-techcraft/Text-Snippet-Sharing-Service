  <div class="controls">
    <label for="language-select">言語を選択：</label>
    <select id="language-select">
      <option value="html">HTML</option>
      <option value="css">CSS</option>
      <option value="php">PHP</option>
      <option value="javascript">JavaScript</option>
      <option value="python">Python</option>
      <option value="c">C</option>
      <option value="cpp">C++</option>
    </select>

    <label for="expiry-select" style="margin-left: 20px;">有効期限：</label>
    <select id="expiry-select">
      <option value="10m">10分</option>
      <option value="1h">1時間</option>
      <option value="1d">1日</option>
      <option value="never">永続</option>
    </select>

    <button id="generate-btn" style="margin-left: 20px;">Generate URL</button>
  </div>

  <div id="editor"></div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs/loader.min.js"></script>
  <script>
    require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs' } });

    require(['vs/editor/editor.main'], function () {
      const editor = monaco.editor.create(document.getElementById('editor'), {
        value: '// コードをここに入力...',
        language: 'javascript',
        theme: 'vs-dark'
      });

      // 言語選択イベント
      document.getElementById('language-select').addEventListener('change', function (e) {
        const lang = e.target.value;
        monaco.editor.setModelLanguage(editor.getModel(), lang);
      });

      // ボタン押下イベント（Generate URL）
      document.getElementById('generate-btn').addEventListener('click', () => {
        const language = document.getElementById('language-select').value;
        const expiresIn = document.getElementById('expiry-select').value;
        const content = editor.getValue();


        fetch('/api/snippets/create', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'  
          },
          body: JSON.stringify({
            'content': content,
            'language': language,
            'expires_in': expiresIn
          })
        })
        .then(res => res.json())
        .then(data => {
          console.log(data)
          navigator.clipboard.writeText(data.url)
          .then(() => {
            alert('コードシェアのURLをコピーしました。');
          })
          .catch(() => {
            alert('エラーが発生しました。');
          });
        })
        .catch(err => {
          alert('エラーが発生しました。');
        })
      });

    });
  </script>
</body>
</html>