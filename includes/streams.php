<?php

require_once('mw-config/src/defines.php');
require_once('mw-config/wmf-config/InitialiseSettings.php');
$wmf_settings = wmfGetVariantSettings();
$event_streams = $wmf_settings['wgEventStreams']['default'];

$eventgate_clusters = [
  'eventgate-analytics-external' => [
    'streams' => array(),
    'description' => 'Can receive and validate events from external clients (like the EventLogging service before it). Events are submitted here by EventLogging and WikimediaEvents extensions and Event Platform Clients for Android and iOS.',
  ],
  'eventgate-logging-external' => [
    'streams' => array(),
    'description' => 'Accepts <a href="https://schema.wikimedia.org/#!/primary//jsonschema/mediawiki/client/error"><code>mediawiki/client/error</code></a> events from external clients. Events are submitted here by WikimediaEvents extension (via EventLogging) and Wikipedia KaiOS app.',
  ],
  'eventgate-main' => [
    'streams' => array(),
    'description' => 'It is used for low(ish) volume but high-priority events. These events are necessary for functioning of Wikimedia core services like the MediaWiki Job Queue, EventBus MediaWiki extension, and change-propagation.',
  ],
  'eventgate-analytics' => [
    'streams' => array(),
    'description' => 'Intended for high volume but low-priority events. Events produced to eventgate-analytics should not be required for functional production services. Events are submitted here by EventBus MediaWiki extension\'s server-side PHP, among others.',
  ],
];

foreach ( $event_streams as $event_stream ) {
  array_push($eventgate_clusters[$event_stream['destination_event_service']]['streams'], $event_stream);
}

$table_template = '<table class="event-streams">
  <thead>
    <tr>
      <th>Stream</th>
      <th>Schema</th>
    </tr>
  </thead>
  <tbody>';

echo '<div class="accordion">';

foreach ( $eventgate_clusters as $cluster_name => $eventgate_cluster ) {
  echo '<h3>'.$cluster_name.'</h3><div><p>'.$eventgate_cluster['description'].'</p>'.$table_template;
  foreach ( $eventgate_cluster['streams'] as $stream ) {
    echo '<tr><td>'.$stream['stream'].'</td><td>'.$stream['schema_title'].'</td></td></tr>';
  }
  echo '</tbody></table></div>';
}

echo '</div>';
?>
