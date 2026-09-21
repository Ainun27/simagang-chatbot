<!-- ============================================================ -->
<!-- CHATBOT COMPONENT - SIMAGANG PREMIUM                        -->
<!-- ============================================================ -->

<div class="chatbot-container" id="chatbotContainer">
    <!-- ===== TOGGLE BUTTON & CALLOUT ===== -->
    <div class="chatbot-toggle-wrapper">
        <div class="chatbot-callout" id="chatbotCallout">
            <span>👋 Butuh info magang? Tanya di sini!</span>
        </div>
        <button class="chatbot-toggle" id="chatbotToggle" onclick="toggleChatbot()" aria-label="Buka Chatbot SIMAGANG">
            <i class="fas fa-comment-dots"></i>
            <span class="chatbot-badge" id="chatbotBadge" style="display:none;">
                <span class="badge-text">1</span>
            </span>
            <span class="chatbot-pulse"></span>
        </button>
    </div>

    <!-- ===== POPUP CHAT ===== -->
    <div class="chatbot-popup" id="chatbotPopup" style="display: none;">
        
        <!-- ===== HEADER ===== -->
        <div class="chatbot-header">
            <div class="chatbot-header-left">
                <div class="chatbot-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="chatbot-header-info">
                    <h5>Asisten Virtual</h5>
                    <div class="chatbot-status">
                        <span class="status-dot"></span>
                        <span>Online • Diskominfosantik</span>
                    </div>
                </div>
            </div>
            <div class="chatbot-header-actions">
                <button class="chatbot-action-btn" onclick="clearChatHistory()" title="Bersihkan Percakapan" aria-label="Bersihkan Percakapan">
                    <i class="fas fa-rotate-right"></i>
                </button>
                <button class="chatbot-action-btn" onclick="toggleChatbot()" title="Tutup Chatbot" aria-label="Tutup Chatbot">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- ===== MESSAGES AREA ===== -->
        <div class="chatbot-messages" id="chatbotMessages">
            <!-- Welcome Message -->
            <div class="chat-message bot">
                <div class="chat-msg-avatar bot-msg-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="message-wrapper">
                    <div class="message-content">
                        <div class="message-text">
                            Halo! 👋 Selamat datang di <strong>SIMAGANG Diskominfosantik Kab. Bekasi</strong>.<br><br>
                            Saya siap membantu menjawab pertanyaan seputar program magang, syarat pendaftaran, durasi, sertifikat, atau divisi terkait.
                        </div>
                        <div class="message-time">Sekarang</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Typing Indicator -->
        <div class="chatbot-typing" id="chatbotTyping">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- ===== SUGGESTIONS ===== -->
        <div class="chatbot-suggestions-wrapper">
            <div class="suggestions-title">
                <i class="fas fa-lightbulb"></i> Pertanyaan Cepat
            </div>
            <div class="chatbot-suggestions" id="chatbotSuggestions">
                <button class="suggestion-btn" onclick="sendSuggestion('syarat magang')">
                    <i class="fas fa-clipboard-check"></i> Syarat
                </button>
                <button class="suggestion-btn" onclick="sendSuggestion('alur pendaftaran')">
                    <i class="fas fa-route"></i> Alur Daftar
                </button>
                <button class="suggestion-btn" onclick="sendSuggestion('durasi magang')">
                    <i class="fas fa-calendar-days"></i> Durasi
                </button>
                <button class="suggestion-btn" onclick="sendSuggestion('sertifikat')">
                    <i class="fas fa-award"></i> Sertifikat
                </button>
                <button class="suggestion-btn" onclick="sendSuggestion('divisi yang tersedia')">
                    <i class="fas fa-sitemap"></i> Divisi
                </button>
                <button class="suggestion-btn" onclick="sendSuggestion('alamat kantor')">
                    <i class="fas fa-location-dot"></i> Lokasi
                </button>
                <button class="suggestion-btn" onclick="sendSuggestion('benefit magang')">
                    <i class="fas fa-gift"></i> Benefit
                </button>
            </div>
        </div>

        <!-- ===== INPUT AREA ===== -->
        <div class="chatbot-input-area">
            <div class="chatbot-input-wrapper">
                <input 
                    type="text" 
                    id="chatbotInput" 
                    class="chatbot-input" 
                    placeholder="Tulis pertanyaan Anda di sini..." 
                    onkeypress="handleKeyPress(event)"
                    autocomplete="off"
                >
                <button class="input-send" onclick="sendMessage()" aria-label="Kirim pesan" id="sendBtn">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- JAVASCRIPT CHATBOT                                           -->
<!-- ============================================================ -->
<script>
    const CHATBOT_CONFIG = {
        apiUrl: '{{ url("/api/chatbot/send") }}',
        csrfToken: '{{ csrf_token() }}',
        maxMessageLength: 500
    };

    let isProcessing = false;

    // Toggle popup
    function toggleChatbot() {
        const popup = document.getElementById('chatbotPopup');
        const toggle = document.getElementById('chatbotToggle');
        const badge = document.getElementById('chatbotBadge');
        const callout = document.getElementById('chatbotCallout');

        if (callout) {
            callout.style.display = 'none';
        }

        if (popup.style.display === 'none' || popup.style.display === '') {
            popup.style.display = 'flex';
            toggle.classList.add('active');
            if (badge) badge.style.display = 'none';
            setTimeout(() => {
                const input = document.getElementById('chatbotInput');
                if (input) input.focus();
            }, 300);
        } else {
            popup.style.display = 'none';
            toggle.classList.remove('active');
        }
    }

    // Clear chat history
    function clearChatHistory() {
        const container = document.getElementById('chatbotMessages');
        container.innerHTML = `
            <div class="chat-message bot">
                <div class="chat-msg-avatar bot-msg-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="message-wrapper">
                    <div class="message-content">
                        <div class="message-text">
                            Halo! 👋 Percakapan telah direset. Silakan tanyakan informasi yang Anda butuhkan seputar program magang Diskominfosantik.
                        </div>
                        <div class="message-time">Sekarang</div>
                    </div>
                </div>
            </div>
        `;
    }

    // Send message
    function sendMessage() {
        const input = document.getElementById('chatbotInput');
        const message = input.value.trim();

        if (!message || isProcessing) return;
        if (message.length > CHATBOT_CONFIG.maxMessageLength) {
            addMessage('Pesan terlalu panjang! Maksimal 500 karakter.', 'bot');
            return;
        }

        input.value = '';
        processUserMessage(message);
    }

    // Suggestion click
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

    // Process User Message
    function processUserMessage(message) {
        addMessage(message, 'user');
        showTyping(true);
        isProcessing = true;
        updateSendButton(false);

        fetch(CHATBOT_CONFIG.apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CHATBOT_CONFIG.csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            showTyping(false);
            updateSendButton(true);

            if (data.status && data.data && data.data.answer) {
                addMessage(data.data.answer, 'bot');
            } else {
                addMessage('Maaf, saya tidak menemukan jawaban yang tepat. Silakan hubungi admin di Diskominfosantik Kab. Bekasi. 🙏', 'bot');
            }
            isProcessing = false;
        })
        .catch(error => {
            showTyping(false);
            updateSendButton(true);
            addMessage('Maaf, terjadi kendala saat menghubungkan ke server. Silakan coba kembali sesaat lagi. 😊', 'bot');
            isProcessing = false;
            console.error('Chatbot Error:', error);
        });
    }

    // Format text (markdown & links)
    function formatMessageText(raw) {
        if (!raw) return '';
        let text = raw;

        // Bold formatting **text**
        text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

        // URL formatting
        text = text.replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank" rel="noopener">$1</a>');

        // Line breaks
        text = text.replace(/\r\n|\r|\n/g, '<br>');

        return text;
    }

    // Add message element
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
                        <div class="message-text">${formatted}</div>
                        <div class="message-time">${time}</div>
                    </div>
                </div>
            `;
        } else {
            messageDiv.innerHTML = `
                <div class="message-wrapper">
                    <div class="message-content">
                        <div class="message-text">${formatted}</div>
                        <div class="message-time">${time}</div>
                    </div>
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
        const typing = document.getElementById('chatbotTyping');
        const messages = document.getElementById('chatbotMessages');
        if (show) {
            typing.classList.add('active');
            scrollToBottom(messages);
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

    // ESC to close
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const popup = document.getElementById('chatbotPopup');
            if (popup && popup.style.display !== 'none') {
                toggleChatbot();
            }
        }
    });

    // Dismiss callout after 8 seconds
    setTimeout(() => {
        const callout = document.getElementById('chatbotCallout');
        if (callout) {
            callout.style.transition = 'opacity 0.5s ease';
            callout.style.opacity = '0';
            setTimeout(() => { callout.style.display = 'none'; }, 500);
        }
    }, 8000);
</script>