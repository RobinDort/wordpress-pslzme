<div id="pslzme-cookiebar">
		<div class="pslzme-cookiebar-inner">
			<div class="block">
				<button class="pslzme-cookiebar-close-btn btn-small icon-cancel" onClick="hideVisibility();"></button>
			</div>
			<div class="space-bottom20 block" style="text-align: center; width:100%">
				<img id="pslzme-logo"  src="<?php echo plugins_url('../images/pslzme_logo.svg', __FILE__); ?>"alt="<?php echo esc_attr__('PSLZME Logo', 'robindort-pslzme'); ?>" style="max-height: 80px;"/>
			</div>
			<div class="pslzme-cookiebar-description ce_text block">
				<p><h4 class="pslzme-heading">Sehr geehrte/r BesucherIn,</h4></p>
				<p><h4 class="pslzme-heading">Sie sind über <span id="pslzme-cookiebar-first-contact"></span> einem persönlichen pslz<b>me</b> Einladungslink von <span id="pslzme-cookiebar-link-creator"></span> gefolgt.</h4></p>
                <p>Hierdurch sind wir in der Lage, Sie auf unserer Webseite DSGVO-konform persönlich anzusprechen und Ihnen unsere Webseite mit persönlich für Sie zugeschnittenen Inhalten zu präsentieren, sofern Sie uns dies gestatten.</p>
                <p>Um dies zu tun, geben Sie bitte hier die ersten drei Buchstaben Ihres Nachnamens ein und bestätigen Sie dann zusätzlich mit einem Klick auf den <b>Ja-Button</b>, dass wir Sie persönlich auf unserer Webseite empfangen und Ihnen individuelle Inhalte und Angebote ausliefern dürfen. Oder lehnen Sie die Personalisierung mit Klick auf <strong>Nein</strong> ab. Sofern Sie Nein klicken, werden wir Sie auf die unpersonalisierte Version unserer Webseite weiterleiten.
                </p>

			</div>
			<div class="pslzme-cookiebar-footer block">
				<div id="name-verifiyer" data-user-attempts="0">
					<p><strong>Geben Sie hier nun die ersten drei Buchstaben Ihres Nachnamens ein:</strong></p>
					<div class="ce_text block flex-wrap">
						<input type="text" value="" class="ce_text block" maxlength="1">
						<input type="text" value="" class="ce_text block" maxlength="1">
						<input type="text" value="" class="ce_text block" maxlength="1">
					</div>
					<p class="ce_text block space-top10 attempts-text">Restliche Versuche: <span id="remaining-attempts">3</span></p>
					<p style="text-align: center;">Bestätigen Sie nachfolgend dann mit einem Klick auf <strong>Ja</strong>, dass wir Ihre Daten entschlüsseln und zur persönlichen Ansprache und personalisierten Inhalten auf unserer Webseite verwenden dürfen.
					</p>
				</div>
				<div class="ce_text block space-top30">
					<button class="pslzme-cookiebar-save-btn accept" id="pslzme-cookiebar-accept-btn" onClick=saveConsentCookie(true);handleCookie(true);hideVisibility(); disabled="true">Ja</button>
					<button class="pslzme-cookiebar-save-btn" id="pslzme-cookiebar-decline-btn" onClick="handleCookie(false);hideVisibility();">Nein</button>
				</div>
                <p><br></p>
                <section class="ce_accordionSingle ce_accordion ce_text block">
                    <div class="toggler ui-accordion-header ui-corner-top ui-state-default ui-accordion-icons ui-accordion-header-collapsed ui-corner-all" role="tab" id="ui-id-1" aria-controls="ui-id-2" aria-selected="true" aria-expanded="true" tabindex="0"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>Weiterführende Informationen zu pslz<b>me</b></div>
                    <div class="accordion ui-accordion-content ui-corner-bottom ui-helper-reset ui-widget-content ui-accordion-content-active" style="" id="ui-id-2" aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="false">
                        <div>
                            <p>Bei pslz<b>me</b> (ausgesprochen: personalize <b>me</b>) handelt es sich um ein von uns entwickeltes, DSGVO-konformes und absolut sicheres Personalisierungs-Framework, das schon jetzt als bahnbrechende Entwicklung im Programmatic Web bezeichnet werden darf und auf sichere und datensparsame Weise, erstmals Personalisierung, Individualisierung und persönliche Ansprache auch im Web ermöglicht.</p>
                            <p>Unser System ist dabei so aufgebaut, dass alle Informationen unter Einsatz höchster Sicherheitsmaßnahmen auf unterschiedlichen Sicherheitsebenen in einen einfachen Link gepackt werden. So sicher, dass unser System selbst Ihre Daten nicht kennt und ebenso wir diese nicht tracken können. Es findet auch zu keinem Zeitpunkt eine unverschlüsselte Datenübertragung und -speicherung statt. Wir arbeiten hier ausschließlich mit personengebundenen Daten, die Sie freiwillig veröffentlicht haben. Es findet weder ein Tracking auf Basis Ihrer Daten, noch ein Profiling statt. Und pslz<b>me</b> entschlüsselt und verarbeitet Ihre personengebundenen Daten erst und ausschließlich dann, wenn Sie uns dies ausdrücklich erlauben.</p>
                        </div>
                    </div>
                </section>					
			</div>
			<div class="pslzme-cookiebar-info space-top20 block">
				<?php if($this->imprintUrl): ?>
					<a href="<?= $this->imprintUrl ?>" target="_blank" rel="norefferer noopener">Impressum</a>
				<?php endif; ?>

				<?php if($this->privacyUrl): ?>
					<a href="<?= $this->privacyUrl ?>" target="_blank" rel="norefferer noopener">Datenschutz</a>
				<?php endif; ?>
			</div>
		</div>
	</div>