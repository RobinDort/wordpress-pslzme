import { useBlockProps, InspectorControls, RichText } from "@wordpress/block-editor";
import { Panel, PanelBody, CheckboxControl, TextareaControl } from "@wordpress/components";
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
					</PanelBody>
				</Panel>
				<Panel>
					<PanelBody title={__("Unpersonalized Text Section", "pslzme")}>
						<TextareaControl
							label={__("Unpersonalized Text", "pslzme")}
							value={attributes.unpersonalized_text}
							onChange={(value) => setAttributes({ unpersonalized_text: value })}
						/>
						<CheckboxControl
							label={__("Show unpersonalized Text", "pslzme")}
							checked={attributes.show_unpersonalized_text}
							onChange={(checked) => setAttributes({ show_unpersonalized_text: checked })}
						/>
					</PanelBody>
				</Panel>
			</InspectorControls>

			<h1>{__("Pslzme Text Widget", "pslzme")}</h1>
			<RichText.Content tagName="div" value={attributes.unpersonalized_text} />
		</div>
	);
}
