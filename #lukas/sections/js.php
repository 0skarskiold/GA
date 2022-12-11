<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        
        $("#btn").click(function() {
            $("#test").load("/data.txt");
        });

        $("#btn_r").click(function() {
            $('.item_list').animate({left: "+=550px"});
        });
        $("#btn_l").click(function() {
            $('.item_list').animate({left: "-=550px"});
        });

        $("#test").load("/data.txt");

    $(document).on('click', '.follow', function() {
        var toid = $(this).data("userid");	
        $("#test").text(toid);
        $.ajax({
            url:'/includes/account/follow.inc.php',
            method:"POST",
            data:{toid:toid},
            // dataType:"json",
            success:$("#test").text(6)
        });
    });
</script>