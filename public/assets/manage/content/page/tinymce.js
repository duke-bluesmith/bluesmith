$(document).ready(function() {
	tinymce.init({
		selector: '#tinymce',
		height: 600,
		plugins: "code link save",
		menubar: "file edit insert format table tools",
		toolbar: "code link save"
	});
});
