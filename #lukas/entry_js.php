<script>

$(document).ready(function() {
    $('.like_review').click(function() {

        if($(this).hasClass('inactive')) {
            var action = 'like';
        } else if($(this).hasClass('active')) {
            var action = 'unlike';
        }

        var entry_id = $(this).data("entryid");
        var user_id = <?php if(isset($_SESSION['user-id'])) { echo $_SESSION['user-id']; } else { echo "null"; } ?>;	

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