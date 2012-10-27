var CombineEditorView = Backbone.View.extend({

    el: "#combineEditor",

    events: {
        "change #imgUpload": "uploadImage"
    },
    initialize: function(){
        
        _.bindAll(this, "render", "uploadImage");

        this.render();
    },

    render: function(){

        this.$el.html(_.template($("#combineEditorViewTemplate").html())(this.model.attributes));

        console.log(this.$el.find("#imgUpload"));
        SI.Files.stylize(this.$el.find("#imgUpload")[0]);
        // _.each($("#imgUpload"), function (ell, idx) {
        //     SI.Files.stylize(ell);
        // });
    },

    uploadImage: function(e){
        var self = this;
         $("#combineImageForm", this.el).ajaxSubmit(function(resp){

            var srcText =JSON.parse(resp).id;
            //window.combineImageAddress = srcText
            window.combineImageId = srcText.split("/")[1];
            
            $("#combineImage", self.el).attr("src", "/ginkatego/"+srcText);

            $("#combineImageForm label.cabinet", self.el).width(100);
            $("#combineImageForm label.cabinet", self.el).height(20);

            $("#combineImage", self.el).fadeIn();
            
         });
    }

});