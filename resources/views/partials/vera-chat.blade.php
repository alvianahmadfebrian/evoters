{{--
    ==================================================
    VERA AI CHAT WIDGET
    ==================================================
--}}

<style>
    #vera-widget {
        font-family: 'Instrument Sans', sans-serif;
    }

    /* Robust CSS-driven button styling to bypass Tailwind JIT compilation lag */
    #vera-btn {
        width: 56px;
        height: 56px;
        background-color: #059669;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        cursor: pointer;
        position: relative;
        z-index: 20;
        outline: none;
    }
    
    #vera-btn:hover {
        background-color: #047857;
        transform: scale(1.05);
    }
    
    #vera-btn:active {
        transform: scale(0.95);
    }
    #vera-btn i {
        color: #ffffff !important;
        font-size: 1.25rem;
        position: relative;
        z-index: 10;
        transition: transform 0.3s ease;
    }
    
    #vera-btn:hover i {
        transform: rotate(12deg);
    }

    .pulse-span {
        position: absolute;
        inset: 0;
        border-radius: 9999px;
        background-color: rgba(5, 150, 105, 0.25);
        z-index: 0;
        pointer-events: none;
    }

    /* Robust CSS-driven positioning & transitions for the Chat Window */
    #vera-chat-window {
        position: fixed;
        bottom: 96px;
        right: 24px;
        width: 384px;
        max-width: calc(100vw - 2rem);
        height: 500px;
        max-height: 70vh;
        z-index: 9998;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        border-radius: 2rem;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        transform: scale(0) translateY(32px);
        opacity: 0;
        pointer-events: none;
        transform-origin: bottom right;
    }
    
    #vera-chat-window.active {
        transform: scale(1) translateY(0);
        opacity: 1;
        pointer-events: auto;
    }

    @keyframes pulse-emerald {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.4); opacity: 0.35; }
    }
    .pulse-dot {
        animation: pulse-emerald 2s infinite;
    }

    @keyframes typing-bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    .typing-dot {
        animation: typing-bounce 1.2s infinite ease-in-out;
    }

    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    /* Prevent selection of elements inside widget except the input */
    #vera-widget, #vera-chat-window {
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }
    #vera-input {
        user-select: text;
        -webkit-user-select: text;
        -moz-user-select: text;
        -ms-user-select: text;
    }
</style>

<!-- ==================== VERA AI CHAT WIDGET ==================== -->
<!-- Floating Action Button (Green Circle with white CS icon) -->
<div id="vera-widget" class="fixed bottom-6 right-6 z-[9999]">
    <button id="vera-btn" type="button" aria-label="Buka chat dengan Vera">
        <span class="pulse-span pulse-dot"></span>
        <i class="fa-solid fa-headset"></i>
    </button>
</div>

<!-- Chat Overlay Window (Sibling of widget container, positioned relative to viewport via raw CSS) -->
<div id="vera-chat-window" class="glass-card border border-white/10 shadow-2xl">
    <!-- Header -->
    <div class="bg-slate-950/70 backdrop-blur-md px-5 py-4 border-b border-white/5 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="w-9 h-9 rounded-full relative flex-shrink-0">
                <div class="w-full h-full rounded-full overflow-hidden border border-[#2b3a8c]/30">
                    <img src="{{ asset('images/vera_avatar.png') }}" alt="Vera" class="w-full h-full object-cover">
                </div>
                <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 rounded-full border-2 border-slate-950"></span>
            </div>
            <div class="text-left">
                <h4 class="text-sm font-bold text-white leading-none">Vera</h4>
                <span class="text-[10px] text-emerald-400 font-bold tracking-wide flex items-center mt-1">Online</span>
            </div>
        </div>
        <button id="close-vera-chat" type="button" aria-label="Tutup chat"
                class="w-8 h-8 rounded-xl bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white transition-colors flex items-center justify-center cursor-pointer">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>

    <!-- Chat Messages Feed -->
    <div id="vera-chat-feed" class="flex-grow overflow-y-auto p-5 space-y-4 no-scrollbar bg-slate-950/20">
        <div class="flex items-start space-x-2.5 max-w-[85%]">
            <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0 border border-[#2b3a8c]/30">
                <img src="{{ asset('images/vera_avatar.png') }}" alt="Vera" class="w-full h-full object-cover">
            </div>
            <div class="bg-white/5 border border-white/5 rounded-2xl rounded-tl-none px-4 py-3 text-xs md:text-sm text-gray-300 text-left leading-relaxed">
                Halo! Saya Vera, asisten AI resmi E-Voters.id. Ada yang bisa saya bantu terkait platform voting online kami?
            </div>
        </div>
    </div>

    <!-- Typing Indicator (Template Hidden) -->
    <div id="vera-typing-template" class="hidden">
        <div class="flex items-start space-x-2.5 max-w-[85%] animate-pulse">
            <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0 border border-[#2b3a8c]/30">
                <img src="{{ asset('images/vera_avatar.png') }}" alt="Vera" class="w-full h-full object-cover">
            </div>
            <div class="bg-white/5 border border-white/5 rounded-2xl rounded-tl-none px-4 py-3 text-sm text-gray-300">
                <div class="flex items-center space-x-1.5 py-1">
                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full typing-dot" style="animation-delay: 0s"></span>
                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full typing-dot" style="animation-delay: 0.2s"></span>
                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full typing-dot" style="animation-delay: 0.4s"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Input -->
    <div class="p-4 border-t border-white/5 bg-slate-950/40 backdrop-blur-md flex items-center space-x-2">
        <input type="text" id="vera-input" placeholder="Tanyakan pada Vera..." aria-label="Ketik pesan untuk Vera"
               class="flex-grow bg-white/5 text-xs md:text-sm text-white placeholder-gray-400 rounded-xl px-4 py-3 border border-white/5 focus:outline-none focus:border-[#2b3a8c]/50 focus:ring-1 focus:ring-[#2b3a8c]/30 transition-all">
        <button id="vera-send-btn" type="button" aria-label="Kirim pesan"
                class="w-10 h-10 rounded-xl bg-[#2b3a8c] hover:bg-[#202c70] text-white flex items-center justify-center transition-all cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
            <i class="fa-solid fa-paper-plane text-xs md:text-sm"></i>
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

    // Pakai textContent (bukan innerHTML) untuk isi pesan supaya aman dari XSS
    function appendMessage(sender, text) {
        const isUser = sender === 'user';

        const container = document.createElement('div');
        container.className = `flex items-start space-x-2.5 max-w-[85%] ${isUser ? 'ml-auto flex-row-reverse space-x-reverse' : ''}`;

        if (!isUser) {
            const avatar = document.createElement('div');
            avatar.className = 'w-8 h-8 rounded-full overflow-hidden flex-shrink-0 border border-[#2b3a8c]/30';
            avatar.innerHTML = `<img src="{{ asset('images/vera_avatar.png') }}" alt="Vera" class="w-full h-full object-cover">`;
            container.appendChild(avatar);
        }

        const bubble = document.createElement('div');
        bubble.className = isUser
            ? 'bg-[#2b3a8c] text-white rounded-tr-none rounded-2xl px-4 py-3 text-xs md:text-sm text-left leading-relaxed whitespace-pre-line'
            : 'bg-white/5 border border-white/5 text-gray-300 rounded-tl-none rounded-2xl px-4 py-3 text-xs md:text-sm text-left leading-relaxed whitespace-pre-line flex flex-col space-y-2';

        // Detect if text contains a WhatsApp link
        const waRegex = /https:\/\/wa\.me\/[0-9]+/i;
        const match = text.match(waRegex);

        if (!isUser && match) {
            const waUrl = match[0];
            const cleanText = text.replace(waRegex, '').trim();

            const textSpan = document.createElement('span');
            textSpan.textContent = cleanText;
            bubble.appendChild(textSpan);

            // Create beautiful green WhatsApp CS button with pre-filled support text template
            const templateText = encodeURIComponent("Halo Admin E-Voters.id, saya membutuhkan bantuan/informasi terkait platform e-voting. Mohon bantuannya.");
            const waUrlWithTemplate = `https://wa.me/6281290174510?text=${templateText}`;

            const waBtn = document.createElement('a');
            waBtn.href = waUrlWithTemplate;
            waBtn.target = '_blank';
            waBtn.rel = 'noopener noreferrer';
            waBtn.className = 'mt-2 inline-flex items-center justify-center px-4 py-2.5 bg-[#25D366] hover:bg-[#128C7E] text-white font-bold text-xs rounded-xl transition-all shadow-md text-center border-none';
            waBtn.style.textDecoration = 'none';
            waBtn.style.color = '#ffffff';
            waBtn.innerHTML = `<i class="fa-brands fa-whatsapp text-sm mr-1.5"></i> Hubungi WhatsApp`;
            bubble.appendChild(waBtn);
        } else {
            bubble.textContent = text;
        }

        container.appendChild(bubble);
        feed.appendChild(container);
        scrollFeed();
    }

    function showTypingIndicator() {
        const node = typingTemplate.cloneNode(true);
        node.id = 'vera-current-typing';
        node.classList.remove('hidden');
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

    // Prevent right-click / context menu (Inspect Element) on the chat widget elements
    const widgetContainer = document.getElementById('vera-widget');
    if (widgetContainer) {
        widgetContainer.addEventListener('contextmenu', e => e.preventDefault());
    }
    veraWindow.addEventListener('contextmenu', e => e.preventDefault());

    // Block keyboard DevTools shortcuts when interacting with the chatbot
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