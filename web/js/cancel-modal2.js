$(() => {
    $('#admin-order-pjax, #order-view_block-btn').on('click', '.btn-cancel-modal', function(e) {
        e.preventDefault();
        $('#form-cancel-modal2').attr('action', $(this).attr('href'));
        $('#form-cancel-modal2').find('#order-comment_admin').val('');
        $('#cancel-modal2').modal('show');
    })

    $('#cancel-modal2').on('click', '.btn-modal-close', function(e) {
        e.preventDefault();
        $('#cancel-modal2').modal('hide');
    })

    $('#form-cancel-pjax2').on('pjax:end', () => {
        $('#cancel-modal2').modal('hide');

        if ($('#admin-order-pjax').length) {
            $.pjax.reload('#admin-order-pjax');
        }

        if ($('#order-view-pjax').length) {
            $.pjax.reload('#order-view-pjax');
        }
    })

})