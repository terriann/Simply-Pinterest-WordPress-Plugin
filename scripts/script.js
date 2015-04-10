jQuery(document).ready(function() {

    var version = '0.1.5';

    // Loop through each post
    jQuery('.bpp_post_wrapper').each(function(){

        var $bpp_post = jQuery(this);

        // get configured setting
        var bpp_color = $bpp_post.data('bpp-color'),
            bpp_size = $bpp_post.data('bpp-size'),
            bpp_lang = $bpp_post.data('bpp-lang'),
            bpp_count = $bpp_post.data('bpp-count'),
            bpp_pinhover = $bpp_post.data('bpp-pinhover'),
            bpp_pincorner = $bpp_post.data('bpp-pincorner'),
            bpp_pinlink = $bpp_post.data('bpp-pinlink');

        // Loop through each image in a post
        $bpp_post.find('img').each(function(){

            // Respect the no-pin
            // Exclude small images
            if( jQuery(this).attr('nopin') === 'nopin'
             || jQuery(this).get(0).clientWidth < 200) {
                return;
            }


            // Special hack for BJ Lazy Load
            var bpp_mediasrc = jQuery(this).attr('src');
            if(bpp_mediasrc != '' || bpp_mediasrc.substr(0, 5) == 'data:') {
                if(jQuery(this).data('lazy-src')){
                    bpp_mediasrc = jQuery(this).data('lazy-src');
                }
            }

            // Create the pinterest URI for this image
            var bpp_href  = '//www.pinterest.com/pin/create/button/';
                bpp_href += '?url=' + encodeURI(bpp_pinlink);
                bpp_href += '&media=' + encodeURI(bpp_mediasrc);
                bpp_href += '&description=' + encodeURI(jQuery(this).attr('alt'));

            var bpp_button_wrap = jQuery('<span>')
                                  .addClass('bpp_button_wrapper');

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
            if(bpp_pinhover == true) {
                bpp_img_wrap_class += " onhover";
            }
            // set the corner the pin belongs
            if(bpp_pincorner) {
                bpp_img_wrap_class += " " + bpp_pincorner;
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

        // End looping through each image in a post
        });
    // End looping through each post
    });
// End on ready
});

/* konsole is a safe wrapper for the Firebug console. */
var konsole = {
  log: function(args){},
  dir: function(args){}
};
// Remove below here when in production
if (typeof window.console != 'undefined' && typeof window.console.log == 'function') {
  konsole = window.console;
  konsole.log("konsole initialized");
}