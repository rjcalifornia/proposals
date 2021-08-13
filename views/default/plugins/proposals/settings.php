<?php

$supportNeeded = $vars['entity']->support_needed_setting;



?>

<p>
    <label>Support needed:</label>
<?php

    echo elgg_view('input/text', [
        'value' => $supportNeeded, 
        'name' => 'params[support_needed_setting]'
    ]);

?>                        
</p>