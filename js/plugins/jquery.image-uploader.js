/**
 * image uplaoader plugin
 *
 * opens an input box by also enabling preview
 * @param  {[type]} $ [description]
 * @return {[type]}   [description]
 */
(function( $ ) {
  $.fn.imageUploader = function(options) {
  
    var self = this;
    var fileInput = $("input.file", this);

    fileInput.change(function(){
        console.log("changed");
        $("form", self).ajaxSubmit(function(resp){
            var srcText =JSON.parse(resp).id;

            $("img.img-preview", self).attr("src", "/ginkatego/"+srcText);
            $("img.img-preview", self).fadeIn();
            $("form", self).fadeOut(function(){
                $("img.img-preview", self).fadeIn();
            });

            options.success.call(JSON.parse(resp));
        });
    });
  };
})( jQuery );