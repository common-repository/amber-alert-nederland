<?php
/**
 * Load Configuration
 * @package amberalert
 * @since 0.0.1
 * @author Edward de Leau <e@leau.net>, {@link http://edward.de.leau.net}
 * @copyright GPL 2
 *
 * @ todo make the duplication between theses classes in server and client less by abstracting it
 */
namespace leau\co\amberalert_client;

/* roots */
$current_dir = dirname( __FILE__ ) . '/';
$plugin_root = $current_dir  . '/plugins/';
$generic_root = $current_dir  . '/../generic/';

/* include - generic re-usable for plugins */
require_once $generic_root . 'class-abstract-utils.php';
require_once $generic_root . 'class-abstract-module.php';
require_once $generic_root . 'class-abstract-modules.php';
require_once $generic_root . 'class-abstract-plugin.php';
require_once $generic_root . 'class-abstract-init.php';


/* include - specific for client component for this plugin */
require_once $current_dir . 'class-config.php';
require_once $current_dir . 'class-utils.php';
require_once $current_dir . 'class-module.php';
require_once $current_dir . 'class-modules.php';
require_once $current_dir . 'class-plugin.php';
require_once $current_dir . 'class-init.php';


if (!class_exists('\\leau\co\ambertalert_client\\LoadConfiguration'))
{
	/**
	 * Sets Specific Configuration settings amberalert
	 * uses the generic config class
	 * @since 0.4.0
	 * @author Edward de Leau <e@leau.net>, http://edward.de.leau.net
	 *
	 */
	class LoadConfiguration
	{
		function __construct()
		{
			
			// handy vars
			$page_title = 'page_title';
			$menu_title = 'menu_title';
			$menu_slug = 'menu_slug';
			$section_header_title = 'section_header_title';
			$section_header_text = 'section_header_text';
			$help_text = 'help_text';
			$gurl='http://www.google.com/s2/favicons?domain=';
			
			// set the specific configuration for the favicon plugin:
			Config::SetPluginVersion('0.0.1');
			Config::SetOptionsName('amberalert_client_options');
			Config::SetOptionsFromArray(get_option(Config::GetOptionsName()));
			Config::SetSettingsGroupName('amberalert_client_settings_group');
			Config::SetPageTitle('amberalert Client Settings');
			Config::SetMenuTitle('Amber Alert');
			Config::SetCapability('manage_options');
			Config::SetMenuSlug('amberalert-Client-Menu');
			Config::SetPluginSlug('amberalert_client_');
			Config::SetNicePluginSlug('amberalert_client_');
			Config::AddMenuIcon(plugins_url('/img/amberalert.png', __FILE__));
			
			/* -------------------------------------------------------------*/
			/*          MAIN			                                    */
			/* -------------------------------------------------------------*/
Config::SetMainPage(
	__(
'<h2>Amber Alert Nederland</h2>
<p><img src="'. $gurl . 'amberalertnederland.nl"> AMBER Alert is het landelijke waarschuwingssysteem bij 
urgente kindervermissingen en -ontvoeringen. Hiermee kan de politie bij de ontvoering of vermissing 
van een kind direct heel Nederland waarschuwen - via PC- en TV-schermen, websites, e-mail, SMS, Twitter, 
TV en radio. Zo kan de kans op een goede afloop enorm worden vergroot.
</p> 
<p>Deze plugin laat automatisch een popup zien enkele keren per jaar door oftewel
een stukje code toe te voegen aan de footer (onzichtbaar) (default) oftewel door een widget		
beschikbaar te stellen dat je kunt "draggen" naar je sidebar. Met het widget kun je
ook een RSS button tonen die direct leidt naar de actuele vermissingen pagina.</p>
<h3>Links</h3>
<p>
<ul>			
<li><a href="http://www.amberalertnederland.nl/Amber.aspx?lang=nl">Amber alert Nederland</a></li>
<li><a href="http://www.facebook.com/AMBERAlertNederland?lang=nl&sk=wall">Amber alert op facebook</a></li>
</ul>
</p>
<p>
disclaimer: de maker van deze WP plugin heeft geen banden met AmberAlert (het was er nog niet en ik vond het handiger)
</p>
'));
		
/* -------------------------------------------------------------*/
/*          MODULE FOOTER (Automatisch)                         */
/* -------------------------------------------------------------*/
$moduleID = 'automatisch';			
/* main module settings */
Config::AddModule(array(
		$page_title 			=> 'Amber Alert Auto Popup',
		$menu_title 			=> 'Opties',
		$menu_slug 				=> $moduleID,
		$section_header_title 	=> '<h2>automatisch?</h2>',
		$section_header_text   =>
		__('De automatische modus voegt een stukje code toe aan je footer. Je hoeft niets
				anders te doen dan je plugin te activeren. Als je echter de widget gebruikt
				om een RSS icoontje te tonen, kun je de automatisch modus uitzetten.'),
		$help_text				=>
		__('<h3>Amber Alert</h3>
			<p>Zie http://www.amberalertnederland.nl/Amber.aspx?lang=nl</p>')));

/* plugin: footer_widget */
		$pluginID = 'footer';
		Config::RegisterModulePlugin($moduleID,$pluginID);
		Config::SetModulePlugin($moduleID,$pluginID,'title',
				__(' ','amberalert'));
		Config::SetModulePlugin($moduleID,$pluginID,'header',
				__('Automatisch: JA betekent dus technisch: toevoegen van onzichtbare code in de footer. en NEE betekent: ik gebruik de widget die ik zelf drag naar mijn sidebar drag','amberalert'));		
		Config::SetModulePluginField($moduleID,$pluginID,0,
				array(	'name' => Config::GetPluginSlug() . 'toon amberalert',
						'default' => 1,
						'label' => __('Amber alert tonen?','amberalert'),
						'type' => 'radio_bool'));
		Config::SetModulePluginField($moduleID,$pluginID,1,
				array(	'name' => Config::GetPluginSlug() . 'show_in_footer',
						'default' => 1,
						'label' => __('Automatisch tonen?','amberalert'),
						'type' => 'radio_bool'));
/* plugin: footer_uid */
		$pluginID = 'UID';
		Config::RegisterModulePlugin($moduleID,$pluginID);
		Config::SetModulePlugin($moduleID,$pluginID,'title',
				__('Geavanceerd','amberalert'));
		Config::SetModulePlugin($moduleID,$pluginID,'header',
				__('Met een unieke UID kunt u uw website identificeren bij Amber Alert, genereer '
					. 'daarvoor de code <a href="http://www.amberalertnederland.nl/ReceiveAlert.aspx?id=3&lang=nl" target="_blank">hier</a> en copy en paste het uid.','amberalert'));
		Config::SetModulePluginField($moduleID,$pluginID,0,
				array(	'name' => Config::GetPluginSlug() . 'uniek UID',
						'default' => 'e4fb7590-db30-4897-af00-79a821d0414e',
						'label' => __('Uniek ID','amberalert'),
						'type' => 'text'));
		
		
		
		
		}		
	}	
}		

/* exectue - load config */
do_action( Config::GetPluginSlug() . 'config');
new LoadConfiguration;
/* execute - init screen api */
$all_plugins = Config::GetRegisteredPlugins();
foreach ($all_plugins as $module_key => $module_value)
{
	foreach ($module_value as $plugin_key => $plugin_value)
	{
		require_once $plugin_root . $module_key . '/' . $plugin_key . '.php';
	}
}

new Init();
		