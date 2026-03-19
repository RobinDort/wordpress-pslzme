import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import {
	Panel,
	PanelBody,
	TextareaControl,
	ColorPicker,
	SelectControl,
	Flex,
	FlexItem,
	__experimentalSpacer as Spacer,
	__experimentalNumberControl as NumberControl,
} from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import { useState } from "react";

export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps({});
	const [TagName, setTagName] = useState(attributes.text_element || "p");

	return (
		<div {...blockProps}>
			<InspectorControls>
				<Panel>
					<PanelBody title={__("Personalized Text Section", "pslzme")}>
						<TextareaControl
							label={__("Personalized Text", "pslzme")}
							value={attributes.personalized_text}
							onChange={(value) => setAttributes({ personalized_text: value })}
						/>

						<TextareaControl
							label={__("Unpersonalized Text", "pslzme")}
							value={attributes.unpersonalized_text}
							onChange={(value) => setAttributes({ unpersonalized_text: value })}
						/>
					</PanelBody>
				</Panel>
			</InspectorControls>

			<InspectorControls group="styles">
				<Panel>
					<PanelBody title={__("Pslzme marquee color styles", "pslzme")}>
						<div>
							<strong>{__("Marquee Text Color", "pslzme")}</strong>
							<Spacer marginY={3} />
							<ColorPicker color={attributes.text_color} onChangeComplete={(color) => setAttributes({ text_color: color.hex })} />
						</div>

						<div>
							<strong>{__("Marquee Background Color", "pslzme")}</strong>
							<ColorPicker color={attributes.background_color} onChangeComplete={(color) => setAttributes({ background_color: color.hex })} />
						</div>
					</PanelBody>

					<PanelBody title={__("Pslzme marquee text styles ", "pslzme")} initialOpen={false}>
						<Flex>
							<FlexItem>
								<NumberControl
									label={__("Marquee Text size", "pslzme")}
									value={attributes.text_font_size}
									onChange={(value) => setAttributes({ text_font_size: value })}
								/>
							</FlexItem>

							<FlexItem>
								<SelectControl
									label={__("Marquee Text size unit", "pslzme")}
									value={attributes.text_font_size_unit}
									options={[
										{ label: "px", value: "px" },
										{ label: "em", value: "em" },
										{ label: "rem", value: "rem" },
										{ label: "%", value: "%" },
										{ label: "vw", value: "vw" },
										{ label: "vh", value: "vh" },
									]}
									onChange={(selected) => setAttributes({ text_font_size_unit: selected })}
								/>
							</FlexItem>
						</Flex>

						<SelectControl
							label={__("Marquee Text element", "pslzme")}
							value={attributes.text_element}
							options={[
								{ label: "p", value: "p" },
								{ label: "span", value: "span" },
								{ label: "h1", value: "h1" },
								{ label: "h2", value: "h2" },
								{ label: "h3", value: "h3" },
								{ label: "h4", value: "h4" },
								{ label: "h5", value: "h6" },
								{ label: "h6", value: "h6" },
							]}
							onChange={(value) => {
								setTagName(value);
								setAttributes({ text_element: value });
							}}
						/>
					</PanelBody>

					<PanelBody title={__("Marquee container styles", "pslzme")} initialOpen={false}>
						<Flex>
							<FlexItem>
								<NumberControl
									label={__("Marquee container height", "pslzme")}
									value={attributes.container_height}
									onChange={(value) => setAttributes({ container_height: value })}
								/>
							</FlexItem>

							<FlexItem>
								<SelectControl
									label={__("Marquee container height unit", "pslzme")}
									value={attributes.container_height_unit}
									options={[
										{ label: "px", value: "px" },
										{ label: "em", value: "em" },
										{ label: "rem", value: "rem" },
										{ label: "%", value: "%" },
										{ label: "vw", value: "vw" },
										{ label: "vh", value: "vh" },
									]}
									onChange={(selected) => setAttributes({ container_height_unit: selected })}
								/>
							</FlexItem>
						</Flex>
					</PanelBody>
				</Panel>
			</InspectorControls>

			<div
				className="pslzme-marquee"
				style={{ height: attributes.container_height + (attributes.container_height_unit || "px"), backgroundColor: attributes.background_color }}>
				<div className="pslzme-marquee-text">
					<div className="pslzme-marquee-text-track">
						<div className="pslzme-marquee-item">
							<TagName
								style={{
									fontSize: attributes.text_font_size ? `${attributes.text_font_size}${attributes.text_font_size_unit || "px"}` : undefined,
									color: attributes.text_color,
								}}>
								{attributes.unpersonalized_text}
							</TagName>
						</div>
						<div className="pslzme-marquee-item">
							<TagName
								style={{
									fontSize: attributes.text_font_size ? `${attributes.text_font_size}${attributes.text_font_size_unit || "px"}` : undefined,
									color: attributes.text_color,
								}}>
								{attributes.unpersonalized_text}
							</TagName>
						</div>
					</div>
				</div>
			</div>
		</div>
	);
}
