<nav class="iibs-topbar">
    <div class="topbar-inner">
        <!-- Gauche : Toggle + Marque -->
        <div class="topbar-left">
            <button class="sidebar-toggle" id="sidebarToggle" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <a href="{{ route('dashboard') }}" class="topbar-brand">
                <div class="brand-cross">+</div>
                <span class="brand-text">Clinique <span>IIBS</span></span>
            </a>
        </div>

        <!-- Droite : Utilisateur + Déconnexion -->
        <div class="topbar-right">
            <!-- Infos utilisateur -->
            <div class="user-badge">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="user-meta">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-role">{{ ucfirst(Auth::user()->getRoleNames()->first()) }}</span>
                </div>
            </div>

            <!-- Déconnexion -->
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="btn-logout" title="Déconnexion">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</nav>

<style>
    :root {
        --med-blue: #3B82B5;
        --med-teal: #5EA8A7;
        --med-mint: #E8F4F8;
        --med-dark: #1A3C4A;
        --topbar-height: 64px;
    }

    /* ========== TOPBAR ========== */
    .iibs-topbar {
        position: sticky;
        top: 0;
        z-index: 1030;
        height: var(--topbar-height);
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border-bottom: 1px solid rgba(94, 168, 167, 0.13);
        padding: 0 24px;
    }

    .topbar-inner {
        max-width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* ---- LEFT ---- */
    .topbar-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    /* Toggle hamburger (mobile) */
    .sidebar-toggle {
        display: none;
        flex-direction: column;
        gap: 5px;
        background: none;
        border: none;
        cursor: pointer;
        padding: 8px;
        border-radius: 10px;
        transition: background 0.2s;
    }

    .sidebar-toggle:hover {
        background: var(--med-mint);
    }

    .sidebar-toggle span {
        display: block;
        width: 22px;
        height: 2px;
        background: var(--med-dark);
        border-radius: 2px;
        transition: all 0.3s;
    }

    /* Marque */
    .topbar-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: var(--med-dark);
    }

    .brand-cross {
        width: 37px;
        height: 37px;
        background: linear-gradient(135deg, var(--med-blue) 0%, var(--med-teal) 100%);
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 19px;
        font-weight: 700;
        box-shadow: 0 6px 16px rgba(62, 130, 181, 0.25);
        animation: gentlePulse 3s ease-in-out infinite;
    }

    @keyframes gentlePulse {
        0%, 100% { box-shadow: 0 6px 16px rgba(62, 130, 181, 0.25); }
        50% { box-shadow: 0 6px 24px rgba(62, 130, 181, 0.4); }
    }

    .brand-text {
        font-size: 17px;
        font-weight: 700;
        letter-spacing: -0.3px;
    }

    .brand-text span {
        color: var(--med-teal);
        font-weight: 500;
    }

    /* ---- RIGHT ---- */
    .topbar-right {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    /* Badge utilisateur */
    .user-badge {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #F7FAFC;
        padding: 6px 14px 6px 6px;
        border-radius: 50px;
        border: 1px solid rgba(94, 168, 167, 0.15);
        transition: all 0.25s;
    }

    .user-badge:hover {
        border-color: rgba(94, 168, 167, 0.35);
        box-shadow: 0 2px 12px rgba(94, 168, 167, 0.08);
    }

    .user-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--med-blue) 0%, var(--med-teal) 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        flex-shrink: 0;
    }

    .user-meta {
        display: flex;
        flex-direction: column;
        line-height: 1.3;
    }

    .user-name {
        font-weight: 600;
        font-size: 13px;
        color: var(--med-dark);
    }

    .user-role {
        font-size: 10px;
        color: var(--med-teal);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }

    /* Bouton déconnexion */
    .logout-form {
        margin: 0;
    }

    .btn-logout {
        background: none;
        border: 1px solid rgba(26, 60, 74, 0.12);
        padding: 9px 11px;
        border-radius: 11px;
        cursor: pointer;
        color: #8AA0AD;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.25s;
    }

    .btn-logout:hover {
        background: #FFF3F3;
        border-color: #F5C6CB;
        color: #D9444F;
    }

    /* ========== MOBILE ========== */
    @media (max-width: 767.98px) {
        .sidebar-toggle {
            display: flex;
        }

        .user-meta {
            display: none;
        }

        .user-badge {
            padding: 4px;
            background: transparent;
            border: none;
        }

        .brand-text {
            font-size: 15px;
        }
    }
</style>