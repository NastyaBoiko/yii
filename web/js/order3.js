$(() => {
    $('#form-order-pjax').on('change', '#order3-check', () =>
        $.pjax.reload('#form-order-pjax',
            {
                method: "POST",
                data: $('#form-order').serialize()
            }
        )
    )

    $('#form-order-pjax').on('pjax:end', () => 
        $('#form-order').submit()
    )
})