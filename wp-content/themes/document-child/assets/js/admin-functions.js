const downloadPdf = (postId) => {
	// Make AJAX request to generate PDF file
	jQuery.ajax({
		type: "POST",
		url: ajaxurl, // The WordPress AJAX URL
		data: {
			action: "generate_pdf",
			post_id: postId,
		},
    success: function (response) { 
			// Create download link for PDF file
			var download_link = document.createElement("a");
			download_link.href = response;
			download_link.download = response;

			// Trigger click event to start download
			download_link.click();
		},
	});
};
