import {
	useBlockProps,
	InspectorControls,
	MediaUpload,
	MediaUploadCheck,
	RichText,
	BlockControls,
	AlignmentToolbar,
	FontSizePicker,
	ColorPalette,
} from "@wordpress/block-editor";
import {
	Panel,
	PanelBody,
	TextControl,
	SelectControl,
	BaseControl,
	Flex,
	FlexItem,
	Button,
	RangeControl,
	__experimentalSpacer as Spacer,
} from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import { useState } from "@wordpress/element";

export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps({});

	const [activeEditor, setActiveEditor] = useState(null);

	const imageSizeOptions = window.pslzmeGutenbergData?.imageSizes || [];

	return (
		<div {...blockProps}>
			<InspectorControls group="settings">
				<Panel>
					<PanelBody title={__("Pslzme Image Section", "pslzme")} initialOpen={true}>
						<FontSizePicker
							value={activeEditor === "personalized" ? attributes.personalized_text_font_size : attributes.unpersonalized_text_font_size}
							onChange={(value) =>
								activeEditor === "personalized"
									? setAttributes({ personalized_text_font_size: value })
									: setAttributes({ unpersonalized_text_font_size: value })
							}
							disableCustomFontSizes={false}
						/>

						<Spacer marginY={5} />

						<ColorPalette
							value={activeEditor === "personalized" ? attributes.personalized_text_color : attributes.unpersonalized_text_color}
							onChange={(value) =>
								activeEditor === "personalized" ? setAttributes({ personalized_text_color: value }) : setAttributes({ unpersonalized_text_color: value })
							}
						/>

						<Spacer marginY={5} />

						<BaseControl label={__("Pslzme image container spacing", "pslzme")}>
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
							</Flex>
						</BaseControl>

						<Spacer marginY={5} />

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

						<Spacer marginY={10} />

						<BaseControl label={__("Pslzme image text spacing", "pslzme")}>
							<Flex expanded>
								<FlexItem>
									<TextControl
										label={__("Pslzme text dimension Top", "pslzme")}
										value={attributes.text_dimension_top}
										onChange={(value) => setAttributes({ text_dimension_top: value })}
									/>
								</FlexItem>
								<FlexItem>
									<TextControl
										label={__("Pslzme text dimension Right", "pslzme")}
										value={attributes.text_dimension_right}
										onChange={(value) => setAttributes({ text_dimension_right: value })}
									/>
								</FlexItem>
								<FlexItem>
									<TextControl
										label={__("Pslzme text dimension Bottom", "pslzme")}
										value={attributes.text_dimension_bottom}
										onChange={(value) => setAttributes({ text_dimension_bottom: value })}
									/>
								</FlexItem>
								<FlexItem>
									<TextControl
										label={__("Pslzme text dimension Left", "pslzme")}
										value={attributes.text_dimension_left}
										onChange={(value) => setAttributes({ text_dimension_left: value })}
									/>
								</FlexItem>
							</Flex>
						</BaseControl>

						<Spacer marginY={5} />

						<SelectControl
							label={__("Pslzme text dimension Unit", "pslzme")}
							value={attributes.image_dimension_unit}
							options={[
								{ label: "px", value: "px" },
								{ label: "%", value: "%" },
								{ label: "em", value: "em" },
								{ label: "rem", value: "rem" },
							]}
							onChange={(value) => setAttributes({ text_dimension_unit: value })}
						/>

						<Spacer marginY={10} />

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

						<Spacer marginY={10} />

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

			<InspectorControls group="styles">
				<Panel>
					<PanelBody title={__("Pslzme 3D image styles", "pslzme")} initialOpen={true}>
						<RangeControl
							label={__("Pslzme image container width", "pslzme")}
							value={attributes.image_container_width}
							onChange={(value) => setAttributes({ image_container_width: value })}
							min={0}
							max={2000}
						/>

						<RangeControl
							label={__("Pslzme 3D image container max width", "pslzme")}
							value={attributes.image_container_max_width}
							onChange={(value) => setAttributes({ image_container_max_width: value })}
							min={0}
							max={2000}
						/>

						<RangeControl
							label={__("Pslzme 3D image container height", "pslzme")}
							value={attributes.image_container_height}
							onChange={(value) => setAttributes({ image_container_height: value })}
							min={0}
							max={2000}
						/>

						<Flex>
							<FlexItem>
								<TextControl
									label={__("Pslzme image container border radius top-left", "pslzme")}
									value={attributes.image_container_border_radius_top_left}
									onChange={(value) => setAttributes({ image_container_border_radius_top_left: value })}
								/>
							</FlexItem>
							<FlexItem>
								<TextControl
									label={__("Pslzme image container border radius top-right", "pslzme")}
									value={attributes.image_container_border_radius_top_right}
									onChange={(value) => setAttributes({ image_container_border_radius_top_right: value })}
								/>
							</FlexItem>
							<FlexItem>
								<TextControl
									label={__("Pslzme image container border radius bottom-right", "pslzme")}
									value={attributes.image_container_border_radius_bottom_right}
									onChange={(value) => setAttributes({ image_container_border_radius_bottom_right: value })}
								/>
							</FlexItem>
							<FlexItem>
								<TextControl
									label={__("Pslzme image container border radius bottom-left", "pslzme")}
									value={attributes.image_container_border_radius_bottom_left}
									onChange={(value) => setAttributes({ image_container_border_radius_bottom_left: value })}
								/>
							</FlexItem>
						</Flex>
					</PanelBody>
				</Panel>
			</InspectorControls>

			<h1>{__("Pslzme Image Widget", "pslzme")}</h1>
			<BlockControls>
				{activeEditor && (
					<AlignmentToolbar
						value={activeEditor === "personalized" ? attributes.personalized_text_alignment : attributes.unpersonalized_text_alignment}
						onChange={(value) =>
							activeEditor === "personalized" ? setAttributes({ personalized_text_alignment: value }) : setAttributes({ unpersonalized_text_alignment: value })
						}
					/>
				)}
			</BlockControls>

			<div className="pslzme-richtext-wrapper">
				<h1>{__("Personalized Text", "pslzme")}</h1>
				<RichText
					tagName="div"
					value={attributes.personalized_text}
					style={{
						textAlign: attributes.personalized_text_alignment,
						fontSize: attributes.personalized_text_font_size,
						color: attributes.personalized_text_color,
					}}
					onChange={(value) => setAttributes({ personalized_text: value })}
					onFocus={() => setActiveEditor("personalized")}
				/>
			</div>

			<div className="pslzme-richtext-wrapper">
				<h1>{__("Unpersonalized Text", "pslzme")}</h1>
				<RichText
					tagName="div"
					value={attributes.unpersonalized_text}
					style={{
						textAlign: attributes.unpersonalized_text_alignment,
						fontSize: attributes.unpersonalized_text_font_size,
						color: attributes.unpersonalized_text_color,
					}}
					onChange={(value) => setAttributes({ unpersonalized_text: value })}
					onFocus={() => setActiveEditor("unpersonalized")}
				/>
			</div>

			<div
				className="pslzme-ov-image-container"
				style={{
					margin: `
						${attributes.image_dimension_top}${attributes.image_dimension_unit}
						${attributes.image_dimension_right}${attributes.image_dimension_unit}
						${attributes.image_dimension_bottom}${attributes.image_dimension_unit}
						${attributes.image_dimension_left}${attributes.image_dimension_unit}`,
					width: attributes.image_container_width ? `${attributes.image_container_width}px` : "auto",
					maxWidth: attributes.image_container_max_width ? `${attributes.image_container_max_width}px` : "none",
					height: attributes.image_container_height ? `${attributes.image_container_height}px` : "auto",
				}}>
				<div className="pslzme-background-figure">
					{attributes.background_image?.url && (
						<img
							src={attributes.background_image.url}
							style={{
								borderRadius: `${attributes.image_container_border_radius_top_left}px
								 ${attributes.image_container_border_radius_top_right}px
								 ${attributes.image_container_border_radius_bottom_right}px
								 ${attributes.image_container_border_radius_bottom_left}px
								`,
							}}
						/>
					)}
				</div>
				<div
					className="ce_text block layered-text"
					style={{
						textAlign: attributes.unpersonalized_text_alignment || "left",
						fontSize: attributes.unpersonalized_text_font_size,
						color: attributes.unpersonalized_text_color,
						marginTop: `${attributes.text_dimension_top}${attributes.text_dimension_unit}`,
						marginRight: `${attributes.text_dimension_right}${attributes.text_dimension_unit}`,
						marginBottom: `${attributes.text_dimension_bottom}${attributes.text_dimension_unit}`,
						marginLeft: `${attributes.text_dimension_left}${attributes.text_dimension_unit}`,
					}}>
					{attributes.unpersonalized_text}
				</div>

				<div className="pslzme-foreground-figure">{attributes.foreground_image?.url && <img src={attributes.foreground_image.url} />}</div>
			</div>
		</div>
	);
}
