<div>
    <textarea id="<?= $name ?>" name="<?= $name ?>"
              class="editor p-2 bg-white text-muted border position-relative" style="">
    </textarea>
</div>

<script type="text/javascript">
    function init_tinymce() {
        tinymce.remove();
        $('.mce-tinymce').remove();
        tinymce.init({
            selector: '.editor',
            <?php if(!\Yii::$app->user->isGuest): ?>
            chunk_url: '<?=\yii\helpers\Url::to(['/media/upload/chunk']);?>',
            image_upload_url: '<?=\yii\helpers\Url::to(['/media/upload/image']);?>',
            audio_upload_url: '<?=\yii\helpers\Url::to(['/media/upload/audio']);?>',
            video_upload_url: '<?=\yii\helpers\Url::to(['/media/upload/video']);?>',
            <?php endif; ?>
            relative_urls: false,
            remove_script_host: false,
            convert_urls: true,
            automatic_uploads: true,
            menubar: false,
            plugins: [
                "autolink link table",
                "paste textcolor",
                "i_image i_audio i_video"
            ],
            toolbar: "table bold italic forecolor backcolor alignleft aligncenter alignright link i_image i_audio i_video",
            codesample_languages: [
                {text: 'HTML/XML', value: 'markup'},
                {text: 'JavaScript', value: 'javascript'},
                {text: 'CSS', value: 'css'},
                {text: 'PHP', value: 'php'},
                {text: 'Ruby', value: 'ruby'},
                {text: 'Python', value: 'python'},
                {text: 'Java', value: 'java'},
                {text: 'C', value: 'c'},
                {text: 'C#', value: 'csharp'},
                {text: 'C++', value: 'cpp'}
            ],
            emoji_add_space: false,
            emoji_show_groups: false,
            emoji_show_subgroups: false,
            emoji_show_tab_icons: false,
            image_advtab: true,
            valid_elements: "*[*]",
            invalid_elements: "script",
            powerpaste_word_import: 'clean',
            powerpaste_html_import: 'clean',
            paste_auto_cleanup_on_paste: true,
            paste_remove_styles: true,
            paste_remove_styles_if_webkit: true,
            paste_strip_class_attributes: true,
            paste_as_text: true,
            paste_data_images: true,

            forced_root_block: 'div',
            force_br_newlines: true,
            force_p_newlines: false,

            content_css: [
                '/themes/effsoft/fontawesome/css/all.min.css',
                '/themes/effsoft/css/custom.css?=<?=time()?>',
            ],
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            },
            language: 'zh_CN',
            media_live_embeds: true,
            inline: false,
            height: 500,
        });
    }

    (function($){
        init_tinymce();
    })(jQuery);

</script>