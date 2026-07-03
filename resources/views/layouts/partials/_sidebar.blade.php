<!-- Sidebar -->
<aside id="sidebarMenu" class="iibs-sidebar">
    <div class="sidebar-inner">
        <nav class="sidebar-nav">

            @hasanyrole('secretaire|medecin|responsable_prestation')
                <!-- Dashboard (vrai : Statistics) -->
                <a
                    class="sidebar-link {{ Request::routeIs('statistics.index') ? 'active' : '' }}"
                    href="{{ route('statistics.index') }}"
                >
                    <span class="sidebar-icon">📊</span>
                    <span>Tableau de Bord</span>
                    @if(Request::routeIs('statistics.index'))
                        <span class="active-indicator"></span>
                    @endif
                </a>
            @endhasanyrole


            <!-- Patient Section -->
            @role('patient')
                <div class="sidebar-section">Espace Patient</div>
                <a class="sidebar-link {{ Request::routeIs('patient.rv.create') ? 'active' : '' }}" href="{{ route('patient.rv.create') }}">
                    <span class="sidebar-icon">📅</span>
                    <span>Prendre un RDV</span>
                    @if(Request::routeIs('patient.rv.create'))
                        <span class="active-indicator"></span>
                    @endif
                </a>
                <a class="sidebar-link {{ Request::routeIs('patient.dashboard') ? 'active' : '' }}" href="{{ route('patient.dashboard') }}">
                    <span class="sidebar-icon">📋</span>
                    <span>Mes Rendez-vous</span>
                    @if(Request::routeIs('patient.dashboard'))
                        <span class="active-indicator"></span>
                    @endif
                </a>
            @endrole

            <!-- Secretary Section -->
            @role('secretaire')
                <div class="sidebar-section">Secrétariat</div>
                <a class="sidebar-link {{ Request::routeIs('secretaire.dashboard') ? 'active' : '' }}" href="{{ route('secretaire.dashboard') }}">
                    <span class="sidebar-icon">✅</span>
                    <span>Valider les RDV</span>
                    @if(Request::routeIs('secretaire.dashboard'))
                        <span class="active-indicator"></span>
                    @endif
                </a>
                <a class="sidebar-link {{ Request::routeIs('secretaire.statistics') ? 'active' : '' }}" href="{{ route('secretaire.statistics') }}">
                    <span class="sidebar-icon">📈</span>
                    <span>Statistiques</span>
                    @if(Request::routeIs('secretaire.statistics'))
                        <span class="active-indicator"></span>
                    @endif
                </a>
            @endrole

            <!-- Doctor Section -->
            @role('medecin')
                <div class="sidebar-section">Espace Médecin</div>
                <a class="sidebar-link {{ Request::routeIs('medecin.dashboard') ? 'active' : '' }}" href="{{ route('medecin.dashboard') }}">
                    <span class="sidebar-icon">🩺</span>
                    <span>Mes Consultations</span>
                    @if(Request::routeIs('medecin.dashboard'))
                        <span class="active-indicator"></span>
                    @endif
                </a>
                <a class="sidebar-link {{ Request::routeIs('medecin.patient.search') ? 'active' : '' }}" href="{{ route('medecin.patient.search') }}">
                    <span class="sidebar-icon">🔍</span>
                    <span>Rechercher Patient</span>
                    @if(Request::routeIs('medecin.patient.search'))
                        <span class="active-indicator"></span>
                    @endif
                </a>
            @endrole

            <!-- Service Manager Section -->
            @role('responsable_prestation')
                <div class="sidebar-section">Gestion Prestations</div>
                <a class="sidebar-link {{ Request::routeIs('responsable.dashboard') ? 'active' : '' }}" href="{{ route('responsable.dashboard') }}">
                    <span class="sidebar-icon">🔬</span>
                    <span>Liste Prestations</span>
                    @if(Request::routeIs('responsable.dashboard'))
                        <span class="active-indicator"></span>
                    @endif
                </a>
            @endrole

            <!-- Reports Section -->
            @hasanyrole('secretaire|medecin')
                <div class="sidebar-section">Rapports</div>
                <a class="sidebar-link {{ Request::routeIs('statistics.index') ? 'active' : '' }}" href="{{ route('statistics.index') }}">
                    <span class="sidebar-icon">📄</span>
                    <span>Rapports du Jour</span>
                    @if(Request::routeIs('statistics.index'))
                        <span class="active-indicator"></span>
                    @endif
                </a>
            @endhasanyrole
        </nav>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <div class="sidebar-footer-icon">🏥</div>
            <span>Clinique IIBS</span>
            <small>© {{ date('Y') }}</small>
        </div>
    </div>
</aside>

<!-- Overlay pour mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<style>
    :root {
        --sidebar-width: 260px;
        --topbar-height: 64px;
    }

    /* ========== SIDEBAR ========== */
    .iibs-sidebar {
        position: fixed;
        top: var(--topbar-height);
        left: 0;
        bottom: 0;
        width: var(--sidebar-width);
        background: white;
        border-right: 1px solid rgba(94, 168, 167, 0.12);
        z-index: 1020;
        overflow-y: auto;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
    }

    .sidebar-inner {
        display: flex;
        flex-direction: column;
        height: 100%;
        padding: 16px 0;
    }

    .sidebar-nav {
        flex: 1;
        padding: 0 14px;
    }

    .sidebar-section {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #A0BCC8;
        padding: 20px 12px 8px;
        margin-top: 4px;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 14px;
        border-radius: 12px;
        text-decoration: none;
        color: #5A7A8A;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 2px;
        position: relative;
        transition: all 0.2s ease;
    }

    .sidebar-link:hover {
        background: var(--med-mint);
        color: var(--med-dark);
    }

    .sidebar-link.active {
        background: linear-gradient(135deg, rgba(59, 130, 181, 0.1) 0%, rgba(94, 168, 167, 0.1) 100%);
        color: var(--med-teal);
        font-weight: 600;
    }

    .sidebar-icon {
        font-size: 18px;
        width: 24px;
        text-align: center;
        flex-shrink: 0;
    }

    .active-indicator {
        position: absolute;
        right: -14px;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 24px;
        background: var(--med-teal);
        border-radius: 3px 0 0 3px;
    }

    .sidebar-footer {
        padding: 20px 14px 10px;
        text-align: center;
        border-top: 1px solid rgba(94, 168, 167, 0.1);
        margin-top: auto;
        color: #A0BCC8;
        font-size: 12px;
        font-weight: 500;
    }

    .sidebar-footer-icon {
        font-size: 20px;
        margin-bottom: 4px;
    }

    .sidebar-footer small {
        display: block;
        font-size: 10px;
        color: #C0D4DD;
        margin-top: 2px;
    }

    /* Overlay mobile */
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(26, 60, 74, 0.4);
        z-index: 1015;
        backdrop-filter: blur(2px);
    }

    .sidebar-overlay.show {
        display: block;
    }

    /* Contenu principal */
    .main-content {
        margin-left: var(--sidebar-width);
        margin-top: var(--topbar-height);
        min-height: calc(100vh - var(--topbar-height));
        background: #F5F9FB;
        padding: 32px;
        transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 767.98px) {
        .iibs-sidebar {
            width: min(var(--sidebar-width), 86vw);
            transform: translateX(-100%);
        }

        .iibs-sidebar.open {
            transform: translateX(0);
            box-shadow: 20px 0 60px rgba(26, 60, 74, 0.2);
        }

        .main-content {
            margin-left: 0;
            padding: 16px;
        }
    }

    /* Scrollbar sidebar */
    .iibs-sidebar::-webkit-scrollbar {
        width: 4px;
    }

    .iibs-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    .iibs-sidebar::-webkit-scrollbar-thumb {
        background: rgba(94, 168, 167, 0.2);
        border-radius: 4px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebarMenu');
        const overlay = document.getElementById('sidebarOverlay');
        const body = document.body;

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('show');
            body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
            body.style.overflow = '';
        }

        toggleBtn?.addEventListener('click', function() {
            if (sidebar.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });

        overlay?.addEventListener('click', closeSidebar);

        // Fermer au clic sur un lien (mobile)
        sidebar?.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    closeSidebar();
                }
            });
        });
    });
</script>
