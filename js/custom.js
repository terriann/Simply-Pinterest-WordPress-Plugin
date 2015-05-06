$( document ).ready(function() {

    $('.next-btn').each(function(){
        $(this).on('click', function(e){
            e.preventDefault();
            var currentpane = $(this).data('currentpane');
            var togglepane = $(this).data('togglepane');

            $('#'+currentpane).hide();
            $('#' + togglepane).removeClass('hidden').show();

        });
    });

    $("a.scrollto").click(function(e) {
        e.preventDefault();

        var anchor = $(this).attr('href').substring(1);
        ga('send', 'event', 'anchor', anchor);

        $('html, body').animate({
            scrollTop: $("a[name='"+anchor+"']").offset().top
        }, 2000);
    });


    // Event tracking
    // Tracking downloads
    $('.intro-message a.download').on('click', function() {
        ga('send', 'event', 'button', 'download', 'header');
    });
    $('#page-end a.download').on('click', function() {
        ga('send', 'event', 'button', 'download', 'footer');
    });
    $('#install-guide .ftp-instructions a.download').on('click', function() {
        ga('send', 'event', 'link', 'download', 'ftp-install');
    });
    $('#install-guide .admin-instructions a.download').on('click', function() {
        ga('send', 'event', 'link', 'download', 'ftp-install');
    });

    // Tips next btn
    $('#pinterest-tips button').on('click', function() {
        ga('send', 'event', 'button', 'pinterest-tips', $(this).data('togglepane'));
    });

    // Config next button
    $('#config-options button').on('click', function() {
        ga('send', 'event', 'button', 'config-options', $(this).data('togglepane'));
    });

    // external clicks
    $("a[href^='htt']").on('click', function() {
        ga('send', 'event', 'external', 'click',  $(this).attr('href'));
    });


/** Slide show carousel **/
    /* copy loaded thumbnails into carousel */
    $('.row .thumbnail').on('load', function() {

    }).each(function(i) {
      if(this.complete) {
        var item = $('<div class="item"></div>');
        var itemDiv = $(this).parents('div');
        var title = $(this).parent('a').attr("title");

        item.attr("title",title);
        $(itemDiv.html()).appendTo(item);
        item.appendTo('.carousel-inner');
        if (i==0){ // set first item active
         item.addClass('active');
        }
      }
    });

    /* activate the carousel */
    $('#modalCarousel').carousel({interval:false});

    /* change modal title when slide changes */
    $('#modalCarousel').on('slid.bs.carousel', function () {
      $('.modal-title').html($(this).find('.active').attr("title"));
      $('.modal-desc').html($(this).find('.active').find('img').attr("alt"));
    })

    /* when clicking a thumbnail */
    $('.row .thumbnail').click(function(){
        var idx = $(this).parents('div').index();
        var id = parseInt(idx);
        $('#myModal').modal('show'); // show the modal
        $('#modalCarousel').carousel(id); // slide carousel to selected

    });
/** END Slide show carousel **/

});


$(document).on('click','.navbar-collapse.in',function(e) {
    if( $(e.target).is('a') && $(e.target).attr('class') != 'dropdown-toggle' ) {
        $(this).collapse('hide');
    }
});
