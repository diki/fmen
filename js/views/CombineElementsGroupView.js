var CombineElementsGroupView = Backbone.View.extend({

    tagName: "li",

    className: "element-list-item",
    
    initialize: function(){

        //console.log("colll", this.collection);

        _.bindAll(this, "render", "addAlternative");

        this.collection = new CombineElementsCollection();
        this.collection.add(this.model, {silent: true});

        // console.log("coll", this.collection);
        this.collection.on("add", this.addAlternative);

        this.render();
    },

    render: function(){
        var t = _.template($("#combineElementsGroupView").html())(this.model.attributes);
        $(this.el).html(t);
    },

    addAlternative: function(m){
        //console.log("adding alternative", m.attributes);
        var alternativeView = '<li><img src="'+'uploaded-images/markers/'+m.get("imgId")+'.jpg"/></li>';

        $(".alt-elements", this.el).append(alternativeView);
    }

});