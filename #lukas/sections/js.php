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
            url:'/includes/account/follow.inc.php',
            method:"POST",
            data:{to_id:to_id, from_id:from_id, action:action},
            success: console.log(action)
        });
    });
</script>