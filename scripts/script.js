jQuery(document).ready(function() {

    var version = '0.1.6';

    // Loop through each post
    jQuery('.spp_post_wrapper').each(function(){

        var $spp_post = jQuery(this);

        // get configured setting
        var spp_color = $spp_post.data('spp-color'),
            spp_size = $spp_post.data('spp-size'),
            spp_lang = $spp_post.data('spp-lang'),
            spp_count = $spp_post.data('spp-count'),
            spp_pinhover = $spp_post.data('spp-pinhover'),
            spp_pincorner = $spp_post.data('spp-pincorner'),
            spp_pinlink = $spp_post.data('spp-pinlink'),
            spp_append = $spp_post.data('spp-append'),
            spp_important = $spp_post.data('spp-important');


        spp_append = (spp_append && spp_append.length > 0) ? ' ' + $spp_post.data('spp-append') : '';

        // Loop through each image in a post
        $spp_post.find('img').each(function(){

            var spp_img = this;

            // Respect the no-pin
            // Exclude small images
            if( jQuery(spp_img).attr('nopin') === 'nopin'
             || jQuery(spp_img).get(0).clientWidth < 200) {
                return;
            }

            // Special hack for lazy load plugins
            var spp_mediasrc = jQuery(spp_img).attr('src');
            if(spp_mediasrc != '' || spp_mediasrc.substr(0, 5) == 'data:') {
                if(jQuery(spp_img).data('lazy-src')){
                    spp_mediasrc = jQuery(spp_img).data('lazy-src');
                }
            }

            // Create the pinterest URI for this image
            var spp_href  = '//www.pinterest.com/pin/create/button/';
                spp_href += '?url=' + encodeURI(spp_pinlink);
                spp_href += '&media=' + encodeURI(spp_mediasrc);
                spp_href += '&description=' + encodeURI(jQuery(spp_img).attr('alt') + spp_append);

            var spp_button_wrap = jQuery('<span>')
                                  .addClass('spp_button_wrapper');

            // Do not change these to data() cause then the number doesn't load
            var spp_anchor = jQuery('<a>')
                             .attr('href', spp_href)
                             .attr('data-pin-do', 'buttonPin')
                             .attr('data-pin-config', spp_count)
                             .attr('data-pin-height', spp_size)
                             .attr('data-pin-lang', spp_lang)
                             .attr('data-pin-color', spp_color);

            var spp_button = jQuery('<img>').attr('src', '//assets.pinterest.com/images/pidgets/pinit_fg_'+spp_lang+'_rect_'+spp_color+'_'+spp_size+'.png');

            // Append the button to the anchor inside the button wrapper for display
            var spp_display = jQuery(spp_button_wrap).append(jQuery(spp_anchor).append(spp_button));

            // Add miscelaneous classes to image wrapper
            var spp_img_wrap_class = '';

            // Ability to override hover settings on a per-image basis
            var _i_spp_pinhover = jQuery(spp_img).data('spp-pinhover');
            if( (spp_pinhover == true && _i_spp_pinhover != 'always')
                || _i_spp_pinhover == 'onhover') {
                spp_img_wrap_class += " onhover";
            }
            // set the corner the pin belongs
            if(spp_pincorner) {
                spp_img_wrap_class += " " + spp_pincorner;
            }
            // If it's the large button
            if(spp_size == 28) {
                spp_img_wrap_class += " large";
            }
            // Add class for count_above, count_none and count_beside
            spp_img_wrap_class += " count_"+spp_count;

            // Add wrapper and drop button after image
            if(jQuery(spp_img).parent('a').length > 0) {
                jQuery(spp_img).parent('a').wrap('<span class="spp_img_wrapper' + spp_img_wrap_class + '"></span>');
                jQuery(spp_img).parent('a').after(spp_display);
                var spp_parentparent = jQuery(spp_img).parent('a').parent().parent().get(0);
            } else {
                jQuery(spp_img).wrap('<span class="spp_img_wrapper' + spp_img_wrap_class + '"></span>');
                jQuery(spp_img).after(spp_display);
                var spp_parentparent = jQuery(spp_img).parent().parent().get(0);
            }

            var spp_transferclass = ['alignnone', 'alignleft', 'aligncenter', 'alignright'];

            jQuery.each( spp_transferclass, function( key, value ) {
                if(jQuery(spp_img).hasClass(value)) {
                    if(spp_important){
                        jQuery(spp_parentparent).addClass('spp_imp');
                    }
                    jQuery(spp_parentparent).addClass(value);
                }
            });

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
  function a(a,b){var c='font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: 15px;'+(a?"font-weight: bold;":"")+"color: "+b+";";return c}konsole.log("%c♥web%c( function(){ %creturn true %c}); --> %ccontactMe()",a(!0,"#d22"),a(!0,"#777"),a(!0,"#2b2"),a(!0,"#777"),a(!0,"#2b2"));
  function contactMe(){ document.location.href = 'http://terriswallow.com' };
}

