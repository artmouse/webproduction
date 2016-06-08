{|if $jQuery|}
    // jquery
    jQuery(function() {
        jQuery('.EngineDebug-autohide').each(function(i, e) {
            jQuery(e).hide();
            jQuery('#'+e.id+'-link').click(function(event) {
                jQuery(e).toggle();
                event.preventDefault();
            });
        });
    });
{|else|}
    // prototype.js
    document.observe("dom:loaded", function() {
        $$('.EngineDebug-autohide').each(function(e) {
            e.hide();
            $(e.id+'-link').observe('click', function(event) {
                e.toggle();
                Event.stop(event);
            });
        });
    });
{|/if|}