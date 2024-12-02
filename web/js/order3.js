$(() => {
    $('#form-order-pjax').on('change', '#order3-check', () =>
        $.pjax.reload('#form-order-pjax',
            {
                method: "POST",
                data: $('#form-order').serialize(),
                push: false,
                replace: false,
                timeout: 5000,
            }
        )
    )

    $('#form-order-pjax').on('pjax:end', () => 
        $('#form-order').submit()
    )
})