<?php

echo '<div id="submodule-status">';
$last_line = system('git submodule status', $submod_status);
echo '</div>';

?>
