$( document ).ready( function() {

  const submodules = $( '#submodule-status' ).text().split( '\n' ).filter( submod => submod.length > 0 );
  const baseUrl = 'https://gerrit.wikimedia.org/r/plugins/gitiles/schemas/event';
  var links = [];
  submodules.forEach( function( item, index ) {
    const components = item.split(' ').filter(component => component.length > 0);
    const hash = components[0];
    if ( components[1] === 'mw-config' ) {
      const url = 'https://gerrit.wikimedia.org/r/plugins/gitiles/operations/mediawiki-config';
      links.push( `<a href="${url}">mw-config</a> (<a href="${url}/+/${hash}">${hash}</a>)` );
    } else {
      const repo = components[1].replace( 'repos', baseUrl );
      const events = components[1].replace( 'repos/', '' );
      links.push( `<a href="${repo}/">${events}</a> (<a href="${repo}/+/${hash}">${hash}</a>)` );
    }
  } );
  const list = `<ul id="repo-links"><li>${links.join( '</li><li>' )}</li></ul>`;
  $( '#submodule-status' ).html( list );

  // Update URL with name of the tab when it's activated:
  $( "#tabs" ).tabs({
    beforeActivate: function( event, ui ) {
      window.location.hash = ui.newPanel.attr( 'id' );
    }
  });

  // Auto-activate the tab that is in the URL, if any:
  if ( window.location.hash.length > 0 ) {
    const possibleTabs = [ '#active-streams', '#all-schemas', '#standard-analytics-fields' ];
    if (possibleTabs.indexOf( window.location.hash ) >= 0 ) {
      window.scrollTo(0, 0);
      $('#tabs > ul > li > a[href="' + window.location.hash + '"]').click();
    }
  }

  $( ".accordion" ).accordion( {
    collapsible: true,
    heightStyle: "content"
  } );

} );
