<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Modern Event Platform Index</title>
  <meta name="description" content="Flattened index of schema.wikimedia.org and deployed streams">
  <meta name="author" content="Mikhail Popov">

  <link rel="stylesheet" href="css/styles.css">

</head>

<body>
  <div id="content">
    <h1>Event Platform Stream and Schema Index</h1>
    <p>This page provides a glimpse into <a href="https://wikitech.wikimedia.org/wiki/Event_Platform">Event Platform</a> streams and schemas deployed in production. Source code is available at <a href="https://github.com/bearloga/wmf-mep-index">github.com/bearloga/wmf-mep-index</a></p>
    <p>Repositories used (as submodules) and their hashes:</p>
    <?php require_once('includes/hashes.php') ?>
    <div id="streams">
      <h2>Streams</h2>
      <p>Index of streams deployed in production (defined in <code>$wgEventStreams</code> in wmf-config/InitialiseSettings.php within <a href="https://gerrit.wikimedia.org/r/plugins/gitiles/operations/mediawiki-config/">mediawiki-config</a>), via <a href="https://www.mediawiki.org/wiki/Extension:EventStreamConfig">EventStreamConfig extension</a>:</p>
      <?php require_once('includes/streams.php') ?>
      <p><b>Reminder</b>: streams map to tables in the modern event platform.</p>
    </div>
    <div id="schemas">
      <h2>Schemas</h2>
      <p>Flattened index of schemas from the <a href="https://schema.wikimedia.org/repositories/primary/">primary</a> and <a href="https://schema.wikimedia.org/repositories/secondary/">secondary</a> schema repositories, as an alternative to <a href="https://schema.wikimedia.org/#!/">schema.wikimedia.org</a>:</p>
      <?php require_once('includes/schemas.php') ?>
    </div>
  </div>
  <div id="footer">
    <script src="https://tools-static.wmflabs.org/cdnjs/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script src="js/jquery-3.5.1.min.js"></script> -->
    <script src="js/scripts.js"></script>
  </div>
</body>
</html>
