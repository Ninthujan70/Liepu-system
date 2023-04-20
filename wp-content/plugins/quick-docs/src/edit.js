import { __ } from "@wordpress/i18n";
import { useBlockProps, RichText, insertBlocksAfter } from "@wordpress/block-editor";
import { useDispatch } from "@wordpress/data";
import { useEffect } from "react";
const { Button, Card, CardHeader, CardBody } = wp.components;

import "./editor.scss";

export default function Edit({ attributes: { searchText, allContents }, setAttributes, clientId }) {
	const dispatch = useDispatch();

	const getApiPostItem = (term) => {
		// Make the request to the WordPress REST API to retrieve the page content
		wp.apiFetch({ path: `/quick-doc/api/documents/${term}` })
			.then((data) => {
				// Extract the content of the first (and only) page in the response
				const htmlString = data ? data.content_render : "";

				const parser = new DOMParser();
				const doc = parser.parseFromString(htmlString, "text/html");

				// Select all paragraph elements from the Document object
				const paragraphs = doc.querySelectorAll("p");

				// Convert the paragraph elements into an array of strings
				const paragraphStrings = Array.from(paragraphs).map((p) => p.textContent.trim());

				setAttributes({ allContents: paragraphStrings });
				console.log(paragraphStrings);
				// setPageContent(content);
			})
			.catch((error) => {
				// console.log(error);
				setAttributes({ allContents: [] });
			});
	};

	const onCLickItem = (cnt) => {
		const newBlock = wp.blocks.createBlock("core/paragraph", { content: cnt });

		const currentBlockIndex = wp.data.select("core/block-editor").getBlockIndex(clientId);
		wp.data.dispatch("core/block-editor").insertBlock(newBlock, currentBlockIndex);
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
							{allContents.map((item, i) => (
								<li key={i} className="custom-li">
									<Card>
										<CardHeader>
											<p>Paragraph - {i + 1}</p>
											<Button variant="secondary" onClick={() => onCLickItem(item)}>
												{__("Add to Page", "")}
											</Button>
										</CardHeader>
										<CardBody>
											<p>{shortContent(item)}</p>
										</CardBody>
									</Card>
								</li>
							))}
							{allContents.length == 0 ? <li className="no-content">No any contents Found under the Page ID: {searchText}</li> : ""}
						</ul>
					</div>
				</div>
			</div>
		</>,
	];
}
