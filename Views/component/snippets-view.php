<div id="editor"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs/loader.min.js"></script>
<script>
  require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs' } });

  fetch("/api/snippets/get?slug=<?php echo $slug ?>")
      .then(res => res.json())
      .then(data => {
        let editor = document.getElementById('editor')

        // スニペットが存在する場合
        if (data.snippetInfo && !data.snippetInfo.deleted_at) {
          require(['vs/editor/editor.main'], function () {
            const monacoEditor = monaco.editor.create(editor, {
              value: '',
              language: '',
              theme: 'vs-dark'
            });
            monacoEditor.setValue(data.snippetInfo.content)
            monaco.editor.setModelLanguage(monacoEditor.getModel(), data.snippetInfo.language)
          })
          
        // スニペットが論理削除されている場合
        } else if (data.snippetInfo && data.snippetInfo.deleted_at) {
          editor.textContent = 'スニペットの有効期限が切れています。';

        // スニペットが存在しない場合
        } else {
          editor.textContent = 'スニペットが存在しません。';
        }
      })
      .catch(err => {
        console.error('エラー: ', err)
      })

</script>