jQuery.fn.serializeObject = function() {
  var o = {};
  var a = this.serializeArray();
  jQuery.each(a, function() {
      if (o[this.name] !== undefined) {
          if (!o[this.name].push) {
              o[this.name] = [o[this.name]];
          }
          o[this.name].push(this.value || '');
      } else {
          o[this.name] = this.value || '';
      }
  });
  return o;
};

function validateForm( data, field ) {

  var regxp = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;

  switch ( field ) {
    case 'email':
      if ( !regxp.test( data ) || data == "" ) {
        return 'Please enter a valid email address';
      } else {
        return false;
      }
      return false;
      break;
    default:
      if ( data == "" ) {
        return 'Please fill out all fields';
      } else {
        return false;
      }
      break;
  }
}

function scrapeForm () {

  var formData = jQuery('#inner-form').serializeObject();
  var formPreProcess = false;

  jQuery.each(formData,function(i,v) {

    formPreProcess = validateForm(v,i);

    if ( formPreProcess ) {
      return false;
    }
  });

  return new Promise(function (resolve, reject) {
    if ( formPreProcess ) {
      reject(formPreProcess)
      // swal.resetValidationError()
    } else {

      var data = { action : 'post_form_send_form' };
      data.fields = formData;

      jQuery.ajax({
        url : form.submit_url,
    		type : 'post',
    		data : data
      })
      .done(function( data ) {
        if ( data == true ){
          resolve( 'Thanks! Someone will reach out to you shortly.' );
        } else {
          swal.close();
          swal({
            type: 'error',
            text: data,
            showCancelButton: true,
            showConfirmButton: false,
            cancelButtonText: '<i class="fa fa-frown-o"></i> Sorry',
          });
        }
      });
    }
  });
}

function do_cookie ( action ) {

  if ( typeof action == 'undefined' ) {
    action = false;
  }

  Cookies.defaults.domain = 'flo.dev';
  Cookies.defaults.expires = 14;

  var cookie;

  if ( action ) {

    return new Promise( function (resolve, reject) {

      Cookies.set('flo_age_verification', true);

      cookie = Cookies.get('flo_age_verification');

      if ( cookie ) {
        resolve();
      } else {
        reject('Oops... It looks like something went wrong.');
      }
    });
  } else {

    cookie = Cookies.get('flo_age_verification');

    if ( typeof cookie == 'undefined' ) {
      cookie = false;
    }

    return cookie;
  }
}

jQuery(document).ready(function() {

  if ( do_cookie(false) === false ) {

    // disable right-click while the age verification is open
    jQuery('body').on('contextmenu',function() {
       return false;
    });

    // 18+ Check and Cookie Storage
    var ageVerify = "<p>We are required by law to verify your age before allowing you to view this website.</p>";
    ageVerify += "<p>By clicking 'I am 21+', you are providing confirmation that you are legally over the age of 21.</p>";
    ageVerify += "<p><span style='color: red;'><bold>If you are not, please click 'Exit'.</bold></span></p>";
    ageVerify += "<p><sub>We use <a href='https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies' target='_blank'>cookies</a> to save your age verification.";
    ageVerify += " By clicking 'Enter' you acknowledge and accept our use of cookies for this purpose.</sub></p>";

    swal({
      title: "Age Verification",
      type: 'error',
      html: ageVerify,
      padding: 50,
      showCancelButton: true,
      allowOutsideClick: false,
      allowEscapeKey: false,
      confirmButtonText: 'I am 21+',
      cancelButtonText: 'Exit',
      reverseButtons: true,
      preConfirm: function() {
        return do_cookie(true);
      },
      onOpen: function () {
        jQuery('.swal2-confirm').blur();
      },
    }).then( function( result ) {
      swal.close();
      jQuery('body').off('contextmenu');
    }, function (dismiss) {
      if (dismiss === 'cancel') {
        swal({
          type: 'success',
          title: 'Thanks for being honest...',
          text: 'Redirecting to goodtoknowcolorado.com',
          onOpen: function() {
            setTimeout(function () {
              window.location = "https://goodtoknowcolorado.com/";
            }, 1000);
          },
          showCancelButton: false,
          showCloseButton: false,
          showConfirmButton: false,
          allowOutsideClick: false,
          allowEscapeKey: false,
        });
      }
    });
  }


  // Get the ScrollMagic Library ready to pull rabbits out of stuff
  var controller = new ScrollMagic.Controller();
  var header = jQuery('.do-scroll-magic #masthead');
  // create a scene
  var head_fake = new ScrollMagic.Scene ({
    triggerElement: "footer",
    triggerHook: "onEnter",
    // duration: header.outerHeight()
  })
	.addTo(controller)
	.on("enter leave", function (e) {
    header.toggleClass('head-fake');
	});

  // Get the Ellipsis library ready to truncate stuff
  Ellipsis();

  // Get the SweetAlert Library ready to contact stuff
  var bubble = jQuery('#contact-bubble');
  var content = jQuery('#contact-form');

  jQuery('#contact-form').remove();

  bubble.click(function() {

    swal({
      title: "Drop Us a Line!",
      type: 'question',
      html: content.html(),
      showCancelButton: true,
      showCloseButton: true,
      showLoaderOnConfirm: true,
      allowOutsideClick: true,
      allowEscapeKey: true,
      confirmButtonText: '<i class="fa fa-paper-place"></i> Submit',
      cancelButtonText: '<i class="fa fa-ban"></i> Cancel',
      preConfirm: scrapeForm,
      onClose: function() {
        jQuery('#inner-form').off('blur focus');
      },
      onOpen: function () {
        jQuery('#inner-form input').first().focus();
      },
    }).then(function ( result ) {
      swal({
        type: 'success',
        html: '<p>'+result+'</p>',
        timer: 1500,
      });
    }).catch(swal.noop);

    jQuery('#inner-form .form-listener').on('blur',function() {
      var el = jQuery(this);
      var val = validateForm(el.val(),el.attr('name'));
      if ( val != false ) {
        el.addClass('eval');
      }
    }).on('focus',function() {
      jQuery(this).removeClass('eval');
    });

  });
});
