import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import Edit from "./edit";
import metadata from "./block.json";
import "./index.css";

registerBlockType(metadata.name, {
	title: metadata.title,
	icon: metadata.icon,
	category: metadata.category,
	attributes: metadata.attributes,
	edit: Edit,
});
