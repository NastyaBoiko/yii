const error_modal = (text) => {
    $('#text-error').html(text);
    $('#info-modal').modal('show');
}

const cartItemCount = () => $.pjax.reload('#cart-item-count', {
    url: $('#cart-item-count').data('url'),
    method: 'POST',
    replace: false,
    push: false,
    timeout: 5000,
});

$(() => {

    $('#catalog-pjax').on('click', '.btn-cart-add', function(e) {
        e.preventDefault();
        const btn = $(this);

        $.ajax({
            url: btn.attr('href'),
            method: 'POST',
            success(data) {
                if (data) {
                    if (data.status) {
                        $.pjax.reload('#catalog-pjax', {
                            push: false,
                            timeout: 5000,
                        })
                    } else {
                        error_modal(data.message);
                    }
                } 
            }
        })
    })

    $('#catalog-pjax').on('pjax:end', () => cartItemCount())

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

    $('#catalog-pjax').on('change', '#product2search-category_id', function() {
        $('#form-product-search').submit();
    })

    $('#catalog-pjax').on('input', '#product2search-title', function() {
        $('#product2search-title_search').val(1);
        $('#form-product-search').submit();
    })

    $('#catalog-pjax').on('pjax:end', function() {
        if ($('#product2search-title_search').val() == 1) {
            $('#product2search-title').focus()
            $('#product2search-title')[0]
                .setSelectionRange(
                    $('#product2search-title').val().length, 
                    $('#product2search-title').val().length
                )
            $('#product2search-title_search').val() = 0
        }
    })

})