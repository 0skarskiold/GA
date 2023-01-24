<script>

$(document).ready(function() {
    $('button[name="toggle_form_type"]').click(function() {
        if($('#login').is("[hidden]")) {
            $('#login').removeAttr('hidden');
            $('#signup').attr('hidden', true);
            $(this).text('Sign up');
        } else {
            $('#signup').removeAttr('hidden');
            $('#login').attr('hidden', true);
            $(this).text('Log in');
        }
    });
});

</script>