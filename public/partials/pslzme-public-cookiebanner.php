<?php
$options = get_option('pslzme_settings', []);
$internal_pages = $options['internal_pages'] ?? [];

$imprint_id = ! empty($internal_pages['imprint']) ? (int) $internal_pages['imprint'] : 0;
$privacy_id = ! empty($internal_pages['privacy']) ? (int) $internal_pages['privacy'] : 0;
?>

<div id="pslzme-cookiebar">
		<div class="pslzme-cookiebar-inner">
			<div class="block">
				<button class="pslzme-cookiebar-close-btn btn-small icon-cancel" onClick="hideVisibility();"></button>
			</div>
			<div class="space-bottom20 block" style="text-align: center; width:100%">
				<img id="pslzme-logo"  src="<?= plugins_url('../images/pslzme_logo.svg', __FILE__); ?>"alt="<?php echo esc_attr__('PSLZME Logo', 'robindort-pslzme'); ?>" style="max-height: 80px;"/>
			</div>
			<div class="pslzme-cookiebar-description ce_text block">
				<h4 class="pslzme-heading"><?= __("pslzme cookiebar heading 1", "pslzme") ?></h4>
				<h4 class="pslzme-heading"><?= wp_kses(__("pslzme cookiebar heading 2", "pslzme"), ['span' => ['id' => []], 'b'    => []]) ?></h4>
                <p><?= __("pslzme cookiebar explanation 1", "pslzme") ?></p>
                <p><?= wp_kses(__("pslzme cookiebar explanation 2", "pslzme"), ['strong' => [], "b" => []]) ?>
                </p>

			</div>
			<div class="pslzme-cookiebar-footer block">
				<div id="name-verifiyer" data-user-attempts="0">
					<p><strong><?= __("pslzme cookiebar name verification", "pslzme") ?></strong></p>
					<div class="ce_text block flex-wrap">
						<input type="text" value="" class="ce_text block" maxlength="1">
						<input type="text" value="" class="ce_text block" maxlength="1">
						<input type="text" value="" class="ce_text block" maxlength="1">
					</div>
					<p class="ce_text block space-top10 attempts-text"><?= wp_kses(__("pslzme cookiebar attempts text", "pslzme"), ['span' => ['id' => []]]) ?></p>
					<p style="text-align: center;"><?= wp_kses(__("pslzme cookiebar confirmation text", "pslzme"), ['strong' => []]) ?>
					</p>
				</div>
				<div class="ce_text block space-top30">
					<button class="pslzme-cookiebar-save-btn accept" id="pslzme-cookiebar-accept-btn" onClick=saveConsentCookie(true);handleCookie(true);hideVisibility(); disabled="true"><?= __("Yes", "pslzme") ?></button>
					<button class="pslzme-cookiebar-save-btn" id="pslzme-cookiebar-decline-btn" onClick="handleCookie(false);hideVisibility();"><?= __("No", "pslzme") ?></button>
				</div>
                <p><br></p>
               <section class="pslzme-accordion">
					<details>
						<summary>
							<?= wp_kses(__("pslzme cookiebar more information", "pslzme"), ['b' => []]) ?>
						</summary>

						<div class="pslzme-accordion-content">
							<p><?= wp_kses(__("pslzme cookiebar explanation 3", "pslzme"), ['b' => []]) ?></p>
							<p><?= wp_kses(__("pslzme cookiebar explanation 4", "pslzme"), ['b' => []]) ?></p>
						</div>
					</details>
				</section>	
				<div class="pslzme-cookiebar-info space-top20 block">
					<?php if ($imprint_id || $privacy_id): ?>
						<p class="pslzme-cookiebar-legal">
							<?php if ($imprint_id): ?>
								<a href="<?= esc_url(get_permalink($imprint_id)) ?>">
									<?= esc_html(get_the_title($imprint_id)) ?>
								</a>
							<?php endif; ?>

							<?php if ($imprint_id && $privacy_id): ?>
								<span class="pslzme-separator"> · </span>
							<?php endif; ?>

							<?php if ($privacy_id): ?>
								<a href="<?= esc_url(get_permalink($privacy_id)) ?>">
									<?= esc_html(get_the_title($privacy_id)) ?>
								</a>
							<?php endif; ?>
						</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>