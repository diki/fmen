var CombineElementEditorView = Backbone.View.extend({

    el: "#newElementInputsContainer",

    events: {
        "click .new-element-button": "addMainElement"
    },

    initialize: function(){
        _.bindAll(this, "render", "addMainElement");

        //this.render();
    },

    render: function(options){

        console.log(options);

        this.mainElement = options.mainElement;

        $(this.el).html(_.template($("#newElementCreator").html())({
            mainElement: options.mainElement
        }));

        //image uploader plugin
        $(".img-upload-wrapper", this.el).imageUploader({
            success: function(){
                //
                //
                console.log("scc", this, this.id);
                var srcText = this.id;
                //window.combineImageId = srcText.split("/")[1].split(".")[0];
                window.currentElementImageId = srcText.split("/")[1].split(".")[0];
            }
        });

        $(this.el).undelegate();
        this.delegateEvents();
    },

    addMainElement: function(){
        var el = this.el;

        var element = new CombineElement();
        element.set("imgId", window.currentElementImageId);
        element.set("note", $(".newElementNote", el).val());
        element.set("name", $(".newElementName", el).val());
        element.set("price", parseFloat($(".newElementPrice", el).val()));
        element.set("link", $(".newElementLink", el).val());
        
        element.set("tags", $(".newElementTags", el).val());
        element.set("combineId", window.newCombineID);

        if(this.mainElement){
            element.set("keyElement", 1);

            //recreate group id
            var groupId = randomString(8);
            window.currentGroupId = groupId;

            //set active
            window.activeCombineElement = element;
        } else {
            element.set("keyElement", 0);
        }
        element.set("groupId", window.currentGroupId);

        element.save({},    {
            success: function(){
                window.combine.get("elements").add(element);
                console.log("element saved", element);
            }
        });        
    }


});