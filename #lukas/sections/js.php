<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

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

    $(document).on('click', '.follow', function() {

        if($(this).hasClass('insert')) {
            var action = "follow";
        } else if($(this).hasClass('delete')) {
            var action = "unfollow";
        }

        var to_id = $(this).data("userid"); // varför funkar inte let?
        var from_id = <?php if(isset($_SESSION['userid'])) { echo $_SESSION['userid']; } else { echo "null"; } ?>;	

        $.ajax({

            context: this,
            url:'/includes/account/follow.inc.php',
            method:"POST",
            data:{to_id:to_id, from_id:from_id, action:action},
            
            success: function() {

                // console.log(action);
                if(action === "follow") {
                    $(this).removeClass('insert');
                    $(this).addClass('delete');
                    $(this).text('Unfollow');
                    action = "unfollow";
                } else if(action === "unfollow") {
                    $(this).removeClass('delete');
                    $(this).addClass('insert');
                    $(this).text('Follow');
                    action = "follow";
                }

            }
        });
    });

    $(document).ready(function() {

        $('#like').hover(function() {
            if($(this).hasClass('inactive')) {
                $(this).attr('src','https://img.icons8.com/ios-glyphs/30/null/like--v1.png');
            } else if($(this).hasClass('active')) {
                $(this).attr('src','https://img.icons8.com/ios-glyphs/30/null/hearts.png');
            }
        }, function() {
            if($(this).hasClass('inactive')) {
                $(this).attr('src','https://img.icons8.com/ios-glyphs/30/null/hearts.png');
            } else if($(this).hasClass('active')) {
                $(this).attr('src','https://img.icons8.com/ios-glyphs/30/null/like--v1.png');
            }
        });

        $('#like').click(function() {
            if($(this).hasClass('inactive')) {
                $(this).attr('src','https://img.icons8.com/ios-glyphs/30/null/hearts.png');
                $(this).removeClass('inactive');
                $(this).addClass('active');
                $('input[name="like"]').attr('value', 'on');
                // ngn animation
            } else if($(this).hasClass('active')) {
                $(this).attr('src','https://img.icons8.com/ios-glyphs/30/null/like--v1.png');
                $(this).removeClass('active');
                $(this).addClass('inactive');
                $('input[name="like"]').attr('value', 'off');
                // ngn animation
            }
        });

        $('button[name="toggle_rating"]').click(function() {
            if($(this).hasClass('add')) {
                $('#star_container').removeClass('inactive');
                $(this).removeClass('add');
                $(this).addClass('remove');
                $(this).text('Remove Rating');
            } else if($(this).hasClass('remove')) {
                $('#star_container').addClass('inactive');
                $(this).removeClass('remove');
                $(this).addClass('add');
                $(this).text('Add Rating');
            }
        });


        $('#stars_false').hover(function() {
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
    });

    $(document).ready(function() {
        $("#csearch").focus(function() {
            $(this).keyup(function() {
                
                let str = $(this).val()
                
                if(str.length > 0) {

                    $.ajax({

                        context: this,
                        url:'/includes/listgen/csearch.inc.php',
                        method:"POST",
                        data:{scsearch:"on", input:str},

                        success: function(data) {

                            items = JSON.parse(data);
                            if(items.length > 0) {
                                let link = '<?php echo $_SERVER['REQUEST_URI']; ?>';
                                let elements = '';

                                items.forEach(function(item) {
                                    elements += ''.concat('<a href="', link, '&itemid=', item['id'], '">', item['name'], ' (', item['year'], ')', '</a>');
                                });

                                $(".results").empty();
                                $(".results").append(elements);
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
    });

    $(document).ready(function() {
        $('button[name="toggle_review"]').click(function() {
            if($(this).hasClass('add')) {
                $('.log-excl').after('<div class="review-excl"><textarea name="review_text" maxlength="10000" cols="30" rows="10" style="resize: none;"></textarea><label for="review-date">Date of review</label><input type="date" value="<?php echo date('Y-m-d'); ?>" name="review-date" /><input type="checkbox" name="spoilers">Includes Spoilers</input></div>');
                $('button[type="submit"]').attr('name', 'submit-log-review');
                $(this).removeClass('add');
                $(this).addClass('remove');
                $(this).text('Remove Review');
            } else if($(this).hasClass('remove')) {
                $('.review-excl').remove();
                $('button[type="submit"]').attr('name', 'submit-log');
                $(this).removeClass('remove');
                $(this).addClass('add');
                $(this).text('Attach Review');
            }
        });

        $('button[name="toggle_log"]').click(function() {
            if($(this).hasClass('add')) {
                $('.review-excl').before('<div class="log-excl"><label for="log-date">When watched</label><input type="date" value="<?php echo date('Y-m-d'); ?>" name="log-date" /><input type="checkbox" name="rewatch">I\'ve seen this before</input></div>');
                $('button[type="submit"]').attr('name', 'submit-log-review');
                $(this).removeClass('add');
                $(this).addClass('remove');
                $(this).text('Remove Diary Entry');
            } else if($(this).hasClass('remove')) {
                $('.log-excl').remove();
                $('button[type="submit"]').attr('name', 'submit-review');
                $(this).removeClass('remove');
                $(this).addClass('add');
                $(this).text('Attach Diary Entry');
            }
        });
    });

    $(document).ready(function() {
        $('.like_review').click(function() {

            if($(this).hasClass('inactive')) {
                var action = 'like';
            } else if($(this).hasClass('active')) {
                var action = 'unlike';
            }

            var entry_id = $(this).data("entryid");
            var user_id = <?php if(isset($_SESSION['userid'])) { echo $_SESSION['userid']; } else { echo "null"; } ?>;	

            $.ajax({

                context: this,
                url:'/includes/entry2.inc.php',
                method:"POST",
                data:{user_id:user_id, entry_id:entry_id, action:action},

                success: function() {

                    console.log(action);
                    if(action === "like") {
                        $(this).removeClass('inactive');
                        $(this).addClass('active');
                        $(this).css('background-color', 'magenta');
                        action = "unlike";
                    } else if(action === "unlike") {
                        $(this).removeClass('active');
                        $(this).addClass('inactive');
                        $(this).css('background-color', 'blue');
                        action = "like";
                    }

                }
            });
        });
    });

</script>