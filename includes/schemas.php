<?php

require_once('includes/glob_recursive.php');

$repos = ['secondary', 'primary'];

echo '<table id="event-schemas">
  <thead>
    <tr>
      <th>Repository</th>
      <th>Schema <code>$id</code> (latest)</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>';

foreach ( $repos as $repo ) {
  $dir = 'repos/' . $repo . '/jsonschema';
  $paths = glob_recursive("$dir/*/latest.json");
  foreach ( $paths as $path ) {
    $json = file_get_contents( $path );
    $schema = json_decode( $json );
    echo '<tr id="'.str_replace('/', '-', $schema->{'title'}).'"><td class="schema-repo">'.$repo.'</td><td class="schema-id">'.$schema->{'$id'}.'</td><td class="schema-desc">'.$schema->{'description'}.'</td></tr>';
  }
}

echo '</tbody></table>';

?>
