(function(w){
    w.addEventListener('load', function(){
        const   btn_left = document.getElementById('arrow_left'),
                btn_right = document.getElementById('arrow_right'),
                content = document.getElementById('list');
        const content_scroll_width = content.scrollWidth;
        let content_scoll_left = content.scrollLeft;
        btn_right.addEventListener('click', () => {
            content_scoll_left += 1500;
            if (content_scoll_left >= content_scroll_width) { content_scoll_left = content_scroll_width; }
            content.scrollLeft = content_scoll_left;
        });
        btn_left.addEventListener('click', () => {
            content_scoll_left -= 1500;
            if (content_scoll_left <= 0) {
                content_scoll_left = 0;
            }
            content.scrollLeft = content_scoll_left;
        });
    });
})(window);