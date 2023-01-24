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

    $('input#create-search').focus(function() {
        $(this).keyup(function() {
            
            let str = $(this).val()
            
            if(str.length > 0) {

                $.ajax({

                    context: this,
                    url:'create_receive.php',
                    method:"POST",
                    data:{createSearch:"on", input:str},

                    success: function(data) {

                        items = JSON.parse(data);
                        if(items.length > 0) {
                            let type = '<?php echo $_POST['type']; ?>';
                            let result = '';

                            items.forEach(function(item) {
                                result += '<form action="/create" method="post">';
                                result += '<input type="hidden" name="itemid" value="'.concat(item['id'].toString(), '">');
                                result += '<input type="hidden" name="type" value="'.concat(type, '">');
                                result += '<button type="submit">';
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
            $('.log-exclusive').after('<div class="review-exclusive"><textarea name="review_text" maxlength="10000" cols="30" rows="10" style="resize: none;"></textarea><label for="review-date">Date of review</label><input type="date" value="<?php echo date('Y-m-d'); ?>" name="review-date" /><input type="checkbox" name="spoilers">Includes Spoilers</input></div>');
            $(this).removeClass('add');
            $(this).addClass('remove');
            $(this).text('Remove review');
        } else if($(this).hasClass('remove')) {
            $('.review-exclusive').remove();
            $(this).removeClass('remove');
            $(this).addClass('add');
            $(this).text('Attach review');
        }
    });

    $('button[name="toggle-log"]').click(function() {
        if($(this).hasClass('add')) {
            $('.review-exclusive').before('<div class="log-exclusive"><label for="log-date">When watched</label><input type="date" value="<?php echo date('Y-m-d'); ?>" name="log-date" /><input type="checkbox" name="rewatch">I\'ve seen this before</input></div>');
            $(this).removeClass('add');
            $(this).addClass('remove');
            $(this).text('Remove diary entry');
        } else if($(this).hasClass('remove')) {
            $('.log-exclusive').remove();
            $(this).removeClass('remove');
            $(this).addClass('add');
            $(this).text('Attach diary entry');
        }
    });
});

</script>