#Better Pinterst Plugin

What makes this a "better" Pinterest plugin? Well, it's built by a web developer who crafts & blogs in her free time, that means she built this plugin to work for marketing Pinterst on her own products. Plus, it's free.  I could have charged $20 per download but I think open source code is neat and inspired by the fact that Pinterst open sources their stuff it seems like a good code gesture.

What's 


Make own pinterest plugin

https://business.pinterest.com/en/widget-builder#do_pin_it_button

I purchased a pinterest plugin and was almost immediately disappointed in it so I did what I should have done from the beginning, I built my own.

1. Wrap each post with a .bpp_pinwrapper class
	- Use data-bpp-pinlink="" to ensure pin attributes to permalink page
	- Use data-bpp-pincorner="" for default corner (top right)
	- Use data-bpp-pinhover="false" to always show
2. Add JS to catch all images > 200px and add a Pinterest button to em w/ correct overlay
	- Use attributes from above!
    - Use ALT tag on image for description
3. Make settings page for defaults
    - Use data-bpp-pindescription="" attr w/ SEO setting (Genesis & Yoast & allinone SEO support)
	- default pincorner settings"northeast|northeast|southeast|southwest"
	- default show pin on hover/offhover
4. Make configuration for editing images already in post
	- nopin="nopin" attribute
	- data-bpp-pincorner="northeast|northeast|southeast|southwest" attribute
	- Setting for data-bpp-onhover="" (will override default)

What I didn't like about the other Pinterest button:

- It overlapped poorly and had a negative impact on my layout - it shifted things and offset stuff and that wasn't what I was looking for, their demos didn't do that but in all cases even with other plugins disabled I still had issues.
- It injected markup into my post...gross, this should all be done with javascript as much as possible to make it portable. To me this was a sign of an amateur developer
- It was a $20 plugin that I paid for and was upset with, I'd rather spend time making a free one that works...
- They used !important in their style sheet. Again a sign of an armature developer, just tightly define your definitions; if someone wants to override the styles in their theme they should be able to!!



<a href="//www.pinterest.com/pin/create/button/?url=http%3A%2F%2Fwww.flickr.com%2Fphotos%2Fkentbrew%2F6851755809%2F&media=http%3A%2F%2Ffarm8.staticflickr.com%2F7027%2F6851755809_df5b2051c9_z.jpg&description=Next%20stop%3A%20Pinterest" data-pin-do="buttonPin" data-pin-config="above" data-pin-color="red"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_red_20.png" /></a>
<!-- Please call pinit.js only once per page -->
<script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>


<a href="//www.pinterest.com/pin/create/button/?url=http%3A%2F%2Fwww.flickr.com%2Fphotos%2Fkentbrew%2F6851755809%2F&media=http%3A%2F%2Ffarm8.staticflickr.com%2F7027%2F6851755809_df5b2051c9_z.jpg&description=Next%20stop%3A%20Pinterest" data-pin-do="buttonPin" data-pin-config="above"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" /></a>
<!-- Please call pinit.js only once per page -->
<script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>

Good post on preventing pinning entirely
https://help.pinterest.com/en/articles/prevent-pinning-your-site

Extension FAQ
https://developers.pinterest.com/extension_faq/

Might be useful to check out:
https://www.addtoany.com/buttons/customize/pinterest_pin_it_button



Future settings:
- Large button
- Number on the site (no number) and CSS to adjust

Other Todos:
- Sanitize/validate input
- Set default values on initializing the plugin