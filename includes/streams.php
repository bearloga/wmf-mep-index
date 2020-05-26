<?php

require_once('mw-config/src/defines.php');
require_once('mw-config/wmf-config/InitialiseSettings.php');
$wmf_settings = wmfGetVariantSettings();
$event_streams = $wmf_settings['wgEventStreams']['default'];

echo '<table id="event-streams">
  <thead>
    <tr>
      <th>Stream</th>
      <th>Schema</th>
    </tr>
  </thead>
  <tbody>';
foreach ( $event_streams as $event_stream ) {
  echo '<tr>
    <td>'.$event_stream['stream'].'</td><td><a href="#'.str_replace('/', '-', $event_stream['schema_title']).'">'.$event_stream['schema_title'].'</a></td>
  </tr>';
}
echo '</tbody></table>';

?>
