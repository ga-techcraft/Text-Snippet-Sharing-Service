  <div class="controls">
  </div>

  <div id="editor"></div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs/loader.min.js"></script>
  <script>
    require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs' } });

    require(['vs/editor/editor.main'], function () {
      const editor = monaco.editor.create(document.getElementById('editor'), {
        value: '',
        language: '',
        theme: 'vs-dark'
      });

      fetch("/api/snippets/get?slug=<?php echo $slug ?>")
          .then(res => res.json())
          .then(data => {
            console.log(data)
            editor.setValue(data.snippetInfo.content)
            monaco.editor.setModelLanguage(editor.getModel(), data.snippetInfo.language)
          })
          .catch(err => {
            console.error('エラー: ', err)
          })

    })


    
  </script>
</body>
</html>