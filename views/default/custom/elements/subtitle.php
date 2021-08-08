<?php
/**
 * Outputs object subtitle
 * @uses $vars['subtitle'] Subtitle
 */
$subtitle = elgg_extract('subtitle', $vars);

if (!$subtitle) {
	return;
}
//echo $vars['summary'];
?>
<span class="heading-all">
    <?php
            echo $vars['title'];
    ?>
</span>
<div class="elgg-listing-summary-subtitle elgg-subtext"><?php echo $subtitle ?></div>

<div class=" padding-all">
              <p>
                  <?php
                  echo $vars['summary'];
                  ?>
              </p>
              <div class="truncate"></div>
</div>