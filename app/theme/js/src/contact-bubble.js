jQuery(document).ready(function() {

  var bubble = jQuery('#contact-bubble');

  bubble.click(function() {
    var content = jQuery('#customer-form').html();
    swal({
      title: "Drop Us a Line!",
      text: content,
      type: "info",
      html: true,
      showCancelButton: false,
      showConfirmButton: false,
      allowOutsideClick: true,
      allowEscapeKey: true,
    });
  });
});
