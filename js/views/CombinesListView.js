var CombinesListView = Backbone.View.extend({


    el: "#listing",
    className: "co-listing",
    
    initialize: function(){
        _.bindAll(this, "render");

        this.collection.on("reset", this.render);
        this.render();
    },

    render: function(){
        var self = this;
        this.collection.each(function(m){
            $(self.el).append(_.template($("#combine-list-item").html())(m.attributes));
        });
        
    }

});