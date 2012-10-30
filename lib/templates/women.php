{% extends "master.php" %}

{% block title %} {{ title }} {% endblock %}

{% block content %}
    
    <h2>Kadın</h2>
    <div id="container">
    </div>

    <nav id="page-nav" style="display: none">
        <a href="/women/2.html"></a>
    </nav>

{% endblock %}

{% block scripts %}

    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js" type="text/javascript"></script>
    <script src="/js/plugins/jquery.masonry.min.js" type="text/javascript"></script>
    <script src="/js/plugins/jquery.imageLoaded.js" type="text/javascript"></script>
    <script src="/js/plugins/jquery.infinitescroll.min.js" type="text/javascript"></script>
    <script>
      $(function(){
        
        var $container = $('#container');
        
        $container.imagesLoaded(function(){
          $container.masonry({
            itemSelector: '.box',
            columnWidth: 100
          });
        });
        
        $container.infinitescroll({
          navSelector  : '#page-nav',    // selector for the paged navigation 
          nextSelector : '#page-nav a',  // selector for the NEXT link (to page 2)
          itemSelector : '.box',     // selector for all items you'll retrieve
          loading: {
              finishedMsg: 'No more pages to load.',
              img: 'http://i.imgur.com/6RMhx.gif'
            }
          },
          // trigger Masonry as a callback
          function( newElements ) {
            // hide new items while they are loading
            var $newElems = $( newElements ).css({ opacity: 0 });
            // ensure that images load before adding to masonry layout
            $newElems.imagesLoaded(function(){
              // show elems now they're ready
              $newElems.animate({ opacity: 1 });
              $container.masonry( 'appended', $newElems, true ); 
            });
          }
        );
        
      });
    </script>    
{% endblock %}