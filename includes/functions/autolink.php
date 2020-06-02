<?php

/**
 * adapted from https://stackoverflow.com/a/4217452
 */
function autoLink($s) {
  return preg_replace('/https?:\/\/[\w\-\.!~#:?&=+\*\'"(),\/]+/','<a href="$0">$0</a>',$s);
}

?>
