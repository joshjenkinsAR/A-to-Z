jQuery(document).ready(function(){
    jQuery("#filter").keyup(function(){
 
        var filter = jQuery(this).val();
 
        jQuery("ul.item-list li, .letter-section").each(function(){
 
         
            if (jQuery(this).text().search(new RegExp(filter, "i")) < 0) {
                jQuery(this).fadeOut();
 
            } else {
                jQuery(this).show();
            }
        });
 
       // var numberItems = count;
        //jQuery("#filter-count").text("Number of xyz = "+count); 
    });
});



jQuery(document).ready(function() {
    var num_cols = 3,
    container = jQuery('.item-list'),
    listItem = 'li',
    listClass = 'sub-list';
    container.each(function() {
        var items_per_col = new Array(),
        items = jQuery(this).find(listItem),
        min_items_per_col = Math.floor(items.length / num_cols),
        difference = items.length - (min_items_per_col * num_cols);
        for (var i = 0; i < num_cols; i++) {
            if (i < difference) {
                items_per_col[i] = min_items_per_col + 1;
            } else {
                items_per_col[i] = min_items_per_col;
            }
        }
        for (var i = 0; i < num_cols; i++) {
            jQuery(this).append(jQuery('<ul ></ul>').addClass(listClass));
            for (var j = 0; j < items_per_col[i]; j++) {
                var pointer = 0;
                for (var k = 0; k < i; k++) {
                    pointer += items_per_col[k];
                }
                jQuery(this).find('.' + listClass).last().append(items[j + pointer]);
            }
        }
    });
});

//Fixed header anchor link scroll
window.addEventListener("hashchange", function() { scrollBy(0, -100) })

// slide toggle for items

jQuery(document).ready(function(){
    jQuery(".plus-icon").click(function(){
		jQuery(this).toggleClass("open");
        jQuery(this).siblings(".hidden-card").toggleClass("open");
    });
});