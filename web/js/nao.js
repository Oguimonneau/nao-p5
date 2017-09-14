// Let popover work with bootstrap in Admin views
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({
        trigger: 'hover',
    })
});