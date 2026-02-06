import { useBlockProps, InspectorControls, RichText } from "@wordpress/block-editor";
import { Panel, PanelBody } from "@wordpress/components";
import { __ } from "@wordpress/i18n";

export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps({});
	return (
		<div {...blockProps}>
			<InspectorControls>
				<Panel>
					<PanelBody title={__("Personalized Text Section", "pslzme")}></PanelBody>
				</Panel>
			</InspectorControls>

			<RichText
				tagName="div"
				className="pslzme-text-content"
				value={attributes.personalized_text}
				onChange={(value) => setAttributes({ personalized_text: value })}
				allowedFormats={["core/bold", "core/italic", "core/link"]}
			/>
		</div>
	);
}
