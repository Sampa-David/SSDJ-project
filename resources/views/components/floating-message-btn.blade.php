<!-- Floating Message Button -->
<a href="{{ route('messages.index') }}" class="floating-message-btn" title="Messages">
    <img src="{{ asset('assets/images/message-plane.svg') }}" alt="Messages" class="message-plane-icon">
    <span class="badge badge-notification">
        {{ Auth::user()->unreadConversationsCount() }}
    </span>
</a>

<style>
    .floating-message-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #00B4D8 0%, #0096C7 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 180, 216, 0.4);
        text-decoration: none;
        z-index: 999;
        transition: all 0.3s ease;
    }

    .floating-message-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(0, 180, 216, 0.6);
    }

    .message-plane-icon {
        width: 32px;
        height: 32px;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
    }

    /* Animation de flottement léger */
    @keyframes float-bounce {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-8px);
        }
    }

    .floating-message-btn {
        animation: float-bounce 3s ease-in-out infinite;
    }

    .floating-message-btn:hover {
        animation: none;
    }

    /* Badge de notification */
    .badge-notification {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #FF6B6B;
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        border: 2px solid white;
    }

    /* Responsive - ajuste la position sur mobile */
    @media (max-width: 768px) {
        .floating-message-btn {
            bottom: 20px;
            right: 20px;
            width: 55px;
            height: 55px;
        }

        .message-plane-icon {
            width: 28px;
            height: 28px;
        }
    }
</style>
