<?php
/**
 * Proposals | Citizen Participation and Open Government plugin
 *
 * @package ElggProposals
 */
$autoload_path = __DIR__ . '/vendor/autoload.php';
require_once($autoload_path);


elgg_register_event_handler('init', 'system', 'proposals_init');


function proposals_init() {
	
	$item = new ElggMenuItem('proposals', elgg_echo('proposals:proposals'), 'proposals/all');
	elgg_register_menu_item('site', $item);

	elgg_extend_view('elgg.css', 'custom/css');

	$root = dirname(__FILE__);

	// actions
	$action_path = "$root/actions/proposals";
	elgg_register_action('proposals/save', "$action_path/save.php");

	elgg_register_action('proposals/supports', "$action_path/supports.php");

	// routing of urls
	elgg_register_page_handler('proposals', 'proposals_page_handler');

	// override the default url to view a blog object
	elgg_register_plugin_hook_handler('entity:url', 'object', 'proposals_set_url');

	elgg_register_entity_type('object', 'proposals');

}


/**
 * Format and return the URL for blogs.
 *
 * @param string $hook
 * @param string $type
 * @param string $url
 * @param array  $params
 * @return string URL of blog.
 */
function proposals_set_url($hook, $type, $url, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'object', 'proposals')) {
		$friendly_title = elgg_get_friendly_title($entity->title);
		return "proposals/view/{$entity->guid}/$friendly_title";
	}
}
function proposals_page_handler($page) {
	
	//elgg_load_library('elgg:blog');

	// push all blogs breadcrumb
	$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/resources');
	$twig = new \Twig\Environment($loader, [
		'cache' => false,
	]);


	elgg_push_breadcrumb(elgg_echo('proposals:proposals'), 'proposals/all');

	$page_type = elgg_extract(0, $page, 'all');
	$resource_vars = [
		'page_type' => $page_type,
		'twig' => $twig,
	];

	switch ($page_type) {
		case 'owner':
			$resource_vars['username'] = elgg_extract(1, $page);
			
			echo elgg_view_resource('proposals/owner', $resource_vars);
			break;
		case 'friends':
			$resource_vars['username'] = elgg_extract(1, $page);
			
			echo elgg_view_resource('proposals/friends', $resource_vars);
			break;
		case 'archive':
			$resource_vars['username'] = elgg_extract(1, $page);
			$resource_vars['lower'] = elgg_extract(2, $page);
			$resource_vars['upper'] = elgg_extract(3, $page);
			
			echo elgg_view_resource('proposals/archive', $resource_vars);
			break;
		case 'view':
			$resource_vars['guid'] = elgg_extract(1, $page);
			
			echo elgg_view_resource('proposals/view', $resource_vars);
			break;
		case 'add':
			$resource_vars['guid'] = elgg_extract(1, $page);
			
			echo elgg_view_resource('proposals/add', $resource_vars);
			break;
		case 'edit':
			$resource_vars['guid'] = elgg_extract(1, $page);
			$resource_vars['revision'] = elgg_extract(2, $page);
			
			echo elgg_view_resource('proposals/edit', $resource_vars);
			break;
		case 'group':
			$resource_vars['group_guid'] = elgg_extract(1, $page);
			$resource_vars['subpage'] = elgg_extract(2, $page);
			$resource_vars['lower'] = elgg_extract(3, $page);
			$resource_vars['upper'] = elgg_extract(4, $page);
			
			echo elgg_view_resource('proposals/group', $resource_vars);
			break;
		case 'all':
			echo elgg_view_resource('proposals/all', $resource_vars);
			break;
		default:
			return false;
	}

	return true;
}

function proposals_prepare_form_vars($post = NULL, $revision = NULL) {

	// input names => defaults
	$values = array(
		'title' => NULL,
		'description' => NULL,
		'summary' => NULL,
		'external_video' => NULL,
		'scope_operation' => NULL,
		'status' => 'published',
		'access_id' => ACCESS_DEFAULT,
		'comments_on' => 'On',
		'excerpt' => NULL,
		'tags' => NULL,
		'container_guid' => NULL,
		'guid' => NULL,
		'draft_warning' => '',
	);

	if ($post) {
		foreach (array_keys($values) as $field) {
			if (isset($post->$field)) {
				$values[$field] = $post->$field;
			}
		}

		if ($post->status == 'draft') {
			$values['access_id'] = $post->future_access;
		}
	}

	if (elgg_is_sticky_form('proposals')) {
		$sticky_values = elgg_get_sticky_values('proposals');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}
	
	elgg_clear_sticky_form('proposals');

	if (!$post) {
		return $values;
	}

	// load the revision annotation if requested
	if ($revision instanceof ElggAnnotation && $revision->entity_guid == $post->getGUID()) {
		$values['revision'] = $revision;
		$values['description'] = $revision->value;
	}

	// display a notice if there's an autosaved annotation
	// and we're not editing it.
	$auto_save_annotations = $post->getAnnotations(array(
		'annotation_name' => 'proposals_auto_save',
		'limit' => 1,
	));
	if ($auto_save_annotations) {
		$auto_save = $auto_save_annotations[0];
	} else {
		$auto_save = false;
	}
	/* @var ElggAnnotation|false $auto_save */

	if ($auto_save && $revision && $auto_save->id != $revision->id) {
		$values['draft_warning'] = elgg_echo('proposals:messages:warning:draft');
	}

	return $values;
}