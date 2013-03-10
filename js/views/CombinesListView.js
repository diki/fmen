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
        this.collection.each(function(m, idx){
            $(self.el).append(new CombineListItemView({model: m}).el);
            if(idx==self.collection.length-1){
                var s = $(self.el).shapeshift({
                    enableDrag: false,
                    // minHeight: 200,
                    centerGrid: false
                });

                console.log(s);
                $(window).resize();
            }
        });


        
    }

});