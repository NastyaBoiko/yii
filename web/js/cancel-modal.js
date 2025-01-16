$(() => {
    $('#admin-order-pjax').on('click', '.btn-cancel-modal', function(e) {
        e.preventDefault();
        $('#form-cancel-modal').attr('action', $(this).attr('href'));
        $('#order-comment_admin').val('');
        $('#cancel-modal').modal('show');
    })

    $('#cancel-modal').on('click', '.btn-modal-close', function(e) {
        e.preventDefault();
        $('#cancel-modal').modal('hide');
    })

    $('#form-cancel-pjax').on('pjax:end', () => {
        $('#cancel-modal').modal('hide');
        $.pjax.reload('#admin-order-pjax');
    })
})