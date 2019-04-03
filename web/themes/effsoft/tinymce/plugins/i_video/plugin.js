tinymce.PluginManager.add('i_video', function(editor, url) {

    function selectLocalImages() {

        if(!editor.settings.images_upload_url){
            message('danger','登录后才能上传图片！');
            return;
        }

        var id =  ID(); //ID(); //tinymce.DOM.uniqueId();
        var loading = '<span id="'+ id +'" style="display:inline-block;">'+
            '<div class="progress fixed-top">'+
            '<div class="progress-bar bg-info" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>'+
            '</div>'+
            '<i class="fas fa-circle-notch fa-spin"></i>&nbsp;<span class="percent">0%</span>'+
            '</span>';
        var form = $('<form id="file_upload" enctype="multipart/form-data" action="'+editor.settings.video_upload_url+'" type="post"><input accept="video/*" multiple="multiple" type="file" name="file" /></form>');
        form.fileupload({
            dataType:'json',
            // maxChunkSize: 1*1024*1024, // 1 MB
            maxFileSize: 20*1024*1024,
            formData: form.serializeArray(),
            submit: function(e,data){
                var selection_content = editor.selection.getContent();
                if(selection_content.length > 0){
                    editor.selection.setContent(selection_content + loading);
                }else{
                    editor.selection.setContent(loading);
                }
            },
            send: function(e,data){

            },
            done: function(e,data){
                var response = data.result;
                if(response.status != 0){
                    message('danger',response.message);
                    return;
                }

                var compress_48 = response.data.compress_48;
                compress_48 = 'https://' + response.data.server + '/' + compress_48;

                $('#' + id).replaceWith($('<p><video controls controlsList="nodownload" controls>' +
                    '  <source src="'+compress_48+'" type="video/mp4">' +
                    'Your browser does not support the video element.' +
                    '</video></p><br />'));
                editor.focus();
                editor.selection.select(editor.getBody(), true);
                editor.selection.collapse(false);

            },
            fail: function(e,data){
                $('#' + id).find('span[class="percent"]').addClass('text-danger').text('上传失败，请稍后重试！');
                $('#' + id).fadeOut(1000);
            },
            progress: function(e,data){
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#' + id).find('.progress-bar').css('width',progress + '%').attr('aria-valuenow',progress);
                $('#' + id).find('span[class="percent"]').html(progress + '%');
            },
        });
        form.find('input[type="file"]').click();
    }

    editor.addButton('i_video', {
        title: '上传视频',
        icon: 'fa fa fa-file-video',
        onclick: selectLocalImages
    });

});