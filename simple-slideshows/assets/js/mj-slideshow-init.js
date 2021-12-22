jQuery(function($){

    class Mj_slideshow_init {

        constructor(){
            this.__this;
            this.eventHandlers();
        }

        eventHandlers(){
            $(document.body).ready( this.intialize_SlideShow() );
        }

        intialize_SlideShow() {
            console.log( "intialize_SlideShow" );
            $( document.body ).find( "div.swiper" ).each(function(){
                var swiperDiv = $(this),
                    swiperID = swiperDiv.data( "id" ),
                    swiperAttr = swiperDiv.data( "attr" );

                new Swiper( "." + swiperID,
                    swiperAttr
                );
            });
        }
    }
    new Mj_slideshow_init();
});
