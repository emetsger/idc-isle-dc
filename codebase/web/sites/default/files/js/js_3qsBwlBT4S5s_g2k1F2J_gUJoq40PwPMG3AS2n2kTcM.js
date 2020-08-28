// Eliminate FOIT (Flash of Invisible Text) caused by web fonts loading slowly
// using font events with Font Face Observer.
(function ($) {

  "use strict";

  Drupal.behaviors.atFFOI = {
    attach: function () {

      $('html').addClass('fa-loading');

      var fontObserver = new FontFaceObserver('FontAwesome');

      // Because we are loading an icon font we need a unicode code point.
      fontObserver.load('\uf287\uf142\uf0fc').then(function () {
        $('html').removeClass('fa-loading').addClass('fa-loaded');
      }, function() {
        $('html').removeClass('fa-loading').addClass('fa-unavailable');
      });

    }
  };
}(jQuery));
;
!function(e,s){"use strict";if(e("table.forum").addClass("responsive-enabled"),e("table.responsive-enabled").wrap('<div class="responsive-table"><div class="responsive-table__scroll"></div></div>'),e("table.responsive-enabled").prop("scrollWidth")>e(".responsive-table").width()){var l=s.t("Scroll to view");e(".responsive-table__scroll").append('<div class="responsive-table__message"><em>'+l+"</em></div>"),e("table.responsive-enabled").addClass("has-overflow")}}(jQuery,Drupal);
