var downloadGrid = (function(){
  
    "use strict";
    
    var $cardContainer = $('.download-cards');
    var $downloadCard  = $('.download-card__content-box');
    var $viewTrigger   = $('button').attr('data', 'trigger');
  
    function swapTriggerActiveClass(e) {   
      $viewTrigger.removeClass('active');
      $(e.target).addClass('active');
    }
  
    function swapView(e) {
      var $currentView = $(e.target).attr('data-trigger');
      $cardContainer.attr('data-view', $currentView);
    }
  
    $(document).ready(function(){
      // Event Listener
      $viewTrigger.click(function(e){
        swapTriggerActiveClass(e);
        swapView(e);        
      });  
    });
    
  })();