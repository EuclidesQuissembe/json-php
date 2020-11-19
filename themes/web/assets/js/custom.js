$(function () {
    'use strict'

    /**
     * Toasts
     */
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000
    });

    $('form:not(.ajax-unload)').on('submit', function (e) {
        e.preventDefault()

        let $form = $(this)

        $('.create').attr('disabled', '')

        $.ajax({
            type: 'POST',
            url: $form.attr('action'),
            data: $form.serializeArray(),
            dataType: 'json',
            beforeSend: function () {

            },
            success: function (response) {
                if (response.message) {
                    const {icon, title} = response.message

                    Toast.fire({icon, title})
                }

                if (response.redirect) {
                    document.location.href = response.redirect
                }

                resetForm()
            },
            error: function (err) {
                alert('Falha ao cadastrar')
                console.log(err)
            }
        })
    })
})

function resetForm() {
    $('form').each(function () {
        this.reset()
        $('.create').removeAttr('disabled')
    })
}