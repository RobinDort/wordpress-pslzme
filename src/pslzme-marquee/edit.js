import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { Panel, PanelBody, TextareaControl, NumberControl, ColorPicker, Flex, FlexItem } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import { NumberController } from "lil-gui";

export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps({});

	const unitOptions = ["px", "%", "em", "rem", "vw", "vh"];

	return (
		<div {...blockProps}>
			<InspectorControls>
				<Panel>
					<PanelBody label={__("Personalized Text Section", "pslzme")}>
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
					<PanelBody label={__("Pslzme marquee style section", "pslzme")}>
						<ColorPicker label={__("Marquee Text Color", "pslzme")} color={attributes.text_color} onChange={(color) => setAttributes({ text_color: color })} />

						<ColorPicker
							label={__("Marquee Background Color", "pslzme")}
							color={attributes.background_color}
							onChange={(color) => setAttributes({ background_color: color })}
						/>

						<Flex>
							<FlexItem>
								<NumberControl
									label={__("Marquee container height", "pslzme")}
									value={attributes.container_height}
									onChange={(value) => setAttributes({ container_height: value })}
								/>
							</FlexItem>

							<FlexItem>
								<CustomSelectControl
									label={__("Pslzme 3D rotation", "pslzme")}
									options={unitOptions}
									value={attributes.container_height_unit}
									onChange={(value) => {
										setAttributes({ container_height_unit: value.selectedItem });
									}}
								/>
							</FlexItem>
						</Flex>
					</PanelBody>
				</Panel>
			</InspectorControls>
		</div>
	);
}
