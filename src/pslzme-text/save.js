import { useBlockProps } from "@wordpress/block-editor";

export default function Save() {
	const varsSet = window.pslzmeGutenbergData?.varsSet ?? false;
	console.log("Vars: " + varsSet);
	return <p {...useBlockProps.save()}>{"Example Static – hello from the saved content!"}</p>;
}
