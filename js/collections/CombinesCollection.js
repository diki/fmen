var CombinesCollection = Backbone.Collection.extend({

    model: Combine,
    
    url: "server/combines",

    parse: function(){
        
    }

});