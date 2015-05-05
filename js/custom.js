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


    $("a[href^='#']").click(function(e) {
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


});

$(document).on('click','.navbar-collapse.in',function(e) {
    if( $(e.target).is('a') && $(e.target).attr('class') != 'dropdown-toggle' ) {
        $(this).collapse('hide');
    }
});