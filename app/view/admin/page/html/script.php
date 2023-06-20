var win = navigator.platform.indexOf('Win') > -1;
if (win && document.querySelector('#sidenav-scrollbar')) {
  var options = {
    damping: '0.5'
  }
  Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
}

var editor = [];
function initEditor(selector){
	ClassicEditor
        .create( document.querySelector( selector ), {
			toolbar: {
                    items: [
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        'alignment', '|',
                        'link', 'blockQuote', 'insertTable', 'codeBlock', '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        'textPartLanguage', '|'
                    ],
                    shouldNotGroupWhenFull: true
                },
		} )
		.then( newEditor => {
			editor[selector] = newEditor;
		} )
    .catch( error => {
        console.error( error );
    } );
}
