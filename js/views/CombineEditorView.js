var CombineEditorView = Backbone.View.extend({

    el: "#combineEditor",

    events: {
        "change #imgUpload": "uploadImage",
        "click #newCombineButton": "createCombine",
        "click .combine-image-wrapper": "addCombineElement"
    },
    initialize: function(){
        
        _.bindAll(this, "render", "uploadImage", "createCombine", "addCombineElement");

        this.render();
    },

    render: function(){

        this.$el.html(_.template($("#combineEditorViewTemplate").html())(this.model.attributes));

        SI.Files.stylize(this.$el.find("#imgUpload")[0]);
        _.each($("#imgUpload"), function (ell, idx) {
            SI.Files.stylize(ell);
        });
        // 
        // 
        // console.log("ajaxed form");
        // $("#combineImageForm", this.el).ajaxForm({
        //     success: function(data){
        //         console.log("may may be");
        //     }
        // });
    },

    uploadImage: function(e){

        var self = this;
         $("#combineImageForm", this.el).ajaxSubmit(function(resp){

            console.log("dear lord");
            var srcText =JSON.parse(resp).id;
            //window.combineImageAddress = srcText
            window.combineImageId = srcText;
            
            $("#combineImage", self.el).attr("src", "http://s3.amazonaws.com/ginkatego/uploads/"+srcText);

            $("#combineImageForm label.cabinet", self.el).width(100);
            $("#combineImageForm label.cabinet", self.el).height(20);

            $("#combineImageForm label.cabinet", self.el).css({
                "position": "absolute",
                "top": 0,
                "left": 0
            });

            $(".combine-image-wrapper", self.el).fadeIn();
            
         });
    },

    createCombine: function(){

        var self = this;

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/server/combines/add",
            data: {
                imgID: combineImageId,
                name: $("#combineName", self.el).val(),
                notes: $("#combineNotes", self.el).val(),
                sex: $("#combineSex > option:selected", self.el).val(),
                category: $("#combineCategory > option:selected", self.el).val()
            },

            success: function(resp){
                console.log("new combine created with id ", resp.id);
                window.newCombineID = resp.id;

                console.log("creating new combine model");
                
                window.combine = new Combine();
                combine.set("imgID", combineImageId);
                combine.set("imgSrc", combineImageId);
                combine.set("notes", $("#combineNotes").val());
                combine.set("sex", $("#combineSex > option:selected").val());
                combine.set("category", $("#combineCategory > option:selected").val());
                combine.id = resp.id;

                /*
                    render info message
                 */
                $("#infoMessage>span", self.el).html("Kombin başarıyla yaratıldı");
                $("#infoMessage", self.el).show();
                $("#title").show();
                /*
                    clear form on right side
                 */
                $("#combineOperations").html("");
            }
        });        
    },

    addCombineElement: function(e){
        /*
            calculate mouse position relative to target
            if image laoded ofcourse
         */
        
        if(window.combineImageId!==undefined){
            var parentOffset = $(e.target).offset(); 

            var relX = e.pageX - parentOffset.left;
            var relY = e.pageY - parentOffset.top;
        }
    }

});