<script>
    $(document).ready(function () {

        if ($('#galleryjs').length > 0) {

            /** Для загрузки галереи */
            var buttonMulti = $('#multi'), file;

            // var _token = $('input #_token').val();
            var _token = $('meta[name="csrf-token"]').attr('content');
            // alert(_token);
            var form_data2 = new FormData();

            form_data2.append("_token", _token);

            if (buttonMulti) {
                // alert(_token);
                new AjaxUpload(buttonMulti, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    action: buttonMulti.data('url') + "?upload=1",
                    data: {name: buttonMulti.data('name'), _token: _token},
                    name: buttonMulti.data('name'),
                    responseType: 'json',
                    onSubmit: function (file, ext) {
                        if (!(ext && /^(jpg|png|jpeg|gif)$/i.test(ext))) {
                            alert("Разрешены только картинки!");
                            return false;
                        }
                        buttonMulti.closest('.file-upload').find('.overlay').css({'display': 'block'});
                    },

                    onComplete: function (file, response) {
                        // console.log(response);
                        // console.log(response);
                        // alert(file);
                        setTimeout(function () {
                            buttonMulti.closest('.file-upload').find('.overlay').css({'display': 'none'});
                            // alert(5555555555);

                            // response = JSON.parse(JSON.stringify(response));
                            // response = JSON.parse(response);

                            // alert(response);

                            $('.'+buttonMulti.data('name')).append('<img src="{{ asset('/uploads/gallery/') }}/'+ response.file+'" style="max-height: 150px;">');
                        }, 100);

                    }
                });
            }

            /** v Для удаления картинок в Редактировании товара галерея v */

            $('.del-items').on('click', function () {
                var res = confirm('Подтвердите удаление');
                if (!res) {
                    return false;
                }
                var $this = $(this);
                id = $this.data('id');
                src = $this.data('src');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ url('/admin/products/delete-gallery') }}',
                    data: {id: id, src: src, _token: _token},
                    type: 'POST',
                    beforeSend: function () {
                        $this.closest('.file-upload').find('.overlay').css({'display': 'block'});
                    },
                    success: function (res) {
                        setTimeout(function () {
                            $this.closest('.file-upload').find('.overlay').css({'display': 'none'});
                            if (res == 1) {
                                $this.fadeOut();
                            }
                        }, 1000);
                    }
                });
            });

            /** ^ Для удаления картинок в Редактировании товара галерея ^ */

        }
    });

</script>



