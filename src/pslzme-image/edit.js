import { useBlockProps } from "@wordpress/block-editor";

export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps({});

	return <div {...blockProps}></div>;
}
