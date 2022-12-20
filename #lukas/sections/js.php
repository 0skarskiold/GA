<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<script>

    $(document).ready(function() {

        $("#btn_r").click(function() {
            $('.item_list').animate({left: "+=550px"});
        });

        $("#btn_l").click(function() {
            $('.item_list').animate({left: "-=550px"});
        });

    });

    $(document).on('click', '.follow', function() {

        if($(this).hasClass('insert')) {
            var action = "follow";
        } else if($(this).hasClass('delete')) {
            var action = "unfollow";
        }

        var to_id = $(this).data("userid");
        var from_id = <?php if(isset($_SESSION['userid'])) { echo $_SESSION['userid']; } else { echo "null"; } ?>;	

        $.ajax({

            context: this,
            url:'/includes/account/follow.inc.php',
            method:"POST",
            data:{to_id:to_id, from_id:from_id, action:action},
            
            success: function() {

                console.log(action);
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
                    var lim = $(this).data("nbr");
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
                var score = $(this).data("nbr");
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

</script>