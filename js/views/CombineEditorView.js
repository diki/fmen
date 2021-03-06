var CombineEditorView = Backbone.View.extend({

    el: "#combineEditor",

    events: {
        "change #imgUpload": "uploadImage",
        "click #newCombineButton": "createCombine",
        "click .combine-image-wrapper": "addCombineElement",
        "click #updateCombine": "updateCombine"
    },

    initialize: function(){
        
        _.bindAll(this, "render", "uploadImage", "createCombine", 
            "addCombineElement", "addNewElement", "removeElement", "updateCombine");

        this.on("addNewElement", this.addNewElement, this);
        this.on("removeElement", this.removeElement, this);
        this.render();

        var self = this;
        //need another products collection which does not reset
        //and append every time userRecordCollection fetc
        this.userRecords = new UserRecordCollection();

        window.userRecordCol.on("reset", function(c){
            self.userRecords.add(c.models);
            // console.log("reset", c, self.userRecords.length);
        })
    },

    render: function(){

        console.log(this.model.attributes);
        this.$el.html(_.template($("#combineEditorViewTemplate").html())(this.model.attributes));

        SI.Files.stylize(this.$el.find("#imgUpload")[0]);
        _.each($("#imgUpload"), function (ell, idx) {
            SI.Files.stylize(ell);
        });
    },

    uploadImage: function(e){

        var self = this;
         $("#combineImageForm", this.el).ajaxSubmit(function(resp){

            var srcText =JSON.parse(resp).id;
            //window.combineImageAddress = srcText
            window.combineImageId = srcText;
            
/*            var imageObj = new Image();
            imageObj.src = "http://s3.amazonaws.com/ginkatego/uploads/"+srcText;
            var imageWidth = 0;
            var imageHeight = 0;
            var topPadding = 0;
            var leftPadding = 0;

            imageObj.onload = function(){
                var topPadding = (570 - imageObj.height)/2;
                var leftPadding = (380-imageObj.width)/2;
                imageObj.style.padding = topPadding+"px " + leftPadding + "px";
                $(".combine-image-wrapper", self.el).rem
            }*/

            $("#combineImage", self.el).attr("src", "http://s3.amazonaws.com/ginkatego/uploads/"+srcText);
            $("#combineImage", self.el).load(function(){
                var topPadding = Math.abs((570 - $(this).height())/2)+10;
                var leftPadding = Math.abs((380 - $(this).width())/2)+20;
                console.log(topPadding, leftPadding);
                // $(".combine-image-wrapper", self.el).css("padding", topPadding+"px "+leftPadding+"px");
            });
            $("#combineImageForm label.cabinet", self.el).width(100);
            $("#combineImageForm label.cabinet", self.el).height(20);

            $("#combineImageForm label.cabinet", self.el).css({
                "position": "absolute",
                "top": 0,
                "left": 0
            });

            $(".combine-image-wrapper", self.el).fadeIn();
            
         });
    },

    createCombine: function(){

        var self = this;

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/server/combines/add",
            data: {
                imgID: combineImageId,
                name: $("#combineName", self.el).val(),
                //title: $("#combineTitle", self.el).val(),
                notes: $("#combineNotes", self.el).val(),
                sex: $("#combineSex > option:selected", self.el).val(),
                category: $("#combineCategory > option:selected", self.el).val()
            },

            success: function(resp){
                console.log("new combine created with id ", resp.id);
                window.newCombineID = resp.id;

                console.log("creating new combine model");
                
                // window.combine = new Combine();
                self.model.set("imgID", combineImageId);
                self.model.set("imgSrc", combineImageId);
                self.model.set("notes", $("#combineNotes").val());
                self.model.set("sex", $("#combineSex > option:selected").val());
                self.model.set("category", $("#combineCategory > option:selected").val());
                self.model.id = resp.id;

                /*
                    render info message
                 */
                $("#infoMessage>span", self.el).html("Kombin başarıyla yaratıldı");
                $("#infoMessage", self.el).show();
                $("#action-info", self.el).show();
                $("#title").show();
                $("#updateCombineWrapper").show();
                /*
                    clear form on right side
                 */
                $("#combineOperations").html("");
            }
        });        
    },

    addCombineElement: function(e){
        
        if(!$(e.target).is("img")){
            return;
        }
        
        var self = this;
        /*
            calculate mouse position relative to target
            if image laoded ofcourse
         */
        
        if(window.combineImageId!==undefined){
            var parentOffset = $(e.target).offset(); 

            /*
                calculate relative distance according to X and Y
             */
            self.relX = e.pageX - parentOffset.left;
            self.relY = e.pageY - parentOffset.top;


            $("#userProductsWindow").modal("show");
        }
    },

    addNewElement: function(productId){

        if(window.newCombineID===undefined){
            alert("kombin yaratılmadı");
            return;
        }
        var productId = $("div.selected").attr("id");

        //set relX and relY attributes of model
        //get product model from userRecords with given id 
        //triggered by ProductsCatalogView
        var product = this.userRecords.get(productId);
        product.set("relX", this.relX);
        product.set("relY", this.relY);

        console.log("evet", product.attributes);

        $(".combine-image-wrapper", this.el).append(_.template($("#imagePlacerTemplate").html())(product.attributes));

        /*
            add new product to sidebar as seperate models
         */
        var ce = product.attributes;
        ce["combineId"] = window.newCombineID;
        ce.id;


        /*
            built new combine element model
         */
        var cel = new CombineElement();
        cel.set("width", product.get("width"));
        cel.set("height", product.get("height"));
        cel.set("relX", product.get("relX"));
        cel.set("relY", product.get("relY"));
        cel.set("recordId", productId);
        cel.set("combineId", window.newCombineID);
        /*
            create view of this model

            this way model's view will be responsible for operations
         */
        var celv = new CombineElementEditableView({
            model: product
        });

        //add to window.combine elements collection
        this.model.get("elements")[productId] = cel;
        //console.log(this.model.get("elements"));

        $("#combineOperations").addClass("combine-elements-list");
        $("#combineOperations").append(celv.el);

        console.log("this is cel", cel);
        //create new CombineElement model with extra combineId attribute (window.newCombineId)
        
        // console.log(productId, this.relX, this.relY, this.userRecords.get(productId).attributes);

        // $(".combine-image-wrapper", this.el).append('<div class="image-placer" style="left:'+this.relX+
        //     'px;top:'+this.relY+'px;">o</div>');

        /*
            add black imagemap
         */
        
    },

    removeElement: function(productId) {
        console.log("removing", productId);
        this.model.get("elements")[productId] = null;

        //replace images on modal box
        $(".catalog-image-wrapper", "#pr_"+productId)
        .removeClass("listed")
        .prependTo("#"+productId);
        //remove item on right
        $("#pr_"+productId).remove();
        //remove product image place
        $("#ip_"+productId).remove();

    },

    /*
        add elements on right side to combine element
     */
    updateCombine: function(){
        //create combine element list -- not null
        var values = _.values(this.model.get("elements"));
        var actualValues = [];
        _.each(values, function(val){
            if(val!==null){
                actualValues.push(val.attributes);
            }
        });

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/server/combines/updateElements",
            data: {
                combineId: window.newCombineID,
                elements: JSON.stringify(actualValues)
            },

            success: function(res){
                console.log("succes update", res);
            }            
        });
    }

});