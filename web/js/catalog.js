$(() => {
    $('#catalog-pjax').on('click', '.btn-favourite', function(e) {
        e.preventDefault();
        const btn = $(this);
        $.ajax({
            url: btn.attr('href'),
            success(data) {
                if (data) {
                    btn.html(data.status
                        ? '❤'
                        : '🤍'
                    );
                } 
            }
        })
    })

    $('#catalog-pjax').on('click', '.btn-like', function(e) {
        e.preventDefault();
        const btn = $(this);
        $.ajax({
            url: btn.attr('href'),
            success(data) {
                if (data) {
                    btn.children(".like-count").html(data.count);
                } 
            }
        })
    })

    $('#catalog-pjax').on('click', '.btn-dislike', function(e) {
        e.preventDefault();
        const btn = $(this);
        $.ajax({
            url: btn.attr('href'),
            success(data) {
                if (data) {
                    btn.children(".dislike-count").html(data.count);
                } 
            }
        })
    })
})