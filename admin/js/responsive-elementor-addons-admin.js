jQuery(document).ready(function(){
    jQuery(".responsive-elementor-addons-quick-links").click(function(){
        if(jQuery(".responsive-elementor-addons-quick-links").hasClass( "responsive-elementor-addons-quick-links-close" )) {
            jQuery(".responsive-elementor-addons-quick-links").removeClass( "responsive-elementor-addons-quick-links-close" );
            jQuery(".responsive-elementor-addons-quick-links").addClass( "responsive-elementor-addons-quick-links-open" );
        } else {
            jQuery(".responsive-elementor-addons-quick-links").addClass( "responsive-elementor-addons-quick-links-close" );
            jQuery(".responsive-elementor-addons-quick-links").removeClass( "responsive-elementor-addons-quick-links-open" );
        }
    });
    jQuery('#rea-gsv-image-link').on('click', function(ev) {
        let link = jQuery("#rea-gsv-yt-player")[0].src;
        link = link.replace("autoplay=0", "autoplay=1");
        jQuery("#rea-gsv-yt-player")[0].src = link;
    });
    jQuery('#rea-getting-started-video').on('hidden.bs.modal', function () {
        let link = jQuery("#rea-gsv-yt-player")[0].src;
        link = link.replace("autoplay=1", "autoplay=0");
        jQuery("#rea-gsv-yt-player")[0].src = link;
    });
});
