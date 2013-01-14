var CombineElementEditableView = Backbone.View.extend({

    tagName: "li",

    events: {
        "click a.remove-product": "removeProduct"
    },

    initialize: function(){
        _.bindAll(this, "render", "removeProduct");
        this.render();
    },

    render: function(){

        $("#action-info").hide();
        $("#infoMessage").hide();

        $(this.el).html(_.template($("#combineElementEditableView").html())(this.model.attributes));

        /*
            get image el from modal box this way image will not be loaded again
         */
        var imgEl = $("#"+this.model.id + " .catalog-image-wrapper")
        .addClass("listed");
        
        $(".product-item", this.el).prepend(imgEl);
    },

    removeProduct: function(){
        window.combineEditorView.trigger("removeElement", this.model.id);
    }

});