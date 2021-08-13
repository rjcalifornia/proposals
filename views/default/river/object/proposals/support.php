<?php
/**
 * Proposals river view.
 */

$item = elgg_extract('item', $vars);
if (!$item instanceof ElggRiverItem) {
	return;
}

$blog = $item->getObjectEntity();


echo elgg_view('river/elements/layout', $vars);
