tinymce.PluginManager.add('i_image', function(editor, url) {

    function selectLocalImages() {
        // var dom = editor.dom;
        // var input_f = $('<input type="file" name="file" accept="image/*" multiple="multiple">');
        // input_f.change(function () {
        //   var file_size = this.files[0].size;
        //   if(file_size > 1024 * 1024 * 5){
        //     message('danger','每张图片限制大小为5MB！');
        //     input_f.val('');
        //     return;
        //   }

        //   var form_data = new FormData();
        //   form_data.append('csrf_token',Cookies.get('csrf_cookie'));
        //   form_data.append('file',input_f[0].files[0],'file');
        //   var url = editor.settings.images_upload_url;
        //   if(!url){
        //     message('danger','该功能登录后才能使用！');
        //     return;
        //   }

        //   var xhr = new XMLHttpRequest();
        //   xhr.open('POST', url, true);
        //   xhr.responseType = 'json';
        //   xhr.onload = function () {
        //     if (xhr.status === 200) {
        //       console.log(this.response.status);
        //     } else {
        //       alert('An error occurred!');
        //     }
        //   };
        //   xhr.send(form_data);
        // });
// var form = $('<form enctype="multipart/form-data" action="" type="post"><input type="hidden" name="csrf_token" value="'+Cookies.get('csrf_cookie')+'" /></form>');
        //   input_f.fileupload({
        //         maxChunkSize: 10000000, // 10 MB
        //         url: editor.settings.images_upload_url,
        //         dataType: 'json',
        //         formData: [{'csrf_token':Cookies.get('csrf_cookie')}],
        //         done: function (e, data) {
        //             alert('done');
        //         },
        //         fail: function (e, data) {
        //             // $.ajax({
        //             //     url: 'server/php/',
        //             //     dataType: 'json',
        //             //     data: {file: data.files[0].name}
        //             //     type: 'DELETE'
        //             // });
        //             alert('fail');
        //         }
        //     });
        //   input_f.bind('fileuploadsubmit', function (e, data) {
        //     data.formData = {'csrf_token':Cookies.get('csrf_cookie')};
        // });

        //   input_f.click();

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
        // var form = $('<form id="file_upload" enctype="multipart/form-data" action="'+editor.settings.images_upload_url+'" type="post"><input accept="image/*" multiple="multiple" type="file" name="file" /><input type="hidden" name="test" value="test" /><input type="hidden" name="csrf_token" value="'+Cookies.get('csrf_cookie')+'" /></form>');
        var form = $('<form id="file_upload" enctype="multipart/form-data" action="'+editor.settings.images_upload_url+'" type="post"><input accept="image/*" multiple="multiple" type="file" name="file" /></form>');
        form.fileupload({
            dataType:'json',
            // maxChunkSize: 1*1024*1024, // 1 MB
            formData: form.serializeArray(),
            submit: function(e,data){
// editor.selection.setContent('<p id="'+id+'">submit</p>'+ '<br />');
// editor.execCommand('mceInsertContent', false, '<p id="'+id+'">submit</p>');
                var selection_content = editor.selection.getContent();
                if(selection_content.length > 0){
                    editor.selection.setContent(selection_content + loading);
                }else{
                    editor.selection.setContent(loading);
                }
            },
            send: function(e,data){
// editor.selection.setContent('send'+ '<br />');

            },
            done: function(e,data){
// editor.selection.setContent('done'+ '<br />');
                // $('#'+id).remove();
                //设置图片
                //$('#' + id).replaceWith($('<span id="'+id+'">上传成功！</span>'));

                var response = data.result;
                var file = data.result.file[0];
                // var thumb_image_url = '';
                // var width = 0;
                // var height = 0;
                // if(response.data.thumb_800 != ''){
                //     thumb_image_url = response.data.thumb_800;
                //     width = response.data.thumb_800_width;
                //     height = response.data.thumb_800_height;
                // }
                // if(width ==0 || height == 0){
                //     thumb_image_url = response.data.full_path;
                //     width = response.data.image_width;
                //     height = response.data.image_height;
                // }
                // var image_url = response.data.full_path;
                // thumb_image_url = 'https://' + response.data.server + '/' + thumb_image_url;
                // image_url = 'https://' + response.data.server + '/' + image_url;

                $('#' + id).replaceWith($('<p><a id="'+id+'" data-lightbox="lightbox" href="https://'+file.server+'/'+file.url+'"><img src="https://'+file.server+'/'+file.mediumUrl+'" /></a></p><br />'));
                // var newNode = editor.dom.select('span#' + id);
                // editor.selection.select(newNode[0]);
                editor.focus();
                editor.selection.select(editor.getBody(), true);
                editor.selection.collapse(false);

            },
            fail: function(e,data){
// editor.selection.setContent('fail'+ '<br />');
                //上传失败
                $('#' + id).find('span[class="percent"]').addClass('text-danger').text('上传失败，请稍后重试！');
                $('#' + id).fadeOut(1000);
            },
            progress: function(e,data){
                var progress = parseInt(data.loaded / data.total * 100, 10);
// editor.selection.setContent(progress + '<br />');
                //上传进度
                $('#' + id).find('.progress-bar').css('width',progress + '%').attr('aria-valuenow',progress);
                $('#' + id).find('span[class="percent"]').html(progress + '%');
            },
        });
        form.find('input[type="file"]').click();
    }

    editor.addButton('i_image', {
        title: '上传图片',
        icon: 'fa fas fa-file-image',
        onclick: selectLocalImages
    });

});