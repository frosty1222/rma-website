jQuery(document).ready(function($) {
    // Hover over the 'li .item-post' element
    $('li .item-post').hover(function() {
        // Add 'big' class to the current element (this) and remove 'small' class
        $(this).addClass('big').removeClass('small');

        // Add 'small' class and remove 'big' class for the sibling elements
        $(this).siblings('.item-post').addClass('small').removeClass('big');

        // Get the 'data-index' attribute of the current element
        var dataIndex = $(this).attr('data-index');

        // Check sibling elements, if they have class '.item-sub-post-data_index'
        // add 'show' class to them, otherwise remove 'show' class
        // $(this).siblings('.item-sub-post').each(function() {
        //     if ($(this).hasClass('item-sub-post-' + dataIndex)) {
        //         $(this).addClass('show');
        //     } else {
        //         $(this).removeClass('show');
        //     }
        // });
    }, function() {
        // On hover out (mouseleave), remove all 'big', 'small', and 'show' classes
        $('li .item-post').removeClass('big small');
        // $('.item-sub-post').removeClass('show');
    });
});