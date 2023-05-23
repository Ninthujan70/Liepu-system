import { __ } from "@wordpress/i18n";
import { useBlockProps, RichText, insertBlocksAfter } from "@wordpress/block-editor";
import { useDispatch } from "@wordpress/data";
import { useEffect } from "react";
const { Button, Card, CardHeader, CardBody } = wp.components;

import "./editor.scss";

export default function Edit({ attributes: { searchText, allContents, allPages }, setAttributes, clientId }) {
	const dispatch = useDispatch();

	const getApiPostItem = (term) => {
		// Make the request to the WordPress REST API to retrieve the page content
		wp.apiFetch({
			path: `/quick-doc/api/documents/`,
			method: "POST",
			data: {
				term: term, // The page slug
			},
		})
			.then((data) => {
				console.log(data, "data");
				if (data) {
					let paragraphStrings = [];

					data.forEach((page) => {
						// Extract the content of the first (and only) page in the response
						const htmlString = page ? page.content_render : "";

						const parser = new DOMParser();
						const doc = parser.parseFromString(htmlString, "text/html");

						// Select all paragraph elements from the Document object
						const paragraphs = doc.querySelectorAll("p");

						// Convert the paragraph elements into an array of strings
						const paragraphArray = Array.from(paragraphs).map((p) => [p.textContent.trim()]);

						// Concatenate the paragraph strings into the main array
						paragraphStrings = paragraphStrings.concat({"title":page.title, "id":page.id, paragraphArray});
					});
					setAttributes({ allPages: paragraphStrings });
				}
			})
			.catch((error) => {
				// console.log(error);
				setAttributes({ allPages: [] });
			});
	};

	const onCLickItem = (cnt) => {
		const newBlock = wp.blocks.createBlock("core/paragraph", { content: cnt });

		const currentBlockIndex = wp.data.select("core/block-editor").getBlockIndex(clientId);
		wp.data.dispatch("core/block-editor").insertBlock(newBlock, currentBlockIndex);
	};

	const selectPageFromList = (item) => {
		 setAttributes({allContents: item.paragraphArray});
		 setAttributes({ allPages: [] });
	};

	const shortContent = (cnt) => {
		const maxCharLength = 200;
		const escapedHtml = cnt.replace(/(<([^>]+)>)/gi, "");
		const shortenString = escapedHtml.length > maxCharLength ? escapedHtml.substring(0, maxCharLength).concat("...") : escapedHtml;
		return shortenString;
	};

	const closeDocument = () => {
		wp.data.dispatch("core/block-editor").removeBlock(clientId, false);
	};

	useEffect(() => {
		if (searchText) {
			getApiPostItem(searchText);
			setAttributes({ allContents: [] });
		}
	}, [searchText]);

	return [
		<>
			<div {...useBlockProps()}>
				<div className="fast-docs-wrapper">
					<div className="fast-docs-header">
						Add Content from Past Documents <span onClick={closeDocument}>Close</span>
					</div>
					<div className="fast-docs-content">
						<label className="doc-label">
							<b>Document Details</b>
						</label>
						<RichText
							placeholder={__("Enter Doc ID or Name")}
							value={searchText}
							onChange={(val) => {
								setAttributes({ searchText: val });
								getApiPostItem(val);
							}}
						/>
						<ul className="all-paragraphs">
							{allPages.map((item, i) => (
								<li key={i} className="custom-li">
									<Card onClick={() => selectPageFromList(item)}>
										<CardHeader>
											<p>Document Name: {item.title}</p>
											<p>
												Paragraph Count: <strong>{item.paragraphArray.length}</strong>
											</p>
										</CardHeader>
									</Card>
								</li>
							))}

							{allContents.map((item, i) => (
								<li key={i} className="custom-li">
									<Card>
										<CardHeader>
											<p>Paragraph - {i + 1}</p>
											<Button variant="secondary" onClick={() => onCLickItem(item[0])}>
												{__("Add to Page", "")}
											</Button>
										</CardHeader>
										<CardBody>
											<p>{shortContent(item[0])}</p>
										</CardBody>
									</Card>
								</li>
							))}
							{allPages.length == 0 && allContents.length == 0 ? <li className="no-content">No any Pages Found under the Search: {searchText}</li> : ""}
						</ul>
					</div>
				</div>
			</div>
		</>,
	];
}
