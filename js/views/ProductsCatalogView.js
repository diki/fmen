var ProductsCatalogView = Backbone.View.extend({

    el: "#productCatalog",

    events: {
        "scroll": "scrolled"
    },

    initialize: function(){
        _.bindAll(this, "render", "scrolled");

        /*
            clear last selection
         */
        $(".product-catalog-wrapper.selected").removeClass("selected");
        
        this.offset = 0;
        this.limit = 12;

        //fetching window.userRecordCol
        this.collection.fetch({
            data: {
                offset: this.offset*this.limit,
                limit: this.limit,
                list: false
            }
        });

        this.collection.on("reset", this.render);

        //bind click event to modal box button
        //triggers combineEditorView addNewElement with slected product id
        $("#addProductFromcatalog").click(function(){
            var productId = $(".product-catalog-wrapper.selected").attr("id");
            if(productId===undefined){
                alert("Select a prodcut");
            }
            window.combineEditorView.trigger("addNewElement", productId);

            $("#userProductsWindow").modal("hide");
        });
    },

    render: function(){

        var self = this;

        console.log("rebder");

        var productCatalogItemTemplate = '<div class="product-catalog-wrapper" id="<%=id%>">'+
            // '<img src="<%=imageUrl%>" />' +
            '<div class="catalog-image-wrapper"></div>' +
            '<textarea style="display: none;" value="<%=note%>"></textarea>'+
            '<div class="product-catalog-operations">' +
                '<div style="display: inline-block; margin-top: 6px; font-size: 13px; font-weight: bold;"><span>Fiyat: </span><span><%=price%></span></div>' +
                '<a style="" href="<%=sourceUrl%>" target="_blank">Mağazaya git</a></div>' +

                // '<a class="add-product-button">Ekle</a>' +
            // '</div>' +
        '</div>';        
        
        this.collection.each(function(m, idx){

            var imageObj = new Image();
            imageObj.src = m.get("imageUrl");
            var imageWidth = 0;
            var imageHeight = 0;
            var topMargin = 0;

            imageObj.onload = function(){
                if (imageObj.width > imageObj.height) { // landscape
                    topMargin = Math.floor(( 150 - (150 * imageObj.height / imageObj.width)) / 2);
                    imageWidth = 150;
                    imageHeight = Math.round(150 * imageObj.height / imageObj.width);
                } else if (imageObj.width < imageObj.height) {
                    leftMargin = Math.floor(( 150 - (150 * imageObj.width / imageObj.height)) / 2);
                    imageWidth = Math.round(150 * imageObj.width / imageObj.height);
                    imageHeight = 150;
                }

                imageObj.style.margin = topMargin+"px 0";
                imageObj.width = imageWidth;
                imageObj.height = imageHeight;

                m.set("width", imageWidth);
                m.set("height", imageHeight);
            }

            $(".product-list", self.el).append(_.template(productCatalogItemTemplate)(m.attributes));

            if((idx+1)%3==0){
                $(".product-list", self.el).append('<br style="clear: both" />');
            }

            var el = $("#"+m.id);
            /*
                add click event
             */
            el.click(function(){

                if($(this).hasClass("selected")){
                    $(this).removeClass("selected");

                    if($(".product-catalog-wrapper.selected").length==0){
                        $("#add-product-from-catalog").addClass("disabled");
                    }
                    return;
                };

                /*
                    clear all selected catalog items
                 */
                $(".product-catalog-wrapper.selected").removeClass("selected");
                //make this object selected
                $(this).addClass("selected");

                // self.selectedElementId = $(this).attr("id");
                $("#addProductFromcatalog").removeClass("disabled");
            });
            $(".catalog-image-wrapper", el).html(imageObj);

        });
    },

    scrolled: function(){
        if( $(".product-list", this.el).height()===$(this.el).scrollTop()+$(this.el).height()){
            // console.log("scroll", $(".product-list", this.el).height(), $(this.el).scrollTop(), $(this.el).height());
            this.offset += 1;
            this.collection.fetch({
                data: {
                    offset: this.offset * this.limit,
                    limit: this.limit,
                    list: false
                }
            });
        }
    }

});