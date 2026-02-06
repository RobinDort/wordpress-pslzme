import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import Edit from "./edit";
import Save from "./save";
import metadata from "./block.json";

registerBlockType(metadata.name, {
	title: metadata.title,
	icon: metadata.icon,
	category: metadata.category,
	attributes: metadata.attributes,
	edit: Edit,
	save: Save,
});
