var BBTabView = Backbone.View.extend({

    events: {
        "click .bb-tab-link": "openTab"
    },
    initialize: function(options){

        _.bindAll(this, "openTab");

        this.options = _.clone(options);

        this.el = options.el;
        this.$tabs = {};
        this.$menuItems = [];

        this.createToolbar(options.tabs);
        this.createTabContent(options.tabs);

    },

    openTab: function(e){
        //console.log("opening tab");
        e.preventDefault();
        //close current tab
        this.$currentTab.hide();

        //open new one through tabs object
        var tabId = $(e.target).parent().attr("data-target");

        this.$currentTab = this.$tabs[tabId];
        this.$tabs[tabId].show();

    },
    createToolbar: function(tabs){
        console.log("creating tabs el is", this.$el);

        var ul = $('<ul class="header-nav-list bb-tab-links" style="z-index:999999"></ul>');

        console.log("created"); 
        //create menu items
        _.each(tabs, function(tab, idx){
            var li = $('<li class="header-nav-list-item bb-tab-list-item" data-target="bb_tab_'+idx+'"><a class="header-nav-list-item-link bb-tab-link" href="">'+tab.name+'</a></li>');
            if(idx===0) {
                li.find("a").addClass("first-tab");
            }
            ul.append(li);
        });

        console.log("broooo");
        this.$el.append(ul);
    },

    createTabContent: function(tabs){
        var self = this;
        var content = $('<div class="bb-tabs-container" style="height:'+this.options.height+'px;"></div>');
        _.each(tabs, function(tab, idx){


            //create tab content with id
            var tabContentId = "bb_tab_"+idx;
            var li = $('<div class="bb-tab-content" style="display: none; height:'+self.options.height+'px;" id="bb_tab_'+idx+'"></div>');

            //also note that only active tab content should be displayed at start
            if(tab.active){
                li.show();
                self.$currentTab = li;
            }

            self.$tabs[tabContentId] = li;

            li.append(tab.content);

            //and append to ta-content -- container of tabs
            content.append(li);
        });

        this.$el.append(content);
    }


});