var UserRecordCollection = Backbone.Collection.extend({

    model: UserRecord,
    url: "/user/record/manage"

});