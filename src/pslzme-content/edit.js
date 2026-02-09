import { useBlockProps, InspectorControls, MediaUpload, MediaUploadCheck } from "@wordpress/block-editor";
import { Panel, PanelBody, Button, TextControl, TextareaControl, SelectControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import { useSelect } from "@wordpress/data";

export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps({});

	const pages = useSelect(
		(select) =>
			select("core").getEntityRecords("postType", "page", {
				per_page: -1,
				status: "publish",
			}),
		[],
	);

	const pageOptions = [
		{ label: __("Select personalized page", "pslzme"), value: 0 },
		...(pages
			? pages.map((page) => ({
					label: page.title.rendered,
					value: page.id,
				}))
			: []),
	];

	const imageSizeOptions = window.pslzmeGutenbergData?.imageSizes || [];

	return (
		<div {...blockProps}>
			<InspectorControls>
				<Panel>
					<PanelBody title={__("Personalized Content Section", "pslzme")}>
						<MediaUploadCheck>
							<MediaUpload
								onSelect={(image) => {
									setAttributes({ personalized_image: { id: image.id, url: image.url } });
								}}
								allowedTypes={["image/jpeg", "image/png", "image/svg"]}
								value={attributes.personalized_image.id}
								render={({ open }) => (
									<>
										{!attributes.personalized_image.id && (
											<Button isSecondary onClick={open}>
												{__("Pslzme content personalized image", "pslzme")}
											</Button>
										)}
										{!!attributes.personalized_image.id && attributes.personalized_image.id && (
											<>
												<img src={attributes.personalized_image.url} onClick={open} />
												<Button isLink isDestructive onClick={() => setAttributes({ personalized_image: { id: 0, url: "" } })}>
													{__("Delete image", "pslzme")}
												</Button>
											</>
										)}
									</>
								)}
							/>
						</MediaUploadCheck>

						<TextControl
							label={__("Pslzme content personalized image alt text", "pslzme")}
							value={attributes.personalized_image_alt}
							onChange={(value) => setAttributes({ personalized_image_alt: value })}
						/>

						<SelectControl
							label={__("Pslzme content personalized image size", "pslzme")}
							value={attributes.personalized_image_size}
							options={[...imageSizeOptions]}
							onChange={(value) => setAttributes({ personalized_image_size: value })}
						/>

						<TextareaControl
							label={__("Pslzme content personalized image caption", "pslzme")}
							rows={2}
							value={attributes.personalized_image_caption}
							onChange={(value) => setAttributes({ personalized_image_caption: value })}
						/>

						<SelectControl
							label={__("Pslzme content personalized image link", "pslzme")}
							value={attributes.personalized_image_link}
							options={pageOptions}
							onChange={(value) =>
								setAttributes({
									personalized_image_link: parseInt(value),
								})
							}
						/>
					</PanelBody>
				</Panel>
			</InspectorControls>
		</div>
	);
}
