import { useBlockProps, RichText } from "@wordpress/block-editor";

export default function Save({ attributes }) {
	const blockProps = useBlockProps.save();

	return (
		<div {...blockProps}>
			<RichText.Content tagName="div" className="pslzme-text-content" value={attributes.personalized_text} />
		</div>
	);
}
