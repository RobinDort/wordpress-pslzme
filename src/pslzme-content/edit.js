import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { Panel, PanelBody } from "@wordpress/components";
import { __ } from "@wordpress/i18n";

export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps({});

	return (
		<div {...blockProps}>
			<InspectorControls>
				<Panel>
					<PanelBody title={__("Personalized Content Section", "pslzme")}></PanelBody>
				</Panel>
			</InspectorControls>
		</div>
	);
}
