$(function(){

    var chatPopup           = $('.chat-popup');
    var chatPopupTrigger    = $('.chat-popup-button');
    var chatCloseTrigger    = $('.chat-popup .chat-popup-close');

    var chatSendMessage     = $('.chat-popup .chat-send input[type*="text"]');
    var chatSendButton      = $('.chat-popup .chat-send-button');
    var chatContent         = $('.chat-popup .chat-content');
    var chatContentW        = $('.chat-popup .chat-content-wrapper');


    chatPopupTrigger.on('click', function() {
        chatPopup.addClass('opened');
    });

    chatCloseTrigger.on('click', function() {
        chatPopup.removeClass('opened');
    });


    function addChatMessage() {
        chatContent.append('<div class="chat-message self">' + chatSendMessage.val() + '</div>');
        chatSendMessage.val("")
    }

    var chatContentWPs = new PerfectScrollbar('#chat-content-wrapper');
    
    chatSendButton.on('click', function(e) {
        e.preventDefault();
        addChatMessage();

        chatContentW.scrollTop(chatContentW.prop("scrollHeight"));
        chatContentWPs.update();
        return false;
    });

    chatSendMessage.on('keypress', function(e) {
        if (e.which == "13") {
            e.preventDefault();
            addChatMessage();

            chatContentW.scrollTop(chatContentW.prop("scrollHeight"));
            chatContentWPs.update();
            return false;
        }
    });
});