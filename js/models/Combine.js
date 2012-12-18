var Combine = Backbone.Model.extend({

    defaults: {
        "imgSrc"            : "imgSrc",
        "thumbSrc"          : "thumbSSrc",
        "notes"             : undefined,
        "creationDate"      : "creation date",
        "name"              : undefined,
        "imgId"             : undefined,
        "sex"               : undefined,
        "category"          : undefined
    },

    initialize: function(){
        this.set("elements", new CombineElementsCollection());

        // this.get("elements").on("add", this.elementAdded)
        // this.get("elements").on("reset", this.elementsCreated)
    },

    elementAdded: function(){
        console.log("element added");
        //return new CombineElementsGroupView()
    },

    elementsCreated: function(c){
        console.log("created", arguments);
        var self = this;
        return new CombineElementsGroupView({
            collection: c
        });
    }

});