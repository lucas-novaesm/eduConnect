<?php
if (!isset($_SESSION)) session_start();
require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/../includes/conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat de Dúvidas - EduConnect</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/dark-theme.css">
    <link rel="stylesheet" href="../css/chat.css">
    <link rel="stylesheet" href="../css/chat-fix.css">
    <link rel="stylesheet" href="../css/critical-fixes.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php include_once('../includes/header.php'); ?>

    <main class="container">
        <div class="page-header">
            <h1>Chat de Dúvidas</h1>
            <p>Tire suas dúvidas com nosso sistema de atendimento</p>
        </div>

        <div class="chat-container">
            <div class="chat-header">
                <div class="chat-avatar">
                    <img src="https://api.dicebear.com/7.x/bottts/svg?seed=educonnect&backgroundColor=084F55" alt="EduConnect Assistant">
                    <span class="status-badge"></span>
                </div>
                <div class="chat-info">
                    <h3>Assistente EduConnect</h3>
                    <span class="status-text">Online</span>
                </div>

            </div>

            <div class="chat-messages" id="chat-messages"></div>

            <div class="quick-replies">
                <button onclick="sendQuickReply('Como ver minhas aulas?')">
                    <i class='bx bx-calendar'></i>
                    Como ver minhas aulas?
                </button>
                <button onclick="sendQuickReply('Como acessar o calendário?')">
                    <i class='bx bx-calendar-check'></i>
                    Como acessar o calendário?
                </button>
                <button onclick="sendQuickReply('Como ver meu perfil?')">
                    <i class='bx bx-user'></i>
                    Como ver meu perfil?
                </button>
            </div>

            <div class="chat-input-container">
                <button class="emoji-btn" title="Adicionar emoji">
                    <i class='bx bx-smile'></i>
                </button>
                <input type="text" id="chat-input" placeholder="Digite sua mensagem..." onkeypress="if(event.key === 'Enter') sendMessage()">
                <button class="attach-btn" title="Anexar arquivo">
                    <i class='bx bx-paperclip'></i>
                </button>
                <button class="send-btn" onclick="sendMessage()" title="Enviar mensagem">
                    <i class='bx bx-send'></i>
                </button>
            </div>
        </div>

        <button id="chat-float-btn" onclick="toggleChatWindow()" title="Abrir chat">
            <i class='bx bx-message-dots'></i>
        </button>
    </main>

    <style>
    /* Estilos diretos para o campo de mensagem */
    #chat-input {
        background-color: #333333 !important;
        border: 2px solid #5c5c5c !important;
        color: white !important;
        padding: 12px 15px !important;
        font-size: 15px !important;
        border-radius: 8px !important;
    }
    
    #chat-input:focus {
        border-color: #00E6F0 !important;
        background-color: #404040 !important;
        box-shadow: 0 0 0 2px rgba(0, 230, 240, 0.3) !important;
        outline: none !important;
    }
    
    #chat-input::placeholder {
        color: #DDDDDD !important;
        opacity: 1 !important;
    }
    
    .chat-input-container {
        background-color: transparent !important;
    }
    
    /* Correção para mensagens do bot */
    .message-content {
        background-color: #f0f0f0 !important;
    }
    
    .message-text {
        color: #333333 !important;
    }
    
    .chat-message.sent .message-content {
        background-color: #2563eb !important;
    }
    
    .chat-message.sent .message-text {
        color: white !important;
    }
    
    .message-author {
        color: #333333 !important;
        font-weight: bold !important;
    }
    
    .chat-message.sent .message-author {
        color: white !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatMessages = document.getElementById('chat-messages');
        const chatInput = document.getElementById('chat-input');
        const chatContainer = document.querySelector('.chat-container');
        let isTyping = false;

        // Mensagem inicial do sistema
        setTimeout(() => {
            addMessage('Assistente EduConnect', 'Olá! Como posso ajudar você hoje? Você pode selecionar uma das opções abaixo ou digitar sua dúvida.', 'received', true);
        }, 500);

        window.sendMessage = function() {
            const message = chatInput.value.trim();
            if (message) {
                addMessage('Você', message, 'sent');
                chatInput.value = '';
                showTypingIndicator();
                
                // Simula resposta do sistema
                setTimeout(() => {
                    hideTypingIndicator();
                    const response = getAutomaticResponse(message);
                    addMessage('Assistente EduConnect', response, 'received');
                }, 2000);
            }
        }

        window.sendQuickReply = function(message) {
            addMessage('Você', message, 'sent');
            showTypingIndicator();
            
            setTimeout(() => {
                hideTypingIndicator();
                const response = getAutomaticResponse(message);
                addMessage('Assistente EduConnect', response, 'received');
            }, 1500);
        }

        function addMessage(author, content, type, isFirstMessage = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `chat-message ${type}`;
            
            if (type === 'received') {
                const avatarDiv = document.createElement('div');
                avatarDiv.className = 'message-avatar';
                avatarDiv.innerHTML = '<img src="https://api.dicebear.com/7.x/bottts/svg?seed=educonnect&backgroundColor=084F55" alt="Bot">';
                messageDiv.appendChild(avatarDiv);
            }
            
            const messageContent = document.createElement('div');
            messageContent.className = 'message-content';
            
            const authorDiv = document.createElement('div');
            authorDiv.className = 'message-author';
            authorDiv.textContent = author;
            
            const textDiv = document.createElement('div');
            textDiv.className = 'message-text';
            textDiv.innerHTML = content;
            
            const timeDiv = document.createElement('div');
            timeDiv.className = 'message-time';
            timeDiv.textContent = new Date().toLocaleTimeString();
            
            messageContent.appendChild(authorDiv);
            messageContent.appendChild(textDiv);
            messageContent.appendChild(timeDiv);
            
            messageDiv.appendChild(messageContent);
            
            // Adiciona com fade-in
            messageDiv.style.opacity = '0';
            chatMessages.appendChild(messageDiv);
            
            requestAnimationFrame(() => {
                messageDiv.style.opacity = '1';
                messageDiv.style.transform = 'translateY(0)';
            });
            
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function showTypingIndicator() {
            if (!isTyping) {
                isTyping = true;
                const typingDiv = document.createElement('div');
                typingDiv.className = 'typing-indicator';
                typingDiv.innerHTML = `
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                `;
                chatMessages.appendChild(typingDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        }

        function hideTypingIndicator() {
            const typingIndicator = document.querySelector('.typing-indicator');
            if (typingIndicator) {
                typingIndicator.remove();
                isTyping = false;
            }
        }

        function getAutomaticResponse(message) {
            const responses = {
                'Como ver minhas aulas?': 'Para ver suas aulas, acesse o Calendário clicando <a href="./calendario.php">aqui</a>. Lá você encontrará todas as suas aulas organizadas por data, podendo visualizar detalhes, remarcar ou cancelar.',
                'Como acessar o calendário?': 'O calendário pode ser acessado clicando <a href="./calendario.php">aqui</a>. Nele você pode ver todas as suas aulas organizadas por data, além de poder agendar novas aulas.',
                'Como ver meu perfil?': 'Seu perfil pode ser acessado clicando no ícone de usuário no canto superior direito. Lá você pode atualizar suas informações pessoais e preferências.'
            };

            return responses[message] || 'Entendi sua mensagem. Como posso ajudar com isso?';
        }

        window.toggleChatWindow = function() {
            chatContainer.classList.toggle('minimized');
            const floatBtn = document.getElementById('chat-float-btn');
            floatBtn.classList.toggle('active');
        }

        // Suporte a emojis e anexos (placeholder para futura implementação)
        document.querySelector('.emoji-btn').addEventListener('click', () => {
            alert('Suporte a emojis será implementado em breve!');
        });

        document.querySelector('.attach-btn').addEventListener('click', () => {
            alert('Suporte a anexos será implementado em breve!');
        });
    });
    </script>
<?php include_once(__DIR__ . "/../includes/footer.php"); ?>
</body>
</html>
