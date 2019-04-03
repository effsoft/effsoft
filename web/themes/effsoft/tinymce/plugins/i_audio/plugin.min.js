tinymce.PluginManager.add('i_audio', function(editor, url) {

    function selectLocalImages() {

        if(!editor.settings.audio_upload_url){
            message('danger','登录后才能上传！');
            return;
        }

        var id =  ID(); //ID(); //tinymce.DOM.uniqueId();
        var loading = '<div id="'+ id +'"><span style="display:inline-block;width:10rem;">'+
            '<div class="progress fixed-top">'+
            '<div class="progress-bar bg-info" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>'+
            '</div>'+
            '<i class="fas fa-circle-notch fa-spin"></i>&nbsp;<span class="percent">0%</span>'+
            '</span></div>';
        var form = $('<form id="file_upload" enctype="multipart/form-data" action="'+editor.settings.audio_upload_url+'" type="post"><input type="hidden" name="uuid" value="'+id+'" /><input accept="audio/*" multiple="multiple" type="file" name="file" /></form>');
        form.fileupload({
            dataType:'json',
            maxChunkSize: 1*1024*1024, // 1 MB
            maxFileSize: 20*1024*1024,
            maxRetries: 5,
            retryTimeout: 5*1000,
            formData: form.serializeArray(),
            add: function (e, data) {
                console.log(id);
                console.log('add');
                var that = this;
                $.postJSON(editor.settings.upload_url, {uuid: id}, function (result) {
                    var file = result.file;
                    data.uploadedBytes = file && file.size;
                    $.blueimp.fileupload.prototype.options.add.call(that, e, data);
                });
            },
            submit: function(e,data){
                console.log('submit');
                var selection_content = editor.selection.getContent();
                if(selection_content.length > 0){
                    editor.selection.setContent(selection_content + loading);
                }else{
                    editor.selection.setContent(loading);
                }
            },
            send: function(e,data){
                console.log('send');
            },
            done: function(e,data){
                console.log('done');
                // $('#' + id).find('span[class="percent"]').html('正在压缩...');
                var $body = $(editor.getBody());

                var response = data.result;
                var file = data.result.file[0];
                if(file.error != undefined){
                    $body.find('#' + id).replaceWith($('<div style="color:#ff5e3a;">'+file.error+'</div>').fadeOut(5000,function(){
                        $(this).remove();
                    }));
                    return;
                }
                if(file.server == ''){
                    $body.find('#' + id).replaceWith($('<audio uuid="'+id+'" controls controlsList="nodownload" width="100%">' +
                        '  <source src="/' + 'audio/index/' + id +'" type="audio/mp3">' +
                        'Your browser does not support the audio element.' +
                        '</audio><br />'));
                }else{
                    $body.find('#' + id).replaceWith($('<audio uuid="'+id+'" controls controlsList="nodownload" width="100%">' +
                        '  <source src="https://' + file.server + '/' + 'audio/index/' + id +'" type="audio/mp3">' +
                        'Your browser does not support the audio element.' +
                        '</audio><br />'));
                }

                editor.focus();
                editor.selection.select(editor.getBody(), true);
                editor.selection.collapse(false);

            },
            fail: function(e,data){
                console.log('fail');
                $('#' + id).find('span[class="percent"]').addClass('text-danger').text('上传失败，请稍后重试！');
                $('#' + id).fadeOut(1000);
            },

            progress: function(e,data){
                console.log('progress');
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#' + id).find('.progress-bar').css('width',progress + '%').attr('aria-valuenow',progress);
                $('#' + id).find('span[class="percent"]').html(progress + '%');
                console.log(progress);
            },
        }).on('fileuploadchunkbeforesend', function (e, data) {
            console.log('fileuploadchunkbeforesend');
        })
            .on('fileuploadchunksend', function (e, data) {
                console.log('fileuploadchunksend');
            })
            .on('fileuploadchunkdone', function (e, data) {
                console.log('fileuploadchunkdone');
            })
            .on('fileuploadchunkfail', function (e, data) {
                console.log('fileuploadchunkfail');
            })
            .on('fileuploadchunkalways', function (e, data) {
                console.log('fileuploadchunkalways');
            });
        form.find('input[type="file"]').click();
    }

    editor.addButton('i_audio', {
        title: '上传音频',
        icon: 'fa fa fa-file-audio',
        onclick: selectLocalImages
    });

});