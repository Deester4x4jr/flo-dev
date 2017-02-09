// Setup some objects
var form = jQuery('#map-form');
var theMap = jQuery('#map-box');
var submit = jQuery('.wpslsubmit');
var mapResults = jQuery('#results-box');
var dispensaries = '';

init_maps();

function check_maps(){

  var styles = theMap.attr("style"),value;

  if ( typeof styles === 'undefined' ){
    setTimeout(check_maps,250);
  } else {
    jQuery('#page-loader').fadeOut("fast",function() {
      jQuery('#page-loader').remove();
      theMap.addClass('show');
      form.addClass('show');
      jQuery('body').addClass('loaded');
    });
  }
}

function init_maps() {

  jQuery('.wpsl-error').remove();

  check_maps();
}

function setup_results(output,hasData) {

  if (!hasData) {

    mapResults.addClass('no-results').html(output).promise().done(function() {
      mapResults.fadeIn();
    });
  } else {

    mapResults.html(output).promise().done(function() {
      mapResults.fadeIn("fast",function() {

        var outerHeight = mapResults.outerHeight();
        var scrollHeight = mapResults.prop('scrollHeight');

        if (scrollHeight == outerHeight) {
          mapResults.addClass('short-list');
        }
      });

      dispensaries = jQuery('.map-result');

      dispensaries.on('click',function() {
        dispensaries.removeClass('active');
        jQuery(this).addClass('active');
      });
    });
  }
}

function wpsl_success( resultcount, results, active_form ) {

  var output = '<div class="map-result-header"><h3>Check it out!</h3><p>We found ' + resultcount + ' dispensaries that carry FLO Products near you:</p></div>';

  jQuery.each(results,function(k,v) {
    var html = v.output;
    var div = document.createElement("div");
    div.innerHTML = html;
    var text = div.textContent || div.innerText || "";
    var details = JSON.parse(text);

    output += '<div class="map-result infowindow-open map-link" onClick="event.preventDefault(); openInfoWindow(' + k + ');" data-location-id="' + v.id + '">';
      output += '<h5>' + v.title + '</h5>';
      output += '<p id="location-address" data-location-zip="'+details.Zip+'"><i class="fa fa-fw fa-map-marker"></i>' + details.Address + '</p>';
      output += '<p id="location-hours"><i class="fa fa-fw fa-clock-o"></i>' + details.Info + '</p>';
      // output += '<div class="map-result-go" onClick="event.preventDefault(); openInfoWindow(' + k + ');"><i class="fa fa-arrow-right"></i></div>';
    output += '</div>';
  });

  setup_results(output,true);
}

function get_directions( id ) {

  var curr = mapResults.find('[data-location-id='+id+']');
  var addr = curr.find('#location-address');
  var biz = curr.find('h5').text();

  var left = (screen.width/2)-(1024/2);
  var top = (screen.height/2)-(768/2);

  addr = addr.text() + ' ' + addr.attr('data-location-zip');
  addr = addr.replace(/([,]|[\s])+/g,'+');
  biz = biz.replace(/([,]|[\s])+/g,'+');

  addr = 'https://maps.google.com?daddr='+biz+'+'+addr+'&layer=t';

  window.open(addr,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1024,height=768,left='+left+',top='+top);
}

// Log a message if there is an error
function wpsl_error( message, active_form ) {

  var output = '<div class="map-result-header"><h3>Sorry about that...</h3><p>It looks like there was an error:</p><pre>'+message+'</pre><p>Please try again.</p></div>';
  setup_results(output,false);
}

// Print special message if there are no results
function wpsl_no_results( location, active_form ) {

  var output = '<div class="map-result-header"><h3>Sorry about that...</h3><p>It looks like there are no dispensaries in your immediate area that carry our products right now.</p><p>Please try searching a different area.</p></div>';
  setup_results(output,false);
}

// Do stuff before the form gets submitted
function wpsl_before_submit(active_form, formelements) {

  if (!form.hasClass('map-form-left')) {
    form.addClass('map-form-left');
  }
  if (dispensaries instanceof jQuery) {
    dispensaries.off('click');
  }
  mapResults.fadeOut().removeClass('short-list');
}

// <a href="http://#" class="infowindow-open map-link" onClick="event.preventDefault(); openInfoWindow(1);">Show on Map</a>
