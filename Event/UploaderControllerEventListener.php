<?php
class UploaderControllerEventListener extends BcControllerEventListener {
/**
 * 登録イベント
 *
 * @var array
 */
	public $events = array(
		'startup'
	);
	
/**
 * startup
 * 
 * @param CakeEvent $event
 */
	public function startup(CakeEvent $event) {
		$Controller = $event->subject();
		if (!in_array('BcCkeditor', $Controller->helpers)) {
			$Controller->helpers[] = 'BcCkeditor';
		}
	}
	
}
