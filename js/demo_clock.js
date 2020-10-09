console.log('CLOCK LOADED');

(function(Drupal, $) {

    "use strict";

    // Votre code ici
    Drupal.behaviors.demoClock = {
        attach: function(context, settings) {
            function ticker() {
                var date = new Date();
                $(context).find('.clock').text(date.toLocaleTimeString());
            }
            setInterval(ticker, 1000); // DOM refresh every second
        }
    }

})(Drupal, jQuery)