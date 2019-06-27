$(document).ready(function() {
	tinymce.init({
		selector: '#tinymce',
		height: 600,
		plugins: "link save",
		menubar: "file edit insert format table",
		toolbar: "link save"
	});
});
