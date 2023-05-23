const formButton = document.getElementById("quckUploadFormButton");
const messageView = document.getElementById("messageView");

formButton.addEventListener('click', (e) => {
	e.preventDefault();
	messageView.disabled = true;
	const mainFormUpload = document.getElementById("quckUploadForm"); // Get the first element with the class "form-container"
	let formData = new FormData(mainFormUpload);
	formData.append("action", "handle_form_submission");
	formData.append("security", ajax_object.nonce);
	jQuery.ajax({
		url: ajax_object.ajax_url,
		type: "POST",
		data: formData,
		processData: false,
		contentType: false,
		success: function (response) {
			console.log(response);
			if (response.success) {
				messageView.style.display = "inline-flex";
				messageView.style.background = "green";
				console.log(response);
				messageView.innerHTML = `${response.data.message} You can see the changes in ${response.data.data}`;
				setTimeout(() => {
					location.reload();
				}, 2000);
			 } else{
				messageView.style.display = "inline-flex";
				messageView.style.background = "red";
				messageView.innerHTML = response.data.message;
			 }
		},
	});

});