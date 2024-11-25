$(() => {
    $('#form-order-pjax').on('change', '#order2-check', function () {
        $('#order2-outpost_id option:first').prop('selected', true);
        if ($(this).prop('checked')) {
            // comment - check
            $('#order2-comment').prop('disabled', false);
            $('#order2-outpost_id').prop('disabled', true);
            $('#order2-outpost_id').removeClass('is-invalid');
            $('#order2-outpost_id').removeClass('is-valid');
            $('#order2-comment').addClass('is-invalid');

            // $('#form-order').yiiActiveForm('remove', 'order-outpost_id' );
            // $('#form-order').yiiActiveForm("add", {"id":"order-comment","name":"comment","container":".field-order-comment","input":"#order2-comment","error":".invalid-feedback","validate":function (attribute, value, messages, deferred, $form) {yii.validation.string(value, messages, {"message":"Значение «Комментарий к заказу» должно быть строкой.","max":255,"tooLong":"Значение «Комментарий к заказу» должно содержать максимум 255 символа.","skipOnEmpty":1});}});
        } else {
            // outpost - uncheck
            $('#order2-comment').val('');
            $('#order2-comment').prop('disabled', true);
            $('#order2-outpost_id').prop('disabled', false);
            $('#order2-comment').removeClass('is-invalid');
            $('#order2-comment').removeClass('is-valid');
            $('#order2-outpost_id').addClass('is-invalid');

            // $('#form-order').yiiActiveForm('remove', 'order-comment');
            // $('#form-order').yiiActiveForm("add", {"id":"order-outpost_id","name":"outpost_id","container":".field-order-outpost_id","input":"#order2-outpost_id","error":".invalid-feedback","validate":function (attribute, value, messages, deferred, $form) {yii.validation.number(value, messages, {"pattern":/^[+-]?\d+$/,"message":"Значение «Пункт выдачи» должно быть целым числом.","skipOnEmpty":1});yii.validation.required(value, messages, {"message":"Необходимо заполнить «Пункт выдачи»."});}});

        }
    })
})