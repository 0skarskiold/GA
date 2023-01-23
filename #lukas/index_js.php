<script>

$(document).ready(function() {

    $('button.scroll').click(function() {
        var list_selector = '#' + $(this).attr('for') + ' .item_list';

        if($(list_selector).length > 0) {
            
            var num_children = $(list_selector).children('li').length;
            var lim = 0;

            for(let i = num_children; i > 5; i--) {
                if(i % 5 == 1) { lim -= 550; }
            }

            if($(this).hasClass('r')) {
                if(parseInt($(list_selector).css('left')) > lim && !$(list_selector).is(':animated')) {
                    $(list_selector).animate({left: "-=550px"});
                }
            } else if($(this).hasClass('l')) {
                if(parseInt($(list_selector).css('left')) < 0 && !$(list_selector).is(':animated')) {
                    $(list_selector).animate({left: "+=550px"});
                }
            }
        }
    });
});

</script>