$(() => {
    $('#favourite-pjax').on('click', '.btn-favourite', function(e) {
        e.preventDefault();
        const btn = $(this);
        $.ajax({
            url: btn.attr('href'),
            success(data) {
                if (data) {
                    $.pjax.reload("#favourite-pjax", {
                        push: false,
                        replace: false,
                        timeout: 5000,
                    });
                } 
            }
        })
    })
})