{{--
    ==================================================
    VERA AI CHAT WIDGET (PURE ROBUST CSS)
    ==================================================
--}}

<style>
    #vera-widget {
        font-family: 'Instrument Sans', sans-serif;
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 9999;
    }

    /* Floating Action Button */
    #vera-btn {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #d49830 0%, #ba7c21 50%, #9b5f1a 100%);
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        box-shadow: 0 10px 25px -5px rgba(186, 124, 33, 0.5), 0 0 15px rgba(212, 152, 48, 0.4);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid rgba(255, 255, 255, 0.85);
        cursor: pointer;
        position: relative;
        z-index: 20;
        outline: none;
        padding: 0;
    }
    
    #vera-btn:hover {
        background: linear-gradient(135deg, #e2b35a 0%, #ba7c21 50%, #7e4b17 100%);
        box-shadow: 0 15px 30px -5px rgba(186, 124, 33, 0.6), 0 0 20px rgba(212, 152, 48, 0.5);
        transform: scale(1.06);
    }
    
    #vera-btn:active {
        transform: scale(0.95);
    }
    #vera-btn i {
        color: #ffffff !important;
        font-size: 1.35rem;
        position: relative;
        z-index: 10;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }
    
    #vera-btn:hover i {
        transform: rotate(12deg);
    }

    .pulse-span {
        position: absolute;
        inset: -4px;
        border-radius: 9999px;
        background: radial-gradient(circle, rgba(212, 152, 48, 0.45) 0%, rgba(186, 124, 33, 0.2) 70%, transparent 100%);
        z-index: 0;
        pointer-events: none;
    }

    /* Chat Window Container */
    #vera-chat-window {
        position: fixed;
        bottom: 96px;
        right: 24px;
        width: 375px;
        max-width: calc(100vw - 32px);
        height: 520px;
        max-height: calc(100vh - 120px);
        z-index: 9998;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        border-radius: 24px;
        background-color: #ffffff !important;
        border: 1px solid #e2e8f0;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25), 0 0 0 1px rgba(0, 0, 0, 0.04);
        transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        transform: scale(0) translateY(32px);
        opacity: 0;
        pointer-events: none;
        transform-origin: bottom right;
        box-sizing: border-box;
    }
    
    #vera-chat-window.active {
        transform: scale(1) translateY(0);
        opacity: 1;
        pointer-events: auto;
    }

    /* Header */
    .vera-hdr {
        background: linear-gradient(135deg, #ba7c21 0%, #9b5f1a 100%);
        padding: 12px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(186, 124, 33, 0.2);
        flex-shrink: 0;
    }
    .vera-hdr-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .vera-hdr-avatar-wrap {
        position: relative;
        width: 38px;
        height: 38px;
        min-width: 38px;
        max-width: 38px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.9);
        overflow: visible;
        background: #ffffff;
    }
    .vera-hdr-avatar-wrap img {
        width: 100% !important;
        height: 100% !important;
        max-width: 100% !important;
        max-height: 100% !important;
        object-fit: cover !important;
        border-radius: 50% !important;
        display: block !important;
    }
    .vera-hdr-dot {
        position: absolute;
        bottom: -1px;
        right: -1px;
        width: 10px;
        height: 10px;
        background-color: #10b981;
        border: 2px solid #ffffff;
        border-radius: 50%;
    }
    .vera-hdr-title {
        font-size: 14px;
        font-weight: 700;
        color: #ffffff;
        line-height: 1.2;
        margin: 0;
    }
    .vera-hdr-sub {
        font-size: 11px;
        font-weight: 500;
        color: #fef3c7;
        margin: 2px 0 0 0;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .vera-close-btn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.18);
        border: none;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.2s ease;
        padding: 0;
    }
    .vera-close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Feed */
    .vera-feed {
        flex-grow: 1;
        overflow-y: auto;
        padding: 12px 14px;
        background-color: #f8fafc;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .vera-feed::-webkit-scrollbar {
        width: 4px;
    }
    .vera-feed::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    /* Message Rows */
    .vera-msg-row {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        max-width: 90%;
        width: fit-content;
    }
    .vera-msg-row.user {
        margin-left: auto;
        flex-direction: row-reverse;
    }
    .vera-msg-avatar {
        width: 28px !important;
        height: 28px !important;
        min-width: 28px !important;
        max-width: 28px !important;
        border-radius: 50% !important;
        overflow: hidden !important;
        border: 1.5px solid #fbd38d !important;
        background: #ffffff !important;
        flex-shrink: 0 !important;
        margin-top: 1px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .vera-msg-avatar img {
        width: 100% !important;
        height: 100% !important;
        max-width: 100% !important;
        max-height: 100% !important;
        object-fit: cover !important;
        display: block !important;
    }

    /* Bubbles */
    .vera-bubble-bot {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        color: #1e293b;
        font-size: 13px;
        line-height: 1.45;
        padding: 9px 13px;
        border-radius: 16px;
        border-top-left-radius: 4px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        text-align: left;
        white-space: pre-line;
    }
    .vera-bubble-user {
        background: linear-gradient(135deg, #ba7c21 0%, #9b5f1a 100%);
        color: #ffffff;
        font-size: 13px;
        line-height: 1.45;
        padding: 9px 13px;
        border-radius: 16px;
        border-top-right-radius: 4px;
        box-shadow: 0 2px 8px rgba(186, 124, 33, 0.25);
        text-align: left;
        white-space: pre-line;
    }

    /* Timestamp */
    .vera-msg-time {
        font-size: 10px;
        margin-top: 4px;
        display: block;
        line-height: 1;
        user-select: none;
    }
    .vera-bubble-bot .vera-msg-time {
        color: #94a3b8;
        text-align: right;
    }
    .vera-bubble-user .vera-msg-time {
        color: rgba(255, 255, 255, 0.8);
        text-align: right;
    }

    /* Footer / Input */
    .vera-footer {
        padding: 10px 12px;
        background-color: #ffffff;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }
    .vera-input {
        flex-grow: 1;
        background-color: #f1f5f9;
        border: 1.5px solid #e2e8f0;
        color: #0f172a;
        font-size: 13px;
        padding: 9px 13px;
        border-radius: 12px;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }
    .vera-input:focus {
        background-color: #ffffff;
        border-color: #ba7c21;
        box-shadow: 0 0 0 3px rgba(186, 124, 33, 0.15);
    }
    .vera-input::placeholder {
        color: #94a3b8;
    }
    .vera-send-btn {
        width: 38px;
        height: 38px;
        min-width: 38px;
        background: linear-gradient(135deg, #ba7c21 0%, #9b5f1a 100%);
        border: none;
        border-radius: 12px;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 3px 8px rgba(186, 124, 33, 0.25);
        flex-shrink: 0;
        padding: 0;
    }
    .vera-send-btn:hover {
        opacity: 0.95;
        transform: scale(1.03);
    }
    .vera-send-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    /* WhatsApp Button */
    .vera-wa-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: 6px;
        padding: 7px 12px;
        background-color: #25D366;
        color: #ffffff !important;
        font-weight: 700;
        font-size: 11px;
        border-radius: 8px;
        text-decoration: none !important;
        border: none;
        box-shadow: 0 2px 6px rgba(37, 211, 102, 0.3);
        transition: background-color 0.2s ease;
    }
    .vera-wa-btn:hover {
        background-color: #128C7E;
    }

    /* Typing Animation */
    @keyframes typing-bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }
    .typing-dot {
        display: inline-block;
        width: 5px;
        height: 5px;
        background-color: #ba7c21;
        border-radius: 50%;
        animation: typing-bounce 1.2s infinite ease-in-out;
    }

    @keyframes pulse-gold {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.35); opacity: 0.3; }
    }
    .pulse-dot {
        animation: pulse-gold 2s infinite;
    }

    #vera-widget, #vera-chat-window {
        user-select: none;
        -webkit-user-select: none;
    }
    #vera-input {
        user-select: text;
        -webkit-user-select: text;
    }
</style>

<!-- Floating Launcher Button -->
<div id="vera-widget">
    <button id="vera-btn" type="button" aria-label="Buka chat dengan Vera">
        <span class="pulse-span pulse-dot"></span>
        <i class="fa-solid fa-headset"></i>
    </button>
</div>

<!-- Chat Window -->
<div id="vera-chat-window">
    <!-- Header -->
    <div class="vera-hdr">
        <div class="vera-hdr-left">
            <div class="vera-hdr-avatar-wrap">
                <img src="{{ asset('images/vera_avatar.png') }}" alt="Vera">
                <span class="vera-hdr-dot"></span>
            </div>
            <div>
                <h4 class="vera-hdr-title">Vera</h4>
                <p class="vera-hdr-sub">
                    <span>Asisten AI eVoters</span>
                </p>
            </div>
        </div>
        <button id="close-vera-chat" class="vera-close-btn" type="button" aria-label="Tutup chat">
            <i class="fa-solid fa-xmark" style="font-size: 13px;"></i>
        </button>
    </div>

    <!-- Feed -->
    <div id="vera-chat-feed" class="vera-feed">
        <div class="vera-msg-row">
            <div class="vera-msg-avatar">
                <img src="{{ asset('images/vera_avatar.png') }}" alt="Vera">
            </div>
            <div class="vera-bubble-bot">
                <div>Halo! Saya <strong>Vera</strong>, asisten AI resmi <strong>eVoters.id</strong>. Ada yang bisa saya bantu terkait voting online, aktivasi token, atau pembuatan event?</div>
                <span class="vera-msg-time">{{ date('H:i') }}</span>
            </div>
        </div>
    </div>

    <!-- Hidden Typing Indicator Template -->
    <div id="vera-typing-template" style="display: none;">
        <div class="vera-msg-row">
            <div class="vera-msg-avatar">
                <img src="{{ asset('images/vera_avatar.png') }}" alt="Vera">
            </div>
            <div class="vera-bubble-bot" style="display: flex; align-items: center; gap: 4px; padding: 8px 12px;">
                <span class="typing-dot" style="animation-delay: 0s;"></span>
                <span class="typing-dot" style="animation-delay: 0.2s;"></span>
                <span class="typing-dot" style="animation-delay: 0.4s;"></span>
            </div>
        </div>
    </div>

    <!-- Footer Input -->
    <div class="vera-footer">
        <input type="text" id="vera-input" class="vera-input" placeholder="Tanyakan pada Vera..." aria-label="Ketik pesan">
        <button id="vera-send-btn" class="vera-send-btn" type="button" aria-label="Kirim pesan">
            <i class="fa-solid fa-paper-plane" style="font-size: 12px;"></i>
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const veraBtn        = document.getElementById('vera-btn');
    const veraWindow      = document.getElementById('vera-chat-window');
    const closeVera       = document.getElementById('close-vera-chat');
    const input           = document.getElementById('vera-input');
    const sendBtn         = document.getElementById('vera-send-btn');
    const feed            = document.getElementById('vera-chat-feed');
    const typingTemplate  = document.getElementById('vera-typing-template');

    const chatHistory = [];
    let isSending = false;
    const REQUEST_TIMEOUT_MS = 15000;

    function getCurrentTime() {
        const now = new Date();
        return now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }).replace('.', ':');
    }

    function toggleChat() {
        const isOpen = veraWindow.classList.toggle('active');
        if (isOpen) {
            input.focus();
            scrollFeed();
        }
    }

    function scrollFeed() {
        feed.scrollTop = feed.scrollHeight;
    }

    function appendMessage(sender, text) {
        const isUser = sender === 'user';
        const timeStr = getCurrentTime();

        const row = document.createElement('div');
        row.className = `vera-msg-row ${isUser ? 'user' : ''}`;

        if (!isUser) {
            const avatar = document.createElement('div');
            avatar.className = 'vera-msg-avatar';
            avatar.innerHTML = `<img src="{{ asset('images/vera_avatar.png') }}" alt="Vera">`;
            row.appendChild(avatar);
        }

        const bubble = document.createElement('div');
        bubble.className = isUser ? 'vera-bubble-user' : 'vera-bubble-bot';

        const contentDiv = document.createElement('div');

        const waRegex = /https:\/\/wa\.me\/[0-9]+/i;
        const match = text.match(waRegex);

        if (!isUser && match) {
            const cleanText = text.replace(waRegex, '').trim();

            const textSpan = document.createElement('div');
            textSpan.textContent = cleanText;
            contentDiv.appendChild(textSpan);

            const templateText = encodeURIComponent("Halo Admin E-Voters.id, saya membutuhkan bantuan/informasi terkait platform e-voting. Mohon bantuannya.");
            const waUrlWithTemplate = `https://wa.me/6281290174510?text=${templateText}`;

            const waBtn = document.createElement('a');
            waBtn.href = waUrlWithTemplate;
            waBtn.target = '_blank';
            waBtn.rel = 'noopener noreferrer';
            waBtn.className = 'vera-wa-btn';
            waBtn.innerHTML = `<i class="fa-brands fa-whatsapp"></i> Hubungi WhatsApp`;
            contentDiv.appendChild(waBtn);
        } else {
            contentDiv.textContent = text;
        }

        bubble.appendChild(contentDiv);

        const timeSpan = document.createElement('span');
        timeSpan.className = 'vera-msg-time';
        timeSpan.textContent = timeStr;
        bubble.appendChild(timeSpan);

        row.appendChild(bubble);
        feed.appendChild(row);
        scrollFeed();
    }

    function showTypingIndicator() {
        const node = typingTemplate.cloneNode(true);
        node.id = 'vera-current-typing';
        node.style.display = 'block';
        feed.appendChild(node);
        scrollFeed();
        return node;
    }

    function setSendingState(sending) {
        isSending = sending;
        input.disabled = sending;
        sendBtn.disabled = sending;
    }

    async function sendMessage() {
        if (isSending) return;

        const messageText = input.value.trim();
        if (!messageText) return;

        appendMessage('user', messageText);
        input.value = '';
        setSendingState(true);

        const typingIndicator = showTypingIndicator();
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), REQUEST_TIMEOUT_MS);

        try {
            const response = await fetch('{{ route('ai.chat') }}', {
                method: 'POST',
                signal: controller.signal,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    message: messageText,
                    history: chatHistory
                })
            });

            const data = await response.json();
            typingIndicator.remove();

            if (response.ok && data.status === 'success' && data.reply) {
                appendMessage('assistant', data.reply);
                chatHistory.push({ role: 'user', content: messageText });
                chatHistory.push({ role: 'assistant', content: data.reply });
            } else {
                appendMessage('assistant', data.message || 'Maaf, Vera sedang tidak dapat menjawab saat ini. Hubungi tim kami secara manual.');
            }
        } catch (error) {
            typingIndicator.remove();
            const isTimeout = error.name === 'AbortError';
            appendMessage('assistant', isTimeout
                ? 'Vera butuh waktu lebih lama dari biasanya untuk merespons. Silakan coba lagi sesaat lagi.'
                : 'Terjadi gangguan jaringan saat menghubungi asisten Vera.');
        } finally {
            clearTimeout(timeoutId);
            setSendingState(false);
            input.focus();
            scrollFeed();
        }
    }

    // Context menu / devtools protections
    const widgetContainer = document.getElementById('vera-widget');
    if (widgetContainer) {
        widgetContainer.addEventListener('contextmenu', e => e.preventDefault());
    }
    veraWindow.addEventListener('contextmenu', e => e.preventDefault());

    window.addEventListener('keydown', function (e) {
        if (
            e.key === 'F12' || 
            (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'i' || e.key === 'J' || e.key === 'j' || e.key === 'C' || e.key === 'c')) || 
            (e.ctrlKey && (e.key === 'U' || e.key === 'u'))
        ) {
            const active = document.activeElement;
            if (active && (active.closest('#vera-widget') || active.closest('#vera-chat-window'))) {
                e.preventDefault();
                e.stopPropagation();
            }
        }
    }, true);

    veraBtn.addEventListener('click', toggleChat);
    closeVera.addEventListener('click', toggleChat);

    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMessage();
        }
    });
});
</script>