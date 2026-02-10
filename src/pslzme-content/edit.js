import { useBlockProps, InspectorControls, MediaUpload, MediaUploadCheck } from "@wordpress/block-editor";
import { Panel, PanelBody, Button, TextControl, TextareaControl, SelectControl, CheckboxControl, __experimentalSpacer as Spacer } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import { useSelect } from "@wordpress/data";

export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps({});

	const pages = useSelect(
		(select) =>
			select("core").getEntityRecords("postType", "page", {
				per_page: -1,
				status: "publish",
			}),
		[],
	);

	const pageOptions = [
		{ label: __("Select personalized page", "pslzme"), value: 0 },
		...(pages
			? pages.map((page) => ({
					label: page.title.rendered,
					value: page.id,
				}))
			: []),
	];

	const videoOptions = [
		{ label: __("Autoplay", "pslzme"), value: "autoplay" },
		{ label: __("Hide control options", "pslzme"), value: "controls_hidden" },
		{ label: __("Play in loop", "pslzme"), value: "loop" },
		{ label: __("Inline play (no fullscreen mode)", "pslzme"), value: "playsinline" },
		{ label: __("Mute audio output", "pslzme"), value: "muted" },
	];

	const imageSizeOptions = window.pslzmeGutenbergData?.imageSizes || [];

	return (
		<div {...blockProps}>
			<InspectorControls>
				<Panel>
					<PanelBody>
						<SelectControl
							label={__("Pslzme content type", "pslzme")}
							value={attributes.content_type}
							options={[
								{ label: __("Image", "pslzme"), value: "image" },
								{ label: __("Video", "pslzme"), value: "video" },
							]}
							onChange={(value) => setAttributes({ content_type: value })}
						/>
					</PanelBody>
				</Panel>

				{attributes.content_type === "image" && (
					<Panel>
						<PanelBody title={__("Pslzme content personalized image settings", "pslzme")} initialOpen={false}>
							<MediaUploadCheck>
								<Spacer marginY={5} />
								<MediaUpload
									onSelect={(image) => {
										setAttributes({ personalized_image: { id: image.id, url: image.url } });
									}}
									allowedTypes={["image/jpeg", "image/png", "image/svg"]}
									value={attributes.personalized_image.id}
									render={({ open }) => (
										<>
											{!attributes.personalized_image.id && <Button onClick={open}>{__("Pslzme content personalized image", "pslzme")}</Button>}
											{!!attributes.personalized_image.id && attributes.personalized_image.id && (
												<>
													<img src={attributes.personalized_image.url} onClick={open} />
													<Button isDestructive onClick={() => setAttributes({ personalized_image: { id: 0, url: "" } })}>
														{__("Delete image", "pslzme")}
													</Button>
												</>
											)}
										</>
									)}
								/>
							</MediaUploadCheck>

							<Spacer marginY={5} />

							<TextControl
								label={__("Pslzme content personalized image alt text", "pslzme")}
								value={attributes.personalized_image_alt}
								onChange={(value) => setAttributes({ personalized_image_alt: value })}
							/>

							<SelectControl
								label={__("Pslzme content personalized image size", "pslzme")}
								value={attributes.personalized_image_size}
								options={[...imageSizeOptions]}
								onChange={(value) => setAttributes({ personalized_image_size: value })}
							/>

							<TextareaControl
								label={__("Pslzme content personalized image caption", "pslzme")}
								rows={2}
								value={attributes.personalized_image_caption}
								onChange={(value) => setAttributes({ personalized_image_caption: value })}
							/>

							<SelectControl
								label={__("Pslzme content personalized image link", "pslzme")}
								value={attributes.personalized_image_link}
								options={pageOptions}
								onChange={(value) =>
									setAttributes({
										personalized_image_link: parseInt(value),
									})
								}
							/>
						</PanelBody>

						<PanelBody title={__("Pslzme content unpersonalized image settings", "pslzme")} initialOpen={false}>
							<MediaUploadCheck>
								<Spacer marginY={5} />
								<MediaUpload
									onSelect={(image) => {
										setAttributes({ unpersonalized_image: { id: image.id, url: image.url } });
									}}
									allowedTypes={["image/jpeg", "image/png", "image/svg"]}
									value={attributes.unpersonalized_image.id}
									render={({ open }) => (
										<>
											{!attributes.unpersonalized_image.id && <Button onClick={open}>{__("Pslzme content unpersonalized image", "pslzme")}</Button>}
											{!!attributes.unpersonalized_image.id && attributes.unpersonalized_image.id && (
												<>
													<img src={attributes.unpersonalized_image.url} onClick={open} />
													<Button isLink isDestructive onClick={() => setAttributes({ unpersonalized_image: { id: 0, url: "" } })}>
														{__("Delete image", "pslzme")}
													</Button>
												</>
											)}
										</>
									)}
								/>
							</MediaUploadCheck>

							<Spacer marginY={5} />

							<TextControl
								label={__("Pslzme content unpersonalized image alt text", "pslzme")}
								value={attributes.unpersonalized_image_alt}
								onChange={(value) => setAttributes({ unpersonalized_image_alt: value })}
							/>

							<SelectControl
								label={__("Pslzme content unpersonalized image size", "pslzme")}
								value={attributes.unpersonalized_image_size}
								options={[...imageSizeOptions]}
								onChange={(value) => setAttributes({ unpersonalized_image_size: value })}
							/>

							<TextareaControl
								label={__("Pslzme content unpersonalized image caption", "pslzme")}
								rows={2}
								value={attributes.unpersonalized_image_caption}
								onChange={(value) => setAttributes({ unpersonalized_image_caption: value })}
							/>

							<SelectControl
								label={__("Pslzme content unpersonalized image link", "pslzme")}
								value={attributes.unpersonalized_image_link}
								options={pageOptions}
								onChange={(value) =>
									setAttributes({
										unpersonalized_image_link: parseInt(value),
									})
								}
							/>
						</PanelBody>
					</Panel>
				)}

				{attributes.content_type === "video" && (
					<Panel>
						<PanelBody title={__("Pslzme content personalized video settings", "pslzme")} initialOpen={false}>
							<MediaUploadCheck>
								<MediaUpload
									onSelect={(video) => {
										setAttributes({ personalized_video: { id: video.id, url: video.url } });
									}}
									allowedTypes={["video/mp4", "video/webm", "video/ogg"]}
									value={attributes.personalized_video.id}
									render={({ open }) => (
										<>
											{!attributes.personalized_video.id && (
												<Button isSecondary onClick={open}>
													{__("Pslzme content personalized video", "pslzme")}
												</Button>
											)}
											{!!attributes.personalized_video.id && attributes.personalized_video.id && (
												<>
													<video src={attributes.personalized_video.url} controls style={{ maxWidth: "100%" }} onClick={open} />
													<Button isLink isDestructive onClick={() => setAttributes({ personalized_video: { id: 0, url: "" } })}>
														{__("Delete video", "pslzme")}
													</Button>
												</>
											)}
										</>
									)}
								/>
							</MediaUploadCheck>

							<Spacer marginY={5} />

							<TextControl
								label={__("Pslzme content personalized video width", "pslzme")}
								value={attributes.personalized_video_width}
								onChange={(value) => setAttributes({ personalized_video_width: value })}
							/>

							<TextControl
								label={__("Pslzme content personalized video height", "pslzme")}
								value={attributes.personalized_video_height}
								onChange={(value) => setAttributes({ personalized_video_height: value })}
							/>

							{videoOptions.map((option) => (
								<CheckboxControl
									key={option.value}
									label={option.label}
									checked={attributes.personalized_video_options?.includes(option.value)}
									onChange={(checked) => {
										const current = attributes.personalized_video_options || [];

										setAttributes({
											personalized_video_options: checked ? [...current, option.value] : current.filter((v) => v !== option.value),
										});
									}}
								/>
							))}
						</PanelBody>

						<PanelBody title={__("Pslzme content unpersonalized video settings", "pslzme")} initialOpen={false}>
							<MediaUploadCheck>
								<Spacer marginY={5} />
								<MediaUpload
									onSelect={(video) => {
										setAttributes({ unpersonalized_video: { id: video.id, url: video.url } });
									}}
									allowedTypes={["video/mp4", "video/webm", "video/ogg"]}
									value={attributes.unpersonalized_video.id}
									render={({ open }) => (
										<>
											{!attributes.unpersonalized_video.id && (
												<Button isSecondary onClick={open}>
													{__("Pslzme content unpersonalized video", "pslzme")}
												</Button>
											)}
											{!!attributes.unpersonalized_video.id && attributes.unpersonalized_video.id && (
												<>
													<video src={attributes.unpersonalized_video.url} controls style={{ maxWidth: "100%" }} onClick={open} />
													<Button isLink isDestructive onClick={() => setAttributes({ unpersonalized_video: { id: 0, url: "" } })}>
														{__("Delete video", "pslzme")}
													</Button>
												</>
											)}
										</>
									)}
								/>
							</MediaUploadCheck>

							<Spacer marginY={5} />

							<TextControl
								label={__("Pslzme content unpersonalized video width", "pslzme")}
								value={attributes.unpersonalized_video_width}
								onChange={(value) => setAttributes({ unpersonalized_video_width: value })}
							/>

							<TextControl
								label={__("Pslzme content unpersonalized video height", "pslzme")}
								value={attributes.unpersonalized_video_height}
								onChange={(value) => setAttributes({ unpersonalized_video_height: value })}
							/>

							{videoOptions.map((option) => (
								<CheckboxControl
									key={option.value}
									label={option.label}
									checked={attributes.unpersonalized_video_options?.includes(option.value)}
									onChange={(checked) => {
										const current = attributes.unpersonalized_video_options || [];

										setAttributes({
											unpersonalized_video_options: checked ? [...current, option.value] : current.filter((v) => v !== option.value),
										});
									}}
								/>
							))}
						</PanelBody>
					</Panel>
				)}
			</InspectorControls>
		</div>
	);
}
