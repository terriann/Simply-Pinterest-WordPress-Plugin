jQuery(document).ready(function() {

    jQuery('.bpp_post_wrapper img').each(function(){

        // Respect the no-pin
        // Exclude small images
        if( jQuery(this).attr('nopin') === 'nopin'
         || jQuery(this).get(0).clientWidth < 200) {
            return;
        }

        // Grab the post wrapper
        // @todo    ********************************
        // Could probably re-organize to address each post individually then loop through each image
        var bpp_post_wrapper = jQuery(this).closest('div.bpp_post_wrapper');

        // Create the pinterest URI for this image
        var bpp_href  = '//www.pinterest.com/pin/create/button/';
            bpp_href += '?url=' + encodeURI(jQuery(bpp_post_wrapper).data('bpp-pinlink'));
            bpp_href += '&media=' + encodeURI(jQuery(this).attr('src'));
            bpp_href += '&description=' + encodeURI(jQuery(this).attr('alt'));

        var bpp_button_wrap = jQuery('<span>')
                              .addClass('bpp_button_wrapper');

        // get color setting
        var bpp_color = jQuery(bpp_post_wrapper).data('bpp-color');
        var bpp_size = jQuery(bpp_post_wrapper).data('bpp-size');
        var bpp_lang = jQuery(bpp_post_wrapper).data('bpp-lang');
        var bpp_count = jQuery(bpp_post_wrapper).data('bpp-count');

        // Do not change these to data() cause then the number doesn't load
        var bpp_anchor = jQuery('<a>')
                         .attr('href', bpp_href)
                         .attr('data-pin-do', 'buttonPin')
                         .attr('data-pin-config', bpp_count)
                         .attr('data-pin-height', bpp_size)
                         .attr('data-pin-lang', bpp_lang)
                         .attr('data-pin-color', bpp_color);

        var bpp_button = jQuery('<img>').attr('src', '//assets.pinterest.com/images/pidgets/pinit_fg_'+bpp_lang+'_rect_'+bpp_color+'_'+bpp_size+'.png');

        // Append the button to the anchor inside the button wrapper for display
        var bpp_display = jQuery(bpp_button_wrap).append(jQuery(bpp_anchor).append(bpp_button));

        // Add miscelaneous classes to image wrapper
        var bpp_img_wrap_class = '';
        // If onhover setting is on set class
        if(jQuery(bpp_post_wrapper).data('bpp-pinhover') == true) {
            bpp_img_wrap_class += " onhover";
        }
        // set the corner the pin belongs
        if(jQuery(bpp_post_wrapper).data('bpp-pincorner')) {
            bpp_img_wrap_class += " " + jQuery(bpp_post_wrapper).data('bpp-pincorner');
        }
        // If it's the large button
        if(bpp_size == 28) {
            bpp_img_wrap_class += " large";
        }
        // Add class for count_above, count_none and count_beside
        bpp_img_wrap_class += " count_"+bpp_count;

        // Add wrapper and drop button after image
        if(jQuery(this).parent('a').length > 0) {
            jQuery(this).parent('a').wrap('<div class="bpp_img_wrapper' + bpp_img_wrap_class + '"></div>');
            jQuery(this).parent('a').after(bpp_display);
        } else {
            jQuery(this).wrap('<div class="bpp_img_wrapper' + bpp_img_wrap_class + '"></div>');
            jQuery(this).after(bpp_display);
        }
    });

});