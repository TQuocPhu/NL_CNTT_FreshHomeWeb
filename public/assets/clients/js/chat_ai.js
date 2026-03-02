$(document).ready(function () {
    $('#chat-toggle').click(function (e) {
        $('#chat-box').toggleClass('hidden')
        $('#scrollUp').toggleClass('hidden')

        if ($('#chat-box').hasClass('hidden')) {
            $('#chat-widget').css('bottom', '140px');
        } else {
            loadMessages();
            $('#chat-widget').css('bottom', '20px');
        }
    })

    $('#chat-close').click(function () {
        $('#chat-box').addClass('hidden')
        $('#chat-widget').css('bottom', '140px');
        $('#scrollUp').toggleClass('show')
    })

    $('#send-btn').click(function (e) {
        let msg = $('#message-input').val().trim();

        if (!msg) return;

        appendOne({ sender: 'user', message: msg });

        $('#message-input').val('');
        $('#send-btn').prop('disabled', true);

        let loadingId = 'loading-' + Date.now();
        $('#chat-message').append(`<div id="${loadingId}" class="bot-msg">Đang trả lời...</div>`);
        $('#chat-message').scrollTop($('#chat-message')[0].scrollHeight);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        });

        $.post('/chat/send', { message: msg }, function (res) {

            $('#' + loadingId).remove();

            if (res.bot) appendOne(res.bot);

        }).fail(function () {
            $('#' + loadingId).remove();
            appendOne({ sender: 'box', message: 'Lỗi! không gửi được tin nhắn' })
            
        }).always(function () {
            $('#send-btn').prop('disabled', false);
        });
    });

    $('#message-input').keypress(function (e) {
        if (e.which === 13) {
            $('#send-btn').click();
            return false;
        }
    })

    function loadMessages() {
        $('#chat-message').html('');

        $.get('/chat/messages', function (msgs) {

            if (!msgs || msgs.length === 0) {
                $('#chat-message').append(`<div class="bot-msg">Xin chào, tôi có thể giúp gì cho bạn ?</div>`)
                return;
            }

            msgs.forEach(function (m) { appendOne(m); });
            $('#chat-message').scrollTop($('#chat-message')[0].scrollHeight);
        });
    }

    function appendOne(m) {
        let cls = m.sender === 'user' ? 'user-msg' : 'bot-msg';
        $('#chat-message').append(`<div class="${cls}">${escapeHtml(m.message)}</div>`);
        $('#chat-message').scrollTop($('#chat-message')[0].scrollHeight);
    }

    function escapeHtml(text) {
        return $(`<div/>`).text(text).html();
    }
});