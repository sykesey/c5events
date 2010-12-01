<?php  

defined('C5_EXECUTE') or die(_("Access Denied."));

class EventsPackage extends Package {

	protected $pkgHandle = 'events';
	protected $appVersionRequired = '5.3.2';
	protected $pkgVersion = '1.0.1';
	
	public function getPackageDescription() {
		return t("Provides a simple Events calendar.");
	}
	
	public function getPackageName() {
		return t("Events");
	}
	
	public function install() {
		$pkg = parent::install();
		
		// install block		
		BlockType::installBlockTypeFromPackage('events', $pkg);
		
	}




}