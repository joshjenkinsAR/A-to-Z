jQuery(document).ready(function(){
    jQuery("#filter").keyup(function(){
 
        var filter = jQuery(this).val();
 
        jQuery("ul.individual-item-list li, .letter-section").each(function(){
 
         
            if (jQuery(this).text().search(new RegExp(filter, "i")) < 0) {
                jQuery(this).fadeOut();
 
            } else {
                jQuery(this).show();
            }
        });
 
       // var numberItems = count;
        //jQuery("#filter-count").text("Number of Comments = "+count);
    });
});