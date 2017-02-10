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

jQuery(document).ready(function() {

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
