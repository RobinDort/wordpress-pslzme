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

export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps({});

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
					<PanelBody title={__("Pslzme marquee style section", "pslzme")}>
						<div>
							<strong>{__("Marquee Text Color", "pslzme")}</strong>
							<Spacer marginY={3} />
							<ColorPicker color={attributes.text_color} onChangeComplete={(color) => setAttributes({ text_color: color.hex })} />
						</div>

						<div>
							<strong>{__("Marquee Background Color", "pslzme")}</strong>
							<ColorPicker color={attributes.background_color} onChangeComplete={(color) => setAttributes({ background_color: color.hex })} />
						</div>

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

						<Spacer marginY={5} />

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
						<div
							className="pslzme-marquee-item"
							style={{
								fontSize: attributes.text_font_size ? `${attributes.text_font_size}${attributes.text_font_size_unit || "px"}` : undefined,
								color: attributes.text_color,
							}}>
							<p>{attributes.unpersonalized_text}</p>
						</div>
						<div
							className="pslzme-marquee-item"
							style={{
								fontSize: attributes.text_font_size ? `${attributes.text_font_size}${attributes.text_font_size_unit || "px"}` : undefined,
								color: attributes.text_color,
							}}>
							<p>{attributes.unpersonalized_text}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	);
}
