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


/* --- Make Email Link  --- */

    $('.make-email-link').each(function(){
        var email = $(this).data('nm') + '@' + $(this).data('dmn') + '.' + $(this).data('tld');
        var anchor = $('<a>').attr('href', 'mailto:'+email).html(email);

        $(this).html(anchor);
    });



/* ---- Video Functionality ----- */
    // Loop HTML5 video
    $("#config-video").bind('ended', function(){ 
      this.play();
    });
    

    // Show overlay on hover
    $("#config-video, #video-hover").on('mouseenter', function(){
        $('#video-hover').height($("#config-video").height());
        $('#video-hover').addClass("on");
    });
    $("#config-video, #video-hover").on('mouseleave', function(){ 
        $('#video-hover').removeClass("on");
    });
    
    // Starts video from the beginning each time modal is launched
    $('#videoModal').on('show.bs.modal', function (e) {
        $(this).find('iframe').attr('src', $(this).find('iframe').attr('src'));
    })


/* ---- Event tracking ----- */
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


/* ---- Slide show carousel ---- */
    /* copy loaded thumbnails into carousel */

    $('.gallery a[href="#"]').on('click', function(e){
        e.preventDefault();
    });
    $('.row .thumbnail').on('ready', function() { }).each(function(i) {
        var item = $('<div class="item"></div>');
        var itemDiv = $(this).parents('div');
        var title = $(this).parent('a').attr("title");

        item.attr("title",title);
        $(itemDiv.html()).appendTo(item);
        item.appendTo('#screenshotModal .carousel-inner');

        if (i==0){ // set first item active
            $('#screenshotModal .modal-title').html(item.attr("title"));
            $('#screenshotModal .modal-desc').html(item.find('img').attr("alt"));
            item.addClass('active');
        }
    });

    /* activate the carousel */
    $('#modalCarousel').carousel({interval:false});

    /* change modal title when slide changes */
    $('#modalCarousel').on('slid.bs.carousel', function () {
      $('#screenshotModal .modal-title').html($(this).find('.active').attr("title"));
      $('#screenshotModal .modal-desc').html($(this).find('.active').find('img').attr("alt"));
    })

    /* when clicking a thumbnail */
    $('.row .thumbnail').click(function(){
        var idx = $(this).parents('div').index();
        var id = parseInt(idx);
        $('#screenshotModal').modal('show'); // show the modal
        $('#modalCarousel').carousel(id); // slide carousel to selected

    });
/** END Slide show carousel **/

});

/* Toggle mobile dropdown menu to close when link is clicked */
$(document).on('click','.navbar-collapse.in',function(e) {
    if( $(e.target).is('a') && $(e.target).attr('class') != 'dropdown-toggle' ) {
        $(this).collapse('hide');
    }
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