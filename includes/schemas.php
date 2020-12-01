<?php

$table_template = '<table class="event-schemas">
  <thead>
    <tr>
      <th>Schema <code>$id</code> (latest)</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>';

$repos = ['secondary', 'primary'];

echo '<div id="schema-repos" class="accordion">';

foreach ( $repos as $repo ) {

  echo '<h3>'.$repo.'</h3><div>'.$table_template;

  $dir = 'repos/' . $repo . '/jsonschema';
  $paths = glob_recursive("$dir/*/latest.json");
  sort($paths);
  foreach ( $paths as $path ) {
    $json = file_get_contents( $path );
    $schema = json_decode( $json );
    $id = $schema->{'$id'};
    $description = autoLink($schema->{'description'});
    echo '<tr id="'.str_replace('/', '-', $schema->{'title'}).'"><td class="schema-id"><a href="https://schema.wikimedia.org/repositories/'.$repo.'/jsonschema'.$id.'">'.$id.'</a></td><td class="schema-desc">'.$description.'</td></tr>';
  }

  echo '</tbody></table></div>';

}

echo '</div>'; // #schema-repos

?>
