$(function () {
    'use strict'

    $('form:not(.ajax-unload)').on('submit', function (e) {
        e.preventDefault()

        let $form = $(this)

        $.ajax({
            type: 'POST',
            url: $form.attr('action'),
            data: $form.serializeArray(),
            dataType: 'json',
            beforeSend: function () {

            },
            success: function (response) {
                if (response.message) {
                    alert(response.message.title)
                }

                if (response.redirect) {
                    document.location.href = response.redirect
                }
            },
            error: function (err) {
                alert('Falha ao cadastrar')
                console.log(err)
            }
        })
    })

})