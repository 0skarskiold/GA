<script>

$(document).ready(function() {

    $('select[name="sort-by"]').change(function() {
        var option_popularity = $('select[name="sort-by"] option[value="popularity"]');
        var option_rating = $('select[name="sort-by"] option[value="rating"]');
        var option_name = $('select[name="sort-by"] option[value="name"]');

        $('select[name="sort-by-rating"], select[name="sort-by-popularity"]').parents('.filter_option').remove();

        if(option_popularity.is(':selected')) {
            option_popularity.parents('.filter_option').after('<div class="filter_option extra"><select name="sort-by-popularity"><option value="week">This week</option><option value="month">This month</option><option value="all-time">All time</option></select></div>');
        } else if(option_rating.is(':selected')) {
            option_rating.parents('.filter_option').after('<div class="filter_option extra"><select name="sort-by-rating"><option value="highest-first">Highest first</option><option value="lowest-first">Lowest first</option></select></div>');
        } 
    });

});

</script>