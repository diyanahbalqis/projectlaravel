<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title', 'Dashboard') - ICTRent</title>

<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- App CSS -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>
<body>

<!-- ================= SIDEBAR ================= -->
<div class="sidebar" id="sidebar">
    <div class="logo-section">
        <img src="{{ asset('storage/images/ICTRent.png') }}" alt="Logo">
        <p>Admin Panel</p>
    </div>

    <div class="nav-section">
        <div class="nav-label">Main Menu</div>

        <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('userinfo.userdashboard') }}"
           class="nav-item {{ Request::is('admin/dashboard') || Request::is('userinfo/userdashboard') ? 'active' : '' }}">
           <i>🏠</i> Dashboard
        </a>

        <a href="{{ route('userinfo.index') }}"
           class="nav-item {{ Request::is('userinfo') && !Request::is('userinfo/datatable') && !Request::is('userinfo/userdashboard') ? 'active' : '' }}">
           <i class="fa fa-users"></i> Users
        </a>

        <button class="dropbtn" id="ictDropdownBtn">
            <i>💻</i> ICT Equipment <i class="fa fa-caret-down ms-auto"></i>
        </button>
        <div class="dropdown-content" id="ictDropdownMenu">
            <a href="{{ route('loan.index') }}">Loan / Return</a>
            <a href="{{ route('equipment.index') }}">Equipment List</a>
        </div>

        <!-- <a href="{{ route('userinfo.datatable') }}"
           class="nav-item {{ Request::is('userinfo/datatable') ? 'active' : '' }}">
           <i>📊</i> Datatable
        </a> -->

        
    </div>

    <div class="nav-section">
        <div class="nav-label">Reports</div>

        <button class="dropbtn" id="reportDropdownBtn">
            <i>📋</i> Reports <i class="fa fa-caret-down ms-auto"></i>
        </button>
        <div class="dropdown-content" id="reportDropdownMenu">
            <a href="{{ route('user.reportuser') }}">User</a>
            <a href="{{ route('loan.reportloan') }}">Loan</a>
            <a href="{{ route('equipment.reportequipment') }}">Equipment</a>
            <a href="{{ route('activity.userlogs', ['id' => Auth::id()]) }}">View Logs</a>
        </div>
    </div>

    <div class="nav-section">
        <div class="nav-label"> Settings</div>

        <a href="{{ route('settings.index') }}"
           class="nav-item {{ Request::is('settings') && !Request::is('settings/role') ? 'active' : '' }}">
           <i>⚙️</i> Settings
        </a>
        
        <a href="{{ route('settings.role') }}"
           class="nav-item {{ Request::is('settings/role') ? 'active' : '' }}">
           <i>🔐</i> Role & Password
        </a>
    </div>
</div>

<!-- ================= MAIN CONTENT ================= -->
<div class="main-content" id="mainContent">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="search-bar">
            <i class="fa fa-search"></i>
            <input type="text" placeholder="Search anything...">
        </div>

        <div class="topbar-right d-flex align-items-center gap-3">

            <!-- Notifications -->
            <div class="dropdown">
                <a class="notification-btn position-relative" data-bs-toggle="dropdown" href="{{ route('loan.index') }}">
                    <i>🔔</i>
                    <span id="notifBadge" class="notification-badge" style="{{ empty($topbarUnread) ? 'display:none' : '' }}">
                        {{ $topbarUnread ?? 0 }}
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end" id="notifList" style="width:320px">
                    <li class="dropdown-header">Notifications</li>
                    <li><span class="dropdown-item text-muted">Loading...</span></li>
                </ul>
            </div>

            <!-- User Profile -->
            <div class="dropdown">
                <a class="user-profile dropdown-toggle" data-bs-toggle="dropdown" href="{{ route('loan.index') }}">
                    <div class="user-avatar rounded-circle bg-primary text-white d-flex justify-content-center align-items-center" style="width:35px; height:35px;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="user-info ms-2">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">{{ ucfirst(Auth::user()->role ?? 'User') }}</div>
                    </div>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('userinfo.userprofile', Auth::id()) }}">
                            <i class="fa fa-user me-2"></i> Profile
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('settings.index') }}">
                            <i>⚙️</i> Setting
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                           <i class="fa fa-sign-out-alt me-2"></i> Logout
                        </a>
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <!-- CONTENT -->
    <div class="content">
        @yield('content')
    </div>
</div>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Scripts -->
<script>
    // Sidebar dropdown toggle
    function toggleDropdown(btnId, menuId) {
        const btn = document.getElementById(btnId);
        const menu = document.getElementById(menuId);
        if (!btn || !menu) return;

        btn.addEventListener('click', () => {
            menu.style.display = (menu.style.display === 'flex' ? 'none' : 'flex');
            btn.classList.toggle('expanded');
        });
    }

    toggleDropdown('ictDropdownBtn', 'ictDropdownMenu');
    toggleDropdown('reportDropdownBtn', 'reportDropdownMenu');

    // Notifications
    // Event listener for notification clicks (mark as read)
async function fetchNotifications() {
try {
const res = await fetch('{{ route("notifications.fetch") }}');
const data = await res.json();


        const badge = document.getElementById('notifBadge');
        const list = document.getElementById('notifList');

        badge.style.display = data.unreadCount ? 'flex' : 'none';
        badge.textContent = data.unreadCount;

        let html = '<li class="dropdown-header">Notifications</li>';
        if (data.notifications.length) {
            data.notifications.forEach(n => {
                html += `
                    <li>
                        <a href="{{ route('loan.index') }}" class="dropdown-item notif-item" data-id="${n.id}">
                            ${n.title} ${!n.is_read ? '<span class="badge bg-primary ms-2">New</span>' : ''}
                        </a>
                    </li>`;
            });
        } else {
            html += '<li><span class="dropdown-item text-muted">No notifications</span></li>';
        }
        list.innerHTML = html;
    } catch (err) { console.error(err); }
}

    setInterval(fetchNotifications, 5000);
    fetchNotifications();

    
</script>

</body>
</html>
