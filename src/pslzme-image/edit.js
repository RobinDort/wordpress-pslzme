import { useBlockProps, InspectorControls, MediaUpload, MediaUploadCheck } from "@wordpress/block-editor";
import { Panel, PanelBody, TextControl, SelectControl, Flex, FlexItem, Button, __experimentalSpacer as Spacer } from "@wordpress/components";
import { __ } from "@wordpress/i18n";

export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps({});

	const imageSizeOptions = window.pslzmeGutenbergData?.imageSizes || [];

	return (
		<div {...blockProps}>
			<InspectorControls>
				<Panel>
					<PanelBody title={__("Pslzme Image Section", "pslzme")} initialOpen={true}>
						<TextControl
							label={__("Personalized Text", "pslzme")}
							value={attributes.personalized_text}
							onChange={(value) => setAttributes({ personalized_text: value })}
						/>
						<TextControl
							label={__("Unpersonalized Text", "pslzme")}
							value={attributes.unpersonalized_text}
							onChange={(value) => setAttributes({ unpersonalized_text: value })}
						/>
						<Flex expanded>
							<FlexItem>
								<TextControl
									label={__("Pslzme image dimension Top", "pslzme")}
									value={attributes.image_dimension_top}
									onChange={(value) => setAttributes({ image_dimension_top: value })}
								/>
							</FlexItem>
							<FlexItem>
								<TextControl
									label={__("Pslzme image dimension Right", "pslzme")}
									value={attributes.image_dimension_right}
									onChange={(value) => setAttributes({ image_dimension_right: value })}
								/>
							</FlexItem>
							<FlexItem>
								<TextControl
									label={__("Pslzme image dimension Bottom", "pslzme")}
									value={attributes.image_dimension_bottom}
									onChange={(value) => setAttributes({ image_dimension_bottom: value })}
								/>
							</FlexItem>
							<FlexItem>
								<TextControl
									label={__("Pslzme image dimension Left", "pslzme")}
									value={attributes.image_dimension_left}
									onChange={(value) => setAttributes({ image_dimension_left: value })}
								/>
							</FlexItem>
							<FlexItem>
								<SelectControl
									label={__("Pslzme image dimension Unit", "pslzme")}
									value={attributes.image_dimension_unit}
									options={[
										{ label: "px", value: "px" },
										{ label: "%", value: "%" },
										{ label: "em", value: "em" },
										{ label: "rem", value: "rem" },
									]}
									onChange={(value) => setAttributes({ image_dimension_unit: value })}
								/>
							</FlexItem>
						</Flex>

						<Spacer marginY={5} />

						<MediaUploadCheck>
							<MediaUpload
								onSelect={(media) => setAttributes({ background_image: { id: media.id, url: media.url } })}
								allowedTypes={["image/jpeg", "image/png", "image/svg"]}
								value={attributes.background_image.id}
								render={({ open }) => (
									<>
										{!attributes.background_image.id && (
											<Button variant="primary" onClick={open}>
												{__("Pslzme image background", "pslzme")}
											</Button>
										)}
										{!!attributes.background_image.id && (
											<>
												<img src={attributes.background_image.url} onClick={open} style={{ maxWidth: "100%" }} />
												<Button isLink isDestructive onClick={() => setAttributes({ background_image: { id: 0, url: "" } })}>
													{__("Delete Background Image", "pslzme")}
												</Button>
											</>
										)}
									</>
								)}
							/>
						</MediaUploadCheck>

						<Spacer marginY={5} />

						<SelectControl
							label={__("Pslzme image background size", "pslzme")}
							value={attributes.background_image_size}
							options={[...imageSizeOptions]}
							onChange={(value) => setAttributes({ background_image_size: value })}
						/>

						<TextControl
							label={__("Pslzme image background alt text", "pslzme")}
							value={attributes.background_image_alt}
							onChange={(value) => setAttributes({ background_image_alt: value })}
						/>

						<TextControl
							label={__("Pslzme image background title", "pslzme")}
							value={attributes.background_image_title}
							onChange={(value) => setAttributes({ background_image_title: value })}
						/>

						<MediaUploadCheck>
							<MediaUpload
								onSelect={(media) => setAttributes({ foreground_image: { id: media.id, url: media.url } })}
								allowedTypes={["image/jpeg", "image/png", "image/svg"]}
								value={attributes.foreground_image.id}
								render={({ open }) => (
									<>
										{!attributes.foreground_image.id && (
											<Button variant="primary" onClick={open}>
												{__("Pslzme image foreground", "pslzme")}
											</Button>
										)}
										{!!attributes.foreground_image.id && (
											<>
												<img src={attributes.foreground_image.url} onClick={open} style={{ maxWidth: "100%" }} />
												<Button isLink isDestructive onClick={() => setAttributes({ foreground_image: { id: 0, url: "" } })}>
													{__("Delete Foreground Image", "pslzme")}
												</Button>
											</>
										)}
									</>
								)}
							/>
						</MediaUploadCheck>

						<Spacer marginY={5} />

						<SelectControl
							label={__("Pslzme image foreground size", "pslzme")}
							value={attributes.foreground_image_size}
							options={[...imageSizeOptions]}
							onChange={(value) => setAttributes({ foreground_image_size: value })}
						/>

						<TextControl
							label={__("Pslzme image foreground alt text", "pslzme")}
							value={attributes.foreground_image_alt}
							onChange={(value) => setAttributes({ foreground_image_alt: value })}
						/>

						<TextControl
							label={__("Pslzme image foreground title", "pslzme")}
							value={attributes.foreground_image_title}
							onChange={(value) => setAttributes({ foreground_image_title: value })}
						/>
					</PanelBody>
				</Panel>
			</InspectorControls>
		</div>
	);
}
