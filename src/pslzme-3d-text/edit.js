import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import {
	Panel,
	PanelBody,
	TextareaControl,
	ColorPicker,
	CustomSelectControl,
	Flex,
	FlexItem,
	__experimentalSpacer as Spacer,
	__experimentalNumberControl as NumberControl,
} from "@wordpress/components";
import { __ } from "@wordpress/i18n";

export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps();

	const rotationOptions = [
		{
			key: "left",
			name: "Left",
		},
		{
			key: "right",
			name: "Right",
		},
	];

	const boolOptions = [
		{
			key: "no",
			name: __("No", "pslzme"),
		},
		{
			key: "yes",
			name: __("Yes", "pslzme"),
		},
	];

	return (
		<div {...blockProps}>
			<InspectorControls>
				<Panel>
					<PanelBody title={__("Pslzme 3D Text configuration", "pslzme")}>
						<TextareaControl
							label={__("Pslzme 3D personalized text", "pslzme")}
							value={attributes.personalized_3d_text}
							onChange={(value) => setAttributes({ personalized_3d_text: value })}
						/>

						<TextareaControl
							label={__("Pslzme 3D unpersonalized text", "pslzme")}
							value={attributes.unpersonalized_3d_text}
							onChange={(value) => setAttributes({ unpersonalized_3d_text: value })}
						/>
					</PanelBody>

					<PanelBody title={__("Pslzme 3D Text camera configuration", "pslzme")} initialOpen={false}>
						<CustomSelectControl
							label={__("Pslzme 3D ui enabled", "pslzme")}
							options={boolOptions}
							value={attributes.debug_ui_enabled}
							onChange={(value) => setAttributes({ debug_ui_enabled: value.selectedItem.key })}
						/>

						<Spacer marginY={5} />

						<NumberControl
							label={__("Pslzme 3D camera position x", "pslzme")}
							value={attributes.camera_position_x}
							min={0}
							max={500}
							onChange={(value) => setAttributes({ camera_position_x: value })}
						/>
						<NumberControl
							label={__("Pslzme 3D camera position y", "pslzme")}
							value={attributes.camera_position_y}
							min={0}
							max={500}
							onChange={(value) => setAttributes({ camera_position_y: value })}
						/>
						<NumberControl
							label={__("Pslzme 3D camera position z", "pslzme")}
							value={attributes.camera_position_z}
							min={0}
							max={1000}
							onChange={(value) => setAttributes({ camera_position_z: value })}
						/>

						<NumberControl
							label={__("Pslzme 3D camera target x", "pslzme")}
							value={attributes.camera_target_x}
							min={0}
							max={500}
							onChange={(value) => setAttributes({ camera_target_x: value })}
						/>

						<NumberControl
							label={__("Pslzme 3D camera target y", "pslzme")}
							value={attributes.camera_target_y}
							min={0}
							max={500}
							onChange={(value) => setAttributes({ camera_target_y: value })}
						/>

						<NumberControl
							label={__("Pslzme 3D camera target z", "pslzme")}
							value={attributes.camera_target_z}
							min={0}
							max={500}
							onChange={(value) => setAttributes({ camera_target_z: value })}
						/>
					</PanelBody>

					<PanelBody title={__("Pslzme 3D Text custom options", "pslzme")} initialOpen={false}>
						<CustomSelectControl
							label={__("Pslzme 3D fog enabled", "pslzme")}
							options={boolOptions}
							value={attributes.fog_enabled}
							onChange={(value) => setAttributes({ fog_enabled: value.selectedItem.key })}
						/>

						<Spacer marginY={5} />

						{attributes.fog_enabled === "yes" && (
							<ColorPicker
								label={__("Pslzme 3D fog color", "pslzme")}
								color={attributes.fog_color}
								onChangeComplete={(value) => setAttributes({ fog_color: value.hex })}
							/>
						)}

						<Spacer marginY={5} />

						<CustomSelectControl
							label={__("Pslzme 3D mirrored text", "pslzme")}
							options={boolOptions}
							value={attributes.mirrored_text}
							onChange={(value) => setAttributes({ mirrored_text: value.selectedItem.key })}
						/>

						<Spacer marginY={5} />

						<CustomSelectControl
							label={__("Pslzme 3D draggable", "pslzme")}
							options={boolOptions}
							value={attributes.text_draggable}
							onChange={(value) => setAttributes({ text_draggable: value.selectedItem.key })}
						/>

						<Spacer marginY={5} />

						<CustomSelectControl
							label={__("Pslzme 3D moving light", "pslzme")}
							options={boolOptions}
							value={attributes.moving_light_enabled}
							onChange={(value) => setAttributes({ moving_light_enabled: value.selectedItem.key })}
						/>

						<Spacer marginY={5} />

						<CustomSelectControl
							label={__("Pslzme 3D rotation", "pslzme")}
							options={boolOptions}
							value={attributes.text_rotation}
							onChange={(value) => {
								setAttributes({ text_rotation: value.selectedItem.key });
							}}
						/>

						{attributes.text_rotation === "yes" && (
							<CustomSelectControl
								label={__("Pslzme 3D rotation direction", "pslzme")}
								options={rotationOptions}
								value={attributes.rotation_direction}
								onChange={(value) => setAttributes({ rotation_direction: value.selectedItem.key })}
							/>
						)}

						<Spacer marginY={5} />

						<CustomSelectControl
							label={__("Pslzme 3D floor enabled", "pslzme")}
							options={boolOptions}
							value={attributes.floor_enabled}
							onChange={(value) => setAttributes({ floor_enabled: value.selectedItem.key })}
						/>

						<Spacer marginY={5} />
					</PanelBody>
				</Panel>
			</InspectorControls>

			<InspectorControls group="styles">
				<Panel>
					<PanelBody title={__("Pslzme 3D Text color configuration", "pslzme")} initialOpen={false}>
						<div>
							<strong>{__("Pslzme 3D scene background color", "pslzme")}</strong>
							<Spacer marginY={3} />
							<ColorPicker color={attributes.background_color || "#222222"} onChangeComplete={(value) => setAttributes({ background_color: value.hex })} />
						</div>

						<Spacer marginY={5} />

						<div>
							<strong>{__("Pslzme 3D highlight color 1", "pslzme")}</strong>
							<Spacer marginY={3} />
							<ColorPicker
								color={attributes.highlight_color_one || "#a4dd46"}
								onChangeComplete={(value) => setAttributes({ highlight_color_one: value.hex })}
							/>
						</div>

						<Spacer marginY={5} />

						<div>
							<strong>{__("Pslzme 3D highlight color 2", "pslzme")}</strong>
							<Spacer marginY={3} />
							<ColorPicker
								color={attributes.highlight_color_two || "#0000ff"}
								onChangeComplete={(value) => setAttributes({ highlight_color_two: value.hex })}
							/>
						</div>

						<Spacer marginY={5} />

						<div>
							<strong>{__("Pslzme 3D highlight color 3", "pslzme")}</strong>#
							<Spacer marginY={3} />
							<ColorPicker
								color={attributes.highlight_color_three || "#ff0000"}
								onChangeComplete={(value) => setAttributes({ highlight_color_three: value.hex })}
							/>
						</div>
					</PanelBody>
					<PanelBody title={__("Pslzme 3D Text border radius", "pslzme")} initialOpen={false}>
						<Flex>
							<FlexItem>
								<NumberControl
									label={__("Pslzme 3D container border radius top left", "pslzme")}
									value={attributes.container_border_top_left_radius}
									onChange={(value) => setAttributes({ container_border_top_left_radius: value })}
								/>
							</FlexItem>

							<FlexItem>
								<NumberControl
									label={__("Pslzme 3D container border radius top right", "pslzme")}
									value={attributes.container_border_top_right_radius}
									onChange={(value) => setAttributes({ container_border_top_right_radius: value })}
								/>
							</FlexItem>

							<FlexItem>
								<NumberControl
									label={__("Pslzme 3D container border radius bottom left", "pslzme")}
									value={attributes.container_border_bottom_left_radius}
									onChange={(value) => setAttributes({ container_border_bottom_left_radius: value })}
								/>
							</FlexItem>

							<FlexItem>
								<NumberControl
									label={__("Pslzme 3D container border radius bottom right", "pslzme")}
									value={attributes.container_border_bottom_right_radius}
									onChange={(value) => setAttributes({ container_border_bottom_right_radius: value })}
								/>
							</FlexItem>
						</Flex>
					</PanelBody>
				</Panel>
			</InspectorControls>

			<h1>Pslzme 3D Text</h1>
			<div
				className="pslzme-3d-text-placeholder"
				style={{
					backgroundColor: attributes.background_color || "#222222",
					height: "500px",
				}}></div>
		</div>
	);
}
