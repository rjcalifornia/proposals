<?php


namespace Elgg\Proposals\Menus;

/**
 * Hook callbacks for menus
 *
 * @since 4.0
 * @internal
 */
class Site {

	/**
	 * Register item to menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:site'
	 *
	 * @return void|\Elgg\Menu\MenuItems
	 */
	public static function register(\Elgg\Hook $hook) {
		$return = $hook->getValue();
		$return[] = \ElggMenuItem::factory([
			'name' => 'proposals',
			'icon' => 'edit-regular',
			'text' => elgg_echo('collection:object:proposals'),
			'href' => elgg_generate_url('default:object:proposals'),
		]);
	
		return $return;
	}
}
