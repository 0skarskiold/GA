<script>

$(document).ready(function() {

    $('.item_list').each(function() {
        if($(this).children('li').length <= 5) {
            let button_selector = '.item_list_section[list-name="' + $(this).attr('list-name') + '"] .button.scroll';
            $(button_selector).attr('hidden', true);
            // $(button_selector + '.l, ' + button_selector + '.r').attr('hidden', true);
        }
    });

    $('.button.scroll').click(function() {
        var list_selector = '.item_list[list-name="' + $(this).attr('list-name') + '"]';
            
        var num_children = $(list_selector).children('li').length;
        var lim = 0;

        for(let i = num_children; i > 5; i--) {
            if(i % 5 == 1) { lim -= 550; }
        }

        if($(this).hasClass('r')) {
            console.log(num_children);
            if(parseInt($(list_selector).css('left')) > lim && !$(list_selector).is(':animated')) {
                $(list_selector).animate({left: "-=550px"});
            }
        } else if($(this).hasClass('l')) {
            if(parseInt($(list_selector).css('left')) < 0 && !$(list_selector).is(':animated')) {
                $(list_selector).animate({left: "+=550px"});
            }
        }
    });
});

</script>