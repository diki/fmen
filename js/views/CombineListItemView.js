var CombineListItemView = Backbone.View.extend({

    tagName: "li",
    className: "box style55",
    events: {
        "click .item-like": "increaseLike"
    },
    initialize: function(){
        _.bindAll(this, "render", "increaseLike");
        this.render();
    },

    render: function(){
        $(this.el).html(_.template($("#combine-list-item").html())(this.model.attributes));

        $(this.el).find(".co-list-item-info").hover(
            function(){
                $(this).next("div").show();
                console.log("eeee");
            },

            function(){
                $(this).next("div").hide();
            }
        );
    },

    increaseLike: function(){
        if($.cookie("_gstuk")){

            var val = parseInt($(".item-like", this.el).text(), 10) + 1;
            $(".item-like", this.el).html('<i class="icon-heart"></i>'+val);
            $.ajax({
                type: "POST",
                url: "/server/combines/increaseLike",
                data: {id: this.model.id},
                dataType: "json",
                success: function(resp){
                    console.log(resp);
                },
                error: function(){
                    $('#loginModal').modal({});
                }
            });
        } else {
            $('#loginModal').modal({});
        }
    }

});