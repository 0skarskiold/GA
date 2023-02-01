<script>

$(document).ready(function() {

    if($('.item_list').first().children('li').length <= 5) {
        $('button.scroll').attr('hidden', true);

    } else {

        $('button.scroll').click(function() {
            var list_selector = '.item_list_container#' + $(this).attr('for') + ' .item_list';
                
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
    }
});

</script>