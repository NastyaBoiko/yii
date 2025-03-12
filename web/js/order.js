$(() => {
    $('#form-order-pjax').on('change', '#order-check', function () {
        $('#order-outpost_id option:first').prop('selected', true);
        if ($(this).prop('checked')) {
            // comment - check
            $('#order-comment').prop('disabled', false);
            $('#order-outpost_id').prop('disabled', true);
            $('#order-comment').parents('.comment-field').removeClass('d-none');
            // $('#order-outpost_id').prop('disabled', true);

            $('#order-outpost_id').removeClass('is-invalid');
            $('#order-outpost_id').removeClass('is-valid');
            $('#order-comment').addClass('is-invalid');

            $('#form-order').yiiActiveForm('remove', 'order-outpost_id' );
            $('#form-order').yiiActiveForm("add", {"id":"order-comment","name":"comment","container":".field-order-comment","input":"#order-comment","error":".invalid-feedback","validate":function (attribute, value, messages, deferred, $form) {yii.validation.string(value, messages, {"message":"Значение «Комментарий к заказу» должно быть строкой.","max":255,"tooLong":"Значение «Комментарий к заказу» должно содержать максимум 255 символа.","skipOnEmpty":1});}});
        } else {
            // outpost - uncheck
            $('#order-comment').parents('.comment-field').addClass('d-none');

            $('#order-comment').val('');
            $('#order-comment').prop('disabled', true);
            $('#order-outpost_id').prop('disabled', false);
            $('#order-comment').removeClass('is-invalid');
            $('#order-comment').removeClass('is-valid');
            $('#order-outpost_id').addClass('is-invalid');

            $('#form-order').yiiActiveForm('remove', 'order-comment');
            $('#form-order').yiiActiveForm("add", {"id":"order-outpost_id","name":"outpost_id","container":".field-order-outpost_id","input":"#order-outpost_id","error":".invalid-feedback","validate":function (attribute, value, messages, deferred, $form) {yii.validation.number(value, messages, {"pattern":/^[+-]?\d+$/,"message":"Значение «Пункт выдачи» должно быть целым числом.","skipOnEmpty":1});yii.validation.required(value, messages, {"message":"Необходимо заполнить «Пункт выдачи»."});}});

        }
    })
})