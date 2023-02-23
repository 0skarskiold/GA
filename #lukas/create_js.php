<?php require_once("create_functions.php"); ?>

<script>

$(document).ready(function() {

    $('#like').click(function() {
        if($(this).hasClass('inactive')) {
            $(this).removeClass('inactive');
            $(this).addClass('active');
            $('input[name="like"]').attr('value', '1');
            // ngn animation
        } else if($(this).hasClass('active')) {
            $(this).removeClass('active');
            $(this).addClass('inactive');
            $('input[name="like"]').attr('value', '0');
            // ngn animation
        }
    });

    $('button[name="toggle-rating"]').click(function() {
        if($(this).hasClass('add')) {
            $('#star_container').removeClass('inactive');
            $(this).removeClass('add');
            $(this).addClass('remove');
            $(this).text('Remove rating');
        } else if($(this).hasClass('remove')) {
            $('#star_container').addClass('inactive');
            $(this).removeClass('remove');
            $(this).addClass('add');
            $(this).text('Add rating');
        }
    });

    $('ul.stars').hover(function() {
        $('.half-star').mouseover(function() {
            if(!$('#star_container').hasClass('inactive')) {
                let lim = $(this).data("nbr");
                for(let i = 0; i <= lim; i++) {
                    $('.half-star[data-nbr="'+i+'"').addClass('hover');
                }
                for(let i = lim+1; i <= 10; i++) {
                    $('.half-star[data-nbr="'+i+'"').removeClass('hover');
                }
            };
        });
    }, function() {
        $('.half-star').removeClass('hover');
    });

    $('.half-star').click(function() {
        if(!$('#star_container').hasClass('inactive')) {
            let score = $(this).data("nbr");
            $('input[name="rating"]').attr('value', score/2);
            for(let i = 0; i <= score; i++) {
                $('.half-star[data-nbr="'+i+'"').addClass('activated');
            }
            for(let i = score+1; i <= 10; i++) {
                $('.half-star[data-nbr="'+i+'"').removeClass('activated');
            }
        };
    });

    $('section#create_search input').focus(function() {
        $(this).keyup(function() {
            
            let str = $(this).val()
            
            if(str.length > 0) {

                $.ajax({

                    context: this,
                    url:'create_receive.php',
                    method:"POST",
                    data:{csearch:"on", input:str},

                    success: function(data) {

                        items = JSON.parse(data);
                        if(items.length > 0) {
                            let type = '<?php echo $_GET['type']; ?>';
                            let result = '';

                            items.forEach(function(item) {
                                result += '<form action="/create" method="get">';
                                result += '<input type="hidden" name="item" value="'.concat(item['uid'].toString(), '">');
                                result += '<input type="hidden" name="type" value="'.concat(type, '">');
                                result += '<button type="submit" class="button">';
                                result += item['name'].concat(' (', item['year'].toString(), ')');
                                result += '</button></form>';
                            });

                            $(".results").empty();
                            $(".results").append(result);
                        } else {
                            $(".results").empty();
                        }
                    }
                });
            } else {
                $(".results").empty();
            }
        });
    });

    $('button[name="toggle-review"]').click(function() {
        if($(this).hasClass('add')) {
            $('.log_exclusive').after(<?php echo json_encode(preparePromptExclusive('review', '')); ?>);
            $(this).removeClass('add');
            $(this).addClass('remove');
            $(this).text('Remove Review');
        } else if($(this).hasClass('remove')) {
            $('.review_exclusive').remove();
            $(this).removeClass('remove');
            $(this).addClass('add');
            $(this).text('Attach Review');
        }
    });

    $('button[name="toggle-log"]').click(function() {
        if($(this).hasClass('add')) {
            $('.review_exclusive').before(<?php echo json_encode(preparePromptExclusive('log', '')); ?>);
            $(this).removeClass('add');
            $(this).addClass('remove');
            $(this).text('Remove Diary Entry');
        } else if($(this).hasClass('remove')) {
            $('.log_exclusive').remove();
            $(this).removeClass('remove');
            $(this).addClass('add');
            $(this).text('Attach Diary Entry');
        }
    });
});

</script>