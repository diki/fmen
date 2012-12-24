var UserRecord = Backbone.Model.extend({

    defaults: {
        "sourceUrl"            : "imgSrc",
        "imageUrl"          : "thumbSSrc",
        "note"             : undefined,
        "created_at"      : "creation date",
        "price"              : 0,
        "owner"             : undefined,
        "folder"          : undefined,
        "type"      : undefined, 
    },

});