var CombineElement = Backbone.Model.extend({

    url: "ginkatego/server/celements/manage",
    defaults: {
        "imgId"                 :   "",
        "note"                  :   "notes",
        "name"                  :   "name",
        //"type"                  :   "element",
        "price"                 :   1.23 ,
        "link"                  :   "link",
        "keyElement"            :   0, //not main member
        "groupId"               :   "",
        "tags"                  :   "tags",
        "combineId"              :   "" //to keep models relational
    },

    initialize: function (argument) {
        // body...
        //this.set("suggestionElements") = new SuggestionElementsCollection();
    }

});