jQuery(function($){
	
    class Mj_admin_core {

        constructor(SS_modal){
            this.__this;
            this.SS_modal = SS_modal;

            this.slideshow_Sortable();
            this.eventHandlers();
        }

        eventHandlers(){
            $(document.body).on( 'click', 'a.mj_upload_slide', this.upload_slideImage.bind(this) );
            $(document.body).on( 'click', 'a.mj_slide_remove', this.remove_Slideshow.bind(this) );
        }

        upload_slideImage(e) {
            e.preventDefault();
            this.__this	= $(e.currentTarget);
            var	_this = this,
                mediaUploader = wp.media({
                    title: 'Insert images',
                    library : {
                        type : 'image'
                    },
                    button: {
                        text: 'Use these images'
                    },
                    multiple: true
                }).on('select', function() {
                    var attachments = mediaUploader.state().get('selection').map(function(a) {
                        a.toJSON();
                        return a;
                    }),
                    i;

                    for ( i = 0; i < attachments.length; ++i) {
                        console.log( attachments[i].attributes.sizes );

                        var img_URL = typeof attachments[i].attributes.sizes.mj_slideshow_thumbnail == "undefined" ? attachments[i].attributes.sizes.medium.url : attachments[i].attributes.sizes.mj_slideshow_thumbnail.url;

                        _this.SS_modal.append(
                            '<li><img width="250" height="130" src="' + img_URL + '"/><div class="mj_slide_actions"><a href="#" class="mj_slide_move"><span class="tooltip">Drag & Sort</span><i class="dashicons dashicons-move"></i></a><a href="#" class="mj_slide_remove"><span class="tooltip">Delete</span> <i class="dashicons dashicons-trash"></i></a></div><input type="hidden" name="mj_slideshow_image_ids[]" value="' + attachments[i].id + '" /></li>'
                        );
                    }  
                }).open();
        }

        slideshow_Sortable() {
            this.SS_modal.sortable({
                items:  'li',
                handle: '.mj_slide_move',
                cursor: '-webkit-grabbing',
                stop:function(event,ui){
                    ui.item.removeAttr('style');
                }
            });
        }

        remove_Slideshow(e) {
            e.preventDefault();
            this.__this	= $(e.currentTarget);
            var	_this = this;
            this.__this.parents('li').remove();
        }
    
    }
    new Mj_admin_core( $('.mj_ss_slides') );
});