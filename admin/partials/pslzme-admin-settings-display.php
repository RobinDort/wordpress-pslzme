<?php
/**
 * Provide a admin area view for the plugins admin settings
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.pslzme.com
 * @since      1.0.0
 *
 * @package    pslzme
 * @subpackage pslzme/admin/partials
 */

$options = get_option('pslzme_settings', []);
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
 <div class="wrap">
    <h1>pslz<strong>me</strong> Konfiguration</h1>
    <div class="pslzme-configuration-container">
        <h2>1: Datenbank Konfiguration</h2>
        <div class="pslzme-explanation">
            <p>Zur erfolgreichen Nutzung von pslz<strong>me</strong> ist eine separate unabhängige Datenbankanbindung notwendig.</p>
            <p>Um Ihnen die Konfiguration so einfach wie möglich zu gestalten, finden Sie im weiteren Abschnitt eine detaillierte Beschreibung der benötigten Schritte zur Erstellung und Konfiguration der Datenbank.</p>
        </div>

        <div class="pslzme-configuration-step">
            <h3><span>Schritt 1: </span> Erstellung der Datenbank</h3>
            <div class="pslzme-explanation">
                <p>Zur Erstellung einer Datenbank loggen Sie sich bitte in Ihrem gewählten Serverhosting-Tool ein und navigieren dort zum bereitgestellten Abschnitt <strong>Datenbanken</strong>. Anschließend wählen Sie die Option <strong>Neue Datenbank erstellen</strong> und geben dann Ihre gewünschten Konfigurationdaten für Datenbankname, Username und Passwort an.</p>
                <p>Sollten Sie noch keinen Datenbank-User erstellt haben, so muss dies im Idealfall vor der Erstellung der Datenbank getan werden. Dieser kann jedoch auch nachträglich erstellt und der Datenbank zugewiesen werden. Zur Erstellung des Users, navigieren sie zum Abschnitt <strong>Datenbank-Nutzer erstellen</strong> und weisen Sie dann die gewünschten Konfigurationdaten wie Username und Passwort zu. Nach beidiger Erstellung muss zuletzt - wenn nicht bereits getan - der erstellte User noch der Datenbank zugewiesen werden.</p>
            </div>

            <div class="pslzme-explanation">
                <h3><span>Schritt 2: </span>Datenbank an pslz<strong>me</strong> plugin Anbinden</h3>
                <p>Als nächstes tragen Sie bitte die Verbindungsdaten der soeben erstellten Datenbank in die nachstehenden Felder ein und bestätigen dies durch Klick des Speichern buttons.</p>
            </div>

            <div class="pslzme-db-configuration">
                <!-- SETTINGS FORM -->
                <form method="post" action="options.php" class="pslzme-settings-form">
                    <?php settings_fields('pslzme_settings_group'); ?>
                    <?php do_settings_sections('pslzme_settings'); ?>
                    <?php submit_button(__('Speichern', 'pslzme')); ?>
                </form>
            </div>

            <div class="pslzme-explanation">
                <h3><span>Schritt 3: </span> pslz<strong>me</strong> Tabellen konfigurieren</h3>
                <p>Zuletzt müssen die benötigten pslzme Datenbanktabellen angelegt werden. Dies erfolgt vollständig automatisiert nach Bestätigung des nachstehenden Buttons. Bitte prüfen Sie erneut, ob die Angaben im vorherigen Schritt keine Fehler enthalten.</p>
                <button id="create-tables-smt" type="submit">Tabellen anlegen</button>
            </div>
        </div>
    </div>

    <div class="pslzme-configuration-container">
        <h2>2: Domain lizensieren</h2>
        <div class="pslzme-explanation">
            <p>Für die Nutzung von pslzme ist eine Lizenzierung Ihrer Domain erforderlich. Hierfür ist ein zugewiesener pslzme-Account erforderlich. Sollten Sie noch keinen Account besitzen, können Sie diesen unter <a href="https://www.pslzme.com/de/login">https://www.pslzme.com/de/login</a> anfordern.</p>
            <p>Nachdem Ihr Account bereitgestellt wurde, bestätigen Sie bitte abschließend den nachfolgenden Button zur Lizenzierung dieser Domain.</p>
            <button trype="submit" onclick="event.preventDefault();licensePslzmeDomain();">Domain lizensieren</button>
    </div>

    <div class="pslzme-configuration-container">
        <h2>3: Interne Seiten Konfiguration</h2>
        <p>Für einen reibungslosen und DSGVO-Konformen Ablauf nutzt pslzme interne Weiterleitungen zu bestimmten Unterseiten Ihrer Webseite.</p>
        <p>Beispielsweise benötigt der pslz<strong>me</strong> Cookiebanner, welcher als essentielles Bestandsteil fungiert, Angaben zu Impressum und Datenschutz.</p>
        <p>Damit die interne Weiterleitung problemlos genutzt werden kann, weissen Sie bitte die in den nachstehenden Feldern beschriebenen Seiten mit der entprechenden ID der passenden internen Seite zu. Die ID der jeweiligen Seite finden Sie im contao backend unter <strong>Seiten</strong> durch Aufruf der Detailinformation der jeweiligen Seite.</p>
    </div>
</div>