<style>
	#quckUploadFormButton {
		color: #362ecc;
		padding: 8px 20px;
		font-family: 'Montserrat', sans-self;
		border: none;
		font-size: 16px;
		margin-top: 20px;
		font-weight: 600;
		cursor: pointer;
		background-color: transparent;
		border: 3px solid #3858e9;
		border-radius: 3px;
	}

	#quckUploadFormButton:hover {
		background: #3858e9;
		color: #fff;
		padding: 8px 20px;
		font-family: 'Montserrat', sans-self;
		border: none;
		font-size: 16px;
		margin-top: 20px;
		font-weight: 600;
		cursor: pointer;
	}

	.file-loader {
		background: #eee;
		border: 1px solid #ddd;
		padding: 20px;
		border-radius: 10px;
		max-width: 300px;
	}

	.dox-title {
		min-height: 50px !important;
		padding: 8px 20px !important;
	}

	/* .file-loader input[type="file"] {
		font-size: 15px;
		display: inline-flex;
		justify-content: start;
		align-items: center;
		margin-top: 5px;
		padding: 8px 15px;
		border-radius: 4px;
		color: #3858e9 !important;
		background-color: transparent !important;
		border: 3px solid #3858e9;
		border-radius: 3px;
		text-transform: uppercase;
	} */
</style>
<div class="quick-docs-wrapper">
	<div class="quick-docs-content">
		<h1 class="wp-heading-inline">Upload Documents</h1>
		<p>Allowed file types is PDF</p>
	</div>
	<div class="upload-form">
		<br>
		<div id="messageView" class="message-view" style="
			color:#fff;
			font-family: 'Montserrat', sans-serif;
			font-size: 18px;
			padding: 10px 40px;
			display: none;
			width: auto;
		">

		</div>
		<form class="form-container" id="quckUploadForm" enctype='multipart/form-data'>
			<p>
				<input type="text" name="doctitle" placeholder="Document Title ( optional )" class="dox-title">
				<br>
				if you are not using document title you can leave this field blank.
			</p>
			<br>
			<div class="file-loader">
				<input type="file" name="uploadDocument" class="default-fsile-input" />
			</div>
			<button type="submit" value="submit" id="quckUploadFormButton">Submit</button>
		</form>
	</div>
</div>