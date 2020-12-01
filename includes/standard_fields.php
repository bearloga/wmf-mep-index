<?php

$dir = 'repos/secondary/jsonschema/fragment/analytics';
$paths = glob_recursive("$dir/*/latest.json");
sort($paths);

echo '<table id="data-dictionary">
  <colgroup>
    <col class="field-name">
    <col class="field-description">
    <col class="field-fragment">
  </colgroup>
  <thead>
    <tr>
      <th>Field</th>
      <th>Description</th>
      <th>Schema Fragment</th>
    </tr>
  </thead>
  <tbody>';

function field_description($data) {
    $code_pattern = "/`(.*)`/";
    $code_replacement = '<code>${1}</code>';
    if ( property_exists($data, 'properties') ) {
        $sub_fields = $data->{'properties'};
        $description .= '<div class="accordion"><h3>Sub-fields</h3><div><dl>';
        foreach ( $sub_fields as $sub_field_name => $sub_field_properties ) {
            $description .= '<dt>'.$sub_field_name.'</dt><dd>'.$sub_field_properties->{'description'}.'</dd>';
        }
        $description .= '</dl></div></div>';
    } else {
        $description = $data->{'description'};
        $description = preg_replace($code_pattern, $code_replacement, $description);
        $description = autoLink($description);
    }
    return $description;
}

foreach ( $paths as $path ) {
    if (strpos($path, 'legacy/eventcapsule') !== false) {
        // Skip the legacy EventLogging event capsule fragment
        continue;
    }
    $json = file_get_contents( $path );
    $schema = json_decode( $json );
    $properties = $schema->{'properties'};
    $title = $schema->{'title'};
    foreach ( $properties as $field_name => $field_properties ) {
        $href = preg_replace('/repos/', 'https://schema.wikimedia.org/repositories', $path);
        $link = '<a href="'.$href.'">'.str_replace('fragment/analytics/', '', $title).'</a>';
        $description = field_description($field_properties);
        echo '<tr><td><code>'.$field_name.'</code></td><td>'.$description.'</td><td>'.$link.'</td></tr>';
    }
}

echo '</tbody></table>';

?>
