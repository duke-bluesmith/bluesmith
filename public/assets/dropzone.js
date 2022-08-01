var currentFile = null;
var myDropzone = null;

Dropzone.options.filesDropzone = {
	maxFilesize: 2000, // MB
	parallelUploads: 1,
	chunking: true,
	chunkSize: 10000, // ~1MB in bytes
	retryChunks: true,
	retryChunksLimit: 3,
	
	// When chunking include chunk data as POST fields
	params: function(files, xhr, chunk) {
		return chunk ? { uuid: chunk.file.upload.uuid, totalChunks: chunk.file.upload.totalChunkCount, chunkIndex: chunk.index } : null;
	},

/*
	// Pass the UUID for chunks so they can be merged later
	url: function (files) {
		file = files[0];
		if (file.upload.chunked) {
			
		}
		return baseUrl + 'files/create/' + files[0].upload.uuid;
	},
 
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
*/
};
