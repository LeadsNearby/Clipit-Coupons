jQuery(document).ready(function() {
  //Show Hide Upload or Build

  //jQuery('#coupon_theme .build').show();

  //jQuery('#coupon_theme .upload').hide();

  //jQuery('#coupon_theme .url').hide();

  jQuery('#coupon_type').change(function() {
    if (jQuery(this).val() == 'Build') {
      jQuery('#coupon_theme .build').show();

      jQuery('#coupon_theme .upload').hide();

      jQuery('#coupon_info').show();

      jQuery('#coupon_action')
        .find("option[value='promo']")
        .show();

      jQuery('#coupon_action')
        .find("option[value='peel']")
        .show();
    } else if (jQuery(this).val() == 'Upload') {
      jQuery('.upload').show();

      jQuery('.build').hide();

      jQuery('#coupon_info').hide();

      jQuery('#coupon_action')
        .find("option[value='promo']")
        .hide();

      jQuery('#coupon_action')
        .find("option[value='peel']")
        .hide();
    }
  });

  jQuery('#coupon_action').change(function() {
    if (jQuery(this).val() == 'url') {
      jQuery('.url').show('slow');
    } else {
      jQuery('.url').hide('slow');
    }
  });

  if (jQuery("#coupon_action option[value='url']").attr('selected')) {
    jQuery('.url').show('slow');
  } else {
    jQuery('.url').hide('slow');
  }

  //Date Picker
  jQuery('#datepicker').datepicker({
    minDate: new Date()
  });

  //Accordion

  jQuery(function() {
    jQuery('#accordion').accordion({
      active: false,
      autoHeight: false,
      collapsible: true
    });
  });

  //Admin Image loader Script

  var coupon_uploader;

  jQuery('.upload_coupon_button').on('click', function(e) {
    var $coup = jQuery(this);

    e.preventDefault();

    //If the uploader object has already been created, reopen the dialog

    //if (coupon_uploader) {

    //  coupon_uploader.open();

    //  return;

    //}

    //Extend the wp.media object

    coupon_uploader = wp.media.frames.file_frame = wp.media({
      title: 'Choose Image',

      button: {
        text: 'Choose Image'
      },

      multiple: false
    });

    //When a file is selected, grab the URL and set it as the text field's value

    coupon_uploader.on('select', function() {
      attachment = coupon_uploader
        .state()
        .get('selection')
        .first()
        .toJSON();

      $coup
        .closest('p')
        .find('.upload_image')
        .val(attachment.url);
    });

    //Open the uploader dialog

    coupon_uploader.open();
  });

  //Manages the taxonomy labels for the locations

  if (jQuery('.taxonomy-locations').length > 0) {
    jQuery('#tag-description')
      .closest('.form-field')
      .find('label')
      .text('Enter any additional location information.');

    jQuery('#tag-description')
      .closest('.form-field')
      .find('p')
      .text('Enter any additional location information. You can use HTML.');

    jQuery('.column-description a span').text('Location Information');

    jQuery("label[for='description']").text('Enter any additional location information.');

    jQuery('.form-field')
      .find('#description')
      .next()
      .next('.description')
      .text('Enter any additional location information. You can use HTML.');
  }

  // Adds Collapseable admin menu

  jQuery('#jpg_collapse').click(function() {
    jQuery('body').toggleClass('jpg-folded');
  });

  //Reset Button Code

  jQuery('#tabs-1 .reset').click(function() {
    jQuery('#tabs-1 input[type=text]').val('');

    jQuery('#tabs-1 textarea').val('');
  });

  jQuery('#tabs-2 .reset').click(function() {
    jQuery('#tabs-2 input[type=text]').val('');

    jQuery('#tabs-2 textarea').val('');
  });

  jQuery('#tabs-3 .reset').click(function() {
    jQuery('#tabs-3 input[type=text]').val('');

    jQuery('#tabs-3 textarea').val('');

    jQuery('#tabs-3 select').val('Inherit');
  });

  jQuery('#tabs-4 .reset').click(function() {
    jQuery('#tabs-4 input[type=text]').val('');

    jQuery('#tabs-4 textarea').val('');
  });

  jQuery('#tabs-5 .reset').click(function() {
    jQuery('#tabs-5 input[type=text]').val('');

    jQuery('#tabs-5 textarea').val('');
  });

  jQuery('#tabs-6.reset').click(function() {
    jQuery('#tabs-6 input[type=text]').val('');

    jQuery('#tabs-6 textarea').val('');
  });

  jQuery('#tabs-7 .reset').click(function() {
    jQuery('#tabs-7 input[type=text]').val('');

    jQuery('#tabs-7 textarea').val('');
  });

  jQuery('#tabs-8 .reset').click(function() {
    jQuery('#tabs-8 input[type=text]').val('');

    jQuery('#tabs-8 textarea').val('');
  });

  jQuery('#tabs-9 .reset').click(function() {
    jQuery('#tabs-9 input[type=text]').val('');

    jQuery('#tabs-9 textarea').val('');
  });

  jQuery('#tabs-10 .reset').click(function() {
    jQuery('#tabs-10 input[type=text]').val('');

    jQuery('#tabs-10 textarea').val('');
  });

  jQuery('#tabs-11 .reset').click(function() {
    jQuery('#tabs-11 input[type=text]').val('');

    jQuery('#tabs-11 textarea').val('');
  });

  //Farbtastic Color Picker

  jQuery('.pickcolor').click(function(e) {
    colorPicker = jQuery(this).next('div');

    input = jQuery(this).prev('input');

    jQuery.farbtastic(jQuery(colorPicker), function(a) {
      jQuery(input)
        .val(a)
        .css('background', a);
    });

    colorPicker.show();

    e.preventDefault();

    jQuery(document).mousedown(function() {
      jQuery(colorPicker).hide();
    });
  });

  //Remove Media Button

  jQuery('.remove_media').click(function(e) {
    jQuery(this)
      .closest('tr')
      .find('.upload_image')
      .val('');

    return false; // prevent default click action from happening!

    e.preventDefault(); // same thing as above
  });

  //Toggle Highlight on Header image selection

  jQuery('#coupon_theme .header-sample').click(function(e) {
    jQuery('img.highlight')
      .not(e.target)
      .removeClass('highlight');

    jQuery(this).toggleClass('highlight');
  });

  jQuery('#coupon_theme input[type=radio][checked]').each(function() {
    jQuery(this)
      .next('label')
      .find('.header-sample')
      .addClass('highlight');
  });

  function exportTableToCSV($table, filename) {
    var $rows = $table.find('tr:has(td)'),
      // Temporary delimiter characters unlikely to be typed by keyboard
      // This is to avoid accidentally splitting the actual contents
      tmpColDelim = String.fromCharCode(11), // vertical tab character
      tmpRowDelim = String.fromCharCode(0), // null character
      // actual delimiter characters for CSV format
      colDelim = '","',
      rowDelim = '"\r\n"',
      // Grab text from table into CSV formatted string
      csv =
        '"' +
        $rows
          .map(function(i, row) {
            var $row = jQuery(row),
              $cols = $row.find('td');

            return $cols
              .map(function(j, col) {
                var $col = jQuery(col),
                  text = $col.text();

                return text.replace(/"/g, '""'); // escape double quotes
              })
              .get()
              .join(tmpColDelim);
          })
          .get()
          .join(tmpRowDelim)
          .split(tmpRowDelim)
          .join(rowDelim)
          .split(tmpColDelim)
          .join(colDelim) +
        '"',
      // Data URI
      csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

    jQuery(this).attr({
      download: filename,
      href: csvData,
      target: '_blank'
    });
  }

  // This must be a hyperlink
  jQuery('.export').on('click', function(event) {
    // CSV
    exportTableToCSV.apply(this, [jQuery('#ClipitEmailData>table'), 'clipit-export.csv']);

    // IF CSV, don't do event.preventDefault() or return false
    // We actually need this to be a typical hyperlink
  });
});
