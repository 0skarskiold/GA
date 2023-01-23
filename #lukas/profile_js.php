<script>

$(document).ready(function() {

    $('.follow').click(function() {

        if($(this).hasClass('insert')) {
            var action = "follow";
        } else if($(this).hasClass('delete')) {
            var action = "unfollow";
        }

        var to_id = $(this).data("userid");
        var from_id = <?php if(isset($_SESSION['userid'])) { echo $_SESSION['userid']; } else { echo "null"; } ?>; // hur gör man detta utan att blanda js och php?

        $.ajax({

            context: this,
            url:'profile_receive.php',
            method:"POST",
            data:{to_id:to_id, from_id:from_id, action:action},
            
            success: function() {

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
});

</script>