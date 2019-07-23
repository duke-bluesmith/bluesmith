var currentFile = null;
var myDropzone = null;

Dropzone.options.filesDropzone = {
	maxFilesize: 2000, // MB
	chunking: true,
	chunkSize: 1000000, // ~1MB in bytes
	retryChunks: true,
	retryChunksLimit: 3,

	// https://stackoverflow.com/questions/49769853/dropzone-js-chunking
	chunksUploaded: function (file, done) {
		// All chunks have been uploaded. Perform any other actions
		currentFile = file;

		// This calls server-side code to merge all chunks for the currentFile
		$.ajax({
			type: "POST",
			url: baseUrl+"files/merge/" + currentFile.upload.uuid,
			success: function (data) {
				// Must call done() if successful
				done();
			},
			error: function (msg) {
				currentFile.accepted = false;
				done(msg.responseText);
			}
		 });
	},
	
	init: function() {
		// This calls server-side code to delete temporary files created if the file failed to upload
		// This also gets called if the upload is canceled
		this.on('error', function(file, errorMessage) {
			$.ajax({
				type: "DELETE",
				url: baseUrl+"files/fail/" + currentFile.upload.uuid,
				success: function (data) {
					// nothing
				}
			});
		});
	}
};
