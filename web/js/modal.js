$(() => {
    $('#order-pjax, #block-btn').on('click', '.btn-confirm', function(e) {
        e.preventDefault();
        $('#confirm-modal')
            .find('.btn-delete')
            .attr('href', $(this).attr('href'))
        $('#confirm-modal').modal('show')        
    })
    
    $('#confirm-modal').on('click', '.btn-cancel', function(e) {
        e.preventDefault();
        $('#confirm-modal').modal('hide')
    })
})