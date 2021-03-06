tinymce.PluginManager.add('i_image', function(editor, url) {

    var accept = 'image/*';

    function selectFile() {

        var uuid = get_uuid();

        var form = $('<form>').attr({
            'enctype': 'multipart/form-data',
            'action': editor.settings.image_upload_url,
            'type': 'post',
        }).append($('<input>').attr({
            'type': 'hidden',
            'name': 'uuid',
            'value': uuid,
        })).append($('<input>').attr({
            'type': 'hidden',
            'name': 'media_type',
            'value': 1,//MediaType::DOCUMENT_CONTENT_IMAGE
        })).append($('<input>').attr({
            'type': 'hidden',
            'name': '_csrf',
            'value': $('meta[name="csrf-token"]').attr("content"),
        })).append($('<input>').attr({
            'type': 'file',
            'name': 'file',
            'accept': accept,
            'multiple': 'multiple',
        }));

        form.fileupload({
            dataType:'json',
            maxChunkSize: 1*1024*1024, // 1 MB
            maxFileSize: 20*1024*1024,
            maxRetries: 5,
            retryTimeout: 5*1000,
            formData: form.serializeArray(),
            add: function (e, data) {
                console.log('add');
                console.log(get_tinymce_element_identity(uuid,data.files[0].name));

                var that = this;
                $.postJSON(editor.settings.chunk_url, {uuid: uuid, file_name: data.files[0].name}, function (result) {
                    var file = result.file;
                    data.uploadedBytes = file && file.size;
                    $.blueimp.fileupload.prototype.options.add.call(that, e, data);
                });
            },
            submit: function(e,data){
                console.log('submit');

                var selection_content = editor.selection.getContent();
                if(selection_content.length > 0){
                    editor.selection.setContent(selection_content + get_tinymce_loading(get_tinymce_element_identity(uuid,data.files[0].name)));
                }else{
                    editor.selection.setContent(get_tinymce_loading(get_tinymce_element_identity(uuid,data.files[0].name)));
                }
            },
            send: function(e,data){
                console.log('send');
            },
            done: function(e,data){
                console.log('done');

                var $body = $(editor.getBody());

                var response = data.result;
                var file = data.result.file[0];console.log(file);
                if(file.error != undefined){
                    $body.find('#' + get_tinymce_element_identity(uuid,data.files[0].name))
                        .replaceWith($('<div style="color:#ff5e3a;">'+file.error+'</div>').fadeOut(5000,function(){
                            $(this).remove();
                        }));
                    return;
                }
                $body.find('#' + get_tinymce_element_identity(uuid,data.files[0].name))
                    .replaceWith($('<div id="'+get_tinymce_element_identity(uuid,data.files[0].name)+'"><img src="'+file.largeUrl+'" /></div>'));
                editor.focus();
                editor.selection.select(editor.getBody(), true);
                editor.selection.collapse(false);

            },
            fail: function(e,data){
                console.log('fail');
                var $body = $(editor.getBody());
                $body.find('#' + get_tinymce_element_identity(uuid,data.files[0].name))
                    .find('span[class="percent"]')
                    .addClass('text-danger')
                    .text('Error, please try again!');
                $body.find('#' + get_tinymce_element_identity(uuid,data.files[0].name)).fadeOut(1000);
            },

            progress: function(e,data){
                console.log('progress');
                var progress = parseInt(data.loaded / data.total * 100, 10);
                var $body = $(editor.getBody());
                $body.find('#' + get_tinymce_element_identity(uuid,data.files[0].name))
                    .find('.progress-bar')
                    .css('width',progress + '%')
                    .attr('aria-valuenow',progress);
                if(progress == 100){
                    $body.find('#' + get_tinymce_element_identity(uuid,data.files[0].name)).find('span[class="percent"]').html('Processing...');
                }else{
                    $body.find('#' + get_tinymce_element_identity(uuid,data.files[0].name)).find('span[class="percent"]').html(progress + '%');
                }
                console.log(progress);
            },
        });
        form.find('input[type="file"]').click();
    }

    editor.addButton('i_image', {
        title: 'Upload Image',
        icon: 'fa fa fa-file-image',
        onclick: selectFile
    });

});