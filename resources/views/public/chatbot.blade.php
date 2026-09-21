<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chatbot Asisten Virtual - SIMAGANG Diskominfosantik</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #4f46e5;
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --secondary: #764ba2;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --border-color: #e2e8f0;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: var(--text-dark);
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient animated blobs */
        .bg-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            opacity: 0.3;
        }

        .shape:nth-child(1) {
            width: 350px;
            height: 350px;
            background: #6366f1;
            top: -100px;
            left: -100px;
        }

        .shape:nth-child(2) {
            width: 400px;
            height: 400px;
            background: #a855f7;
            bottom: -100px;
            right: -100px;
        }

        .chatbot-page-wrapper {
            width: 100%;
            max-width: 860px;
            height: 90vh;
            max-height: 750px;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.45);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
            z-index: 10;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* ===== HEADER ===== */
        .chatbot-header {
            background: var(--primary-gradient);
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .chatbot-header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #ffffff;
            padding: 8px 16px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 13.5px;
            font-weight: 600;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            backdrop-filter: blur(5px);
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(-2px);
            color: #ffffff;
        }

        .bot-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ffffff;
        }

        .bot-icon-badge {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.2);
            border: 1.5px solid rgba(255, 255, 255, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #ffffff;
            backdrop-filter: blur(5px);
        }

        .bot-title-group h3 {
            font-size: 16px;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
            letter-spacing: -0.01em;
        }

        .bot-title-group p {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.85);
            margin: 0;
        }

        .chatbot-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.15);
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 12px;
            color: #ffffff;
            font-weight: 500;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 8px #10b981;
            animation: pulseLive 2s infinite ease-in-out;
        }

        @keyframes pulseLive {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        /* ===== MESSAGES ===== */
        .chatbot-messages {
            flex: 1;
            padding: 24px;
            overflow-y: auto;
            background: var(--bg-light);
            display: flex;
            flex-direction: column;
            gap: 16px;
            scroll-behavior: smooth;
        }

        .chatbot-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chatbot-messages::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .chat-message {
            display: flex;
            align-items: flex-end;
            gap: 12px;
            animation: msgFadeIn 0.3s ease;
        }

        .chat-message.user {
            flex-direction: row-reverse;
        }

        @keyframes msgFadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .chat-msg-avatar {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .bot-msg-avatar {
            background: var(--primary-gradient);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);
        }

        .user-msg-avatar {
            background: #64748b;
            color: #ffffff;
        }

        .message-wrapper {
            max-width: 75%;
            display: flex;
            flex-direction: column;
        }

        .message-content {
            padding: 14px 18px;
            border-radius: 20px;
            font-size: 14.5px;
            line-height: 1.6;
            word-break: break-word;
        }

        .bot .message-content {
            background: #ffffff;
            border-bottom-left-radius: 4px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
            color: var(--text-dark);
            border: 1px solid var(--border-color);
        }

        .user .message-content {
            background: var(--primary-gradient);
            color: #ffffff;
            border-bottom-right-radius: 4px;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.25);
        }

        .message-content strong {
            color: #4338ca;
            font-weight: 600;
        }

        .user .message-content strong {
            color: #ffffff;
        }

        .message-content a {
            color: #4f46e5;
            text-decoration: underline;
            font-weight: 500;
        }

        .user .message-content a {
            color: #e0e7ff;
        }

        .message-time {
            font-size: 11px;
            color: var(--text-muted);
            text-align: right;
            margin-top: 5px;
            font-weight: 500;
        }

        .user .message-time {
            color: rgba(255, 255, 255, 0.75);
        }

        /* ===== TYPING INDICATOR ===== */
        .typing-indicator {
            display: none;
            align-items: center;
            gap: 5px;
            padding: 12px 18px;
            background: #ffffff;
            border-radius: 18px;
            border-bottom-left-radius: 4px;
            width: fit-content;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            margin-left: 48px;
        }

        .typing-indicator.active {
            display: flex;
        }

        .typing-indicator span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary);
            animation: typingBounce 1.4s infinite ease-in-out both;
        }

        .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
        .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }

        @keyframes typingBounce {
            0%, 80%, 100% { transform: scale(0.6); opacity: 0.4; }
            40% { transform: scale(1.15); opacity: 1; }
        }

        /* ===== SUGGESTIONS BAR ===== */
        .chatbot-suggestions-bar {
            padding: 12px 20px;
            background: #ffffff;
            border-top: 1px solid #f1f5f9;
            flex-shrink: 0;
        }

        .suggestions-title {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .chatbot-suggestions {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 4px;
            scrollbar-width: thin;
        }

        .chatbot-suggestions::-webkit-scrollbar {
            height: 4px;
        }

        .chatbot-suggestions::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 4px;
        }

        .suggestion-btn {
            padding: 7px 14px;
            border-radius: 30px;
            border: 1.5px solid var(--border-color);
            background: #f8fafc;
            font-size: 12.5px;
            font-weight: 500;
            color: #334155;
            cursor: pointer;
            transition: all 0.25s ease;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: inherit;
            flex-shrink: 0;
        }

        .suggestion-btn i {
            color: var(--primary);
        }

        .suggestion-btn:hover {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .suggestion-btn:hover i {
            color: #ffffff;
        }

        /* ===== INPUT BAR ===== */
        .chatbot-input-bar {
            padding: 14px 20px 18px;
            background: #ffffff;
            border-top: 1px solid #f1f5f9;
            flex-shrink: 0;
        }

        .chatbot-input-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f8fafc;
            border-radius: 16px;
            padding: 6px 6px 6px 18px;
            border: 1.5px solid var(--border-color);
            transition: all 0.25s ease;
        }

        .chatbot-input-wrapper:focus-within {
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
        }

        .chatbot-input-wrapper input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            font-size: 14.5px;
            font-family: inherit;
            color: var(--text-dark);
            padding: 8px 0;
        }

        .chatbot-input-wrapper input::placeholder {
            color: #94a3b8;
        }

        .send-btn {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            border: none;
            background: var(--primary-gradient);
            color: #ffffff;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .send-btn:hover:not(:disabled) {
            transform: scale(1.05);
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.4);
        }

        .send-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            body {
                padding: 0;
            }

            .chatbot-page-wrapper {
                height: 100vh;
                max-height: 100vh;
                border-radius: 0;
                border: none;
            }

            .chatbot-header {
                padding: 14px 16px;
            }

            .chatbot-messages {
                padding: 16px 14px;
            }

            .message-wrapper {
                max-width: 88%;
            }

            .message-content {
                font-size: 13.5px;
                padding: 11px 14px;
            }

            .chatbot-input-bar {
                padding: 10px 14px 14px;
            }

            .back-btn span {
                display: none;
            }

            .back-btn {
                padding: 8px 12px;
            }
        }
    </style>
</head>
<body>

    <div class="bg-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="chatbot-page-wrapper">
        <!-- ===== HEADER ===== -->
        <div class="chatbot-header">
            <div class="chatbot-header-left">
                <a href="{{ url('/') }}" class="back-btn" title="Kembali" onclick="if (window.history.length > 1 && document.referrer) { history.back(); return false; }">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
                <div class="bot-brand">
                    <div class="bot-icon-badge">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="bot-title-group">
                        <h3>Asisten Virtual SIMAGANG</h3>
                        <p>Diskominfosantik Kabupaten Bekasi</p>
                    </div>
                </div>
            </div>
            <div class="chatbot-status-pill">
                <span class="status-dot"></span>
                <span>Online</span>
            </div>
        </div>

        <!-- ===== MESSAGES AREA ===== -->
        <div class="chatbot-messages" id="chatbotMessages">
            <div class="chat-message bot">
                <div class="chat-msg-avatar bot-msg-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="message-wrapper">
                    <div class="message-content">
                        Halo! 👋 Selamat datang di Layanan Informasi <strong>SIMAGANG Diskominfosantik Kab. Bekasi</strong>.<br><br>
                        Silakan tanyakan apa saja seputar program magang, persyaratan berkas, alur registrasi, durasi kerja praktik, sertifikat, atau informasi divisi yang tersedia.
                    </div>
                    <div class="message-time">Sekarang</div>
                </div>
            </div>
        </div>

        <!-- Typing Indicator -->
        <div class="typing-indicator" id="typingIndicator">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- ===== SUGGESTIONS BAR ===== -->
        <div class="chatbot-suggestions-bar">
            <div class="suggestions-title">
                <i class="fas fa-bolt"></i> Pertanyaan Cepat
            </div>
            <div class="chatbot-suggestions">
                <button class="suggestion-btn" onclick="sendSuggestion('syarat magang')">
                    <i class="fas fa-clipboard-check"></i> Syarat Magang
                </button>
                <button class="suggestion-btn" onclick="sendSuggestion('alur pendaftaran')">
                    <i class="fas fa-route"></i> Alur Pendaftaran
                </button>
                <button class="suggestion-btn" onclick="sendSuggestion('durasi magang')">
                    <i class="fas fa-calendar-days"></i> Durasi Magang
                </button>
                <button class="suggestion-btn" onclick="sendSuggestion('sertifikat')">
                    <i class="fas fa-award"></i> Sertifikat
                </button>
                <button class="suggestion-btn" onclick="sendSuggestion('divisi yang tersedia')">
                    <i class="fas fa-sitemap"></i> Divisi
                </button>
                <button class="suggestion-btn" onclick="sendSuggestion('alamat kantor')">
                    <i class="fas fa-location-dot"></i> Alamat Kantor
                </button>
                <button class="suggestion-btn" onclick="sendSuggestion('benefit magang')">
                    <i class="fas fa-gift"></i> Benefit
                </button>
            </div>
        </div>

        <!-- ===== INPUT BAR ===== -->
        <div class="chatbot-input-bar">
            <div class="chatbot-input-wrapper">
                <input 
                    type="text" 
                    id="chatbotInput" 
                    placeholder="Tuliskan pertanyaan Anda di sini..." 
                    onkeypress="handleKeyPress(event)"
                    autocomplete="off"
                    autofocus
                >
                <button class="send-btn" id="sendBtn" onclick="sendMessage()" aria-label="Kirim Pesan">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- =========================================== -->
    <!-- JAVASCRIPT LOGIC                            -->
    <!-- =========================================== -->
    <script>
        const API_URL = '{{ url("/api/chatbot/send") }}';
        const CSRF_TOKEN = '{{ csrf_token() }}';
        let isProcessing = false;

        // Send message from input
        function sendMessage() {
            const input = document.getElementById('chatbotInput');
            const message = input.value.trim();

            if (!message || isProcessing) return;

            input.value = '';
            processUserMessage(message);
        }

        // Send suggestion click
        function sendSuggestion(message) {
            if (isProcessing) return;
            const input = document.getElementById('chatbotInput');
            if (input) input.value = message;
            processUserMessage(message);
        }

        // Handle Enter
        function handleKeyPress(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        }

        // Format message
        function formatMessageText(raw) {
            if (!raw) return '';
            let text = raw;

            // Handle markdown bold **text**
            text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

            // URL links
            text = text.replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank" rel="noopener">$1</a>');

            // Linebreaks
            text = text.replace(/\r\n|\r|\n/g, '<br>');

            return text;
        }

        // Process message
        function processUserMessage(message) {
            addMessage(message, 'user');
            showTyping(true);
            isProcessing = true;
            updateSendButton(false);

            fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response error');
                }
                return response.json();
            })
            .then(data => {
                showTyping(false);
                updateSendButton(true);

                if (data.status && data.data && data.data.answer) {
                    addMessage(data.data.answer, 'bot');
                } else {
                    addMessage('Maaf, saya belum menemukan jawaban yang cocok. Silakan hubungi admin Diskominfosantik Kab. Bekasi. 🙏', 'bot');
                }
                isProcessing = false;
            })
            .catch(error => {
                showTyping(false);
                updateSendButton(true);
                addMessage('Maaf, terjadi gangguan jaringan. Silakan coba kembali sesaat lagi. 😊', 'bot');
                isProcessing = false;
                console.error('Chatbot Error:', error);
            });
        }

        // Add message bubble
        function addMessage(text, sender) {
            const container = document.getElementById('chatbotMessages');
            const messageDiv = document.createElement('div');
            messageDiv.className = `chat-message ${sender}`;

            const time = new Date().toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });

            const formatted = formatMessageText(text);

            if (sender === 'bot') {
                messageDiv.innerHTML = `
                    <div class="chat-msg-avatar bot-msg-avatar">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="message-wrapper">
                        <div class="message-content">
                            ${formatted}
                        </div>
                        <div class="message-time">${time}</div>
                    </div>
                `;
            } else {
                messageDiv.innerHTML = `
                    <div class="message-wrapper">
                        <div class="message-content">
                            ${formatted}
                        </div>
                        <div class="message-time">${time}</div>
                    </div>
                    <div class="chat-msg-avatar user-msg-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                `;
            }

            container.appendChild(messageDiv);
            scrollToBottom(container);
        }

        // Show/hide typing
        function showTyping(show) {
            const typing = document.getElementById('typingIndicator');
            const container = document.getElementById('chatbotMessages');
            if (show) {
                typing.classList.add('active');
                scrollToBottom(container);
            } else {
                typing.classList.remove('active');
            }
        }

        // Update send button state
        function updateSendButton(enabled) {
            const btn = document.getElementById('sendBtn');
            if (!btn) return;
            if (enabled) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane"></i>';
            } else {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            }
        }

        // Scroll helper
        function scrollToBottom(element) {
            if (!element) return;
            setTimeout(() => {
                element.scrollTop = element.scrollHeight;
            }, 50);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('chatbotInput');
            if (input) input.focus();
        });
    </script>
</body>
</html>