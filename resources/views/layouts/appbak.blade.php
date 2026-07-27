<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title','Dashboard')</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@vite(['resources/css/app.css','resources/js/app.js'])

<style>
body{
    font-family: 'Inter', sans-serif;
    background:#0a0a0a;
    color:#fff;
    margin:0;
}

/* ===== SIDEBAR ===== */
.sidebar{
    position:fixed;
    top:0;
    left:0;
    width:280px;
    height:100vh;
    background:linear-gradient(180deg,#0f0f0f,#0a0a0a);
    border-right:1px solid rgba(255,255,255,.08);
    padding:30px 0;
    transition:all .3s ease;
    overflow-y:auto;
    z-index:100;
}
.sidebar.closed{
    transform:translateX(-100%);
}

/* LOGO */
.logo-section{
    display:flex;
    align-items:center;
    gap:15px;
    padding:0 25px 25px;
    border-bottom:1px solid rgba(255,255,255,.08);
}
.logo-icon{
    width:48px;
    height:48px;
    border-radius:14px;
    background:linear-gradient(135deg,#667eea,#764ba2);
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
}
.logo-text h5{
    margin:0;
    font-weight:700;
}
.logo-text small{
    color:#888;
}

/* NAV */
.nav-section{
    padding:25px 0;
}
.nav-label{
    padding:0 25px;
    font-size:11px;
    color:#666;
    text-transform:uppercase;
    margin-bottom:10px;
}
.nav-item, .dropbtn{
    display:flex;
    align-items:center;
    gap:12px;
    padding:14px 25px;
    color:#aaa;
    text-decoration:none;
    background:none;
    border:none;
    width:100%;
    cursor:pointer;
    border-radius:10px;
    margin:4px 15px;
}
.nav-item:hover, .dropbtn:hover{
    background:rgba(255,255,255,.05);
    color:#fff;
}
.dropdown-content{
    display:none;
    margin-left:40px;
}
.dropdown-content a{
    display:block;
    padding:10px 0;
    color:#aaa;
    text-decoration:none;
}
.dropdown-content a:hover{
    color:#fff;
}
.dropdown-content.show{
    display:block;
}

/* ===== MAIN CONTENT ===== */
.main-content{
    margin-left:280px;
    min-height:100vh;
    transition:.3s;
}
.sidebar.closed + .main-content{
    margin-left:0;
}

/* ===== TOPBAR ===== */
.topbar{
    position:sticky;
    top:0;
    z-index:50;
    background:rgba(15,15,15,.85);
    backdrop-filter:blur(20px);
    border-bottom:1px solid rgba(255,255,255,.08);
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.topbar-right{
    display:flex;
    align-items:center;
    gap:20px;
}

/* ICON BUTTON */
.icon-btn{
    width:42px;
    height:42px;
    border-radius:10px;
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.1);
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    cursor:pointer;
}

/* CONTENT */
.page-content{
    padding:30px;
}

/* RESPONSIVE */
@media(max-width:992px){
    .sidebar{
        transform:translateX(-100%);
    }
    .main-content{
        margin-left:0;
    }
}
</style>
</head>

<body>

<!-- ================= SIDEBAR ================= -->
<div class="sidebar" id="sidebar">

<div class="logo-section">
    <div class="logo-icon">TR</div>
    <div class="logo-text">
        <h5>TechRent Pro</h5>
        <small>Admin Panel</small>
    </div>
</div>

<div class="nav-section">
<div class="nav-label">Main</div>

<a class="nav-item" href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('userinfo.userdashboard') }}">
    <i class="fa fa-home"></i> Dashboard
</a>

<a class="nav-item" href="{{ route('userinfo.index') }}">
    <i class="fa fa-users"></i> Users
</a>

<button class="dropbtn" onclick="toggleDropdown('ictMenu')">
    <i class="fa fa-laptop"></i> ICT Equipment
</button>
<div class="dropdown-content" id="ictMenu">
    <a href="{{ route('loan.index') }}">Loan / Return</a>
    <a href="{{ route('equipment.index') }}">Loan Report</a>
</div>

<a class="nav-item" href="{{ route('userinfo.datatable') }}">
    <i class="fa fa-table"></i> Datatable
</a>

<a class="nav-item" href="{{ route('settings.role') }}">
    <i class="fa fa-lock"></i> Role & User
</a>
</div>

<div class="nav-section">
<div class="nav-label">Reports</div>

<button class="dropbtn" onclick="toggleDropdown('reportMenu')">
    <i class="fa fa-chart-line"></i> Reports
</button>
<div class="dropdown-content" id="reportMenu">
    <a href="{{ route('user.reportuser') }}">User</a>
    <a href="{{ route('loan.reportloan') }}">Loan</a>
    <a href="{{ route('activity.userlogs',['id'=>Auth::id()]) }}">Logs</a>
</div>
</div>

</div>

<!-- ================= MAIN ================= -->
<div class="main-content">

<!-- ===== TOPBAR ===== -->
<div class="topbar">
<button class="icon-btn" onclick="toggleSidebar()">
    <i class="fa fa-bars"></i>
</button>

<div class="topbar-right">

<!-- Notification -->
<div class="dropdown">
<a class="icon-btn position-relative" data-bs-toggle="dropdown">
    <i class="fa fa-bell"></i>
    @if(isset($topbarUnread) && $topbarUnread > 0)
    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
        {{ $topbarUnread }}
    </span>
    @endif
</a>
<ul class="dropdown-menu dropdown-menu-end" id="notifList" style="width:300px"></ul>
</div>

<!-- User -->
<div class="dropdown">
<a class="icon-btn dropdown-toggle" data-bs-toggle="dropdown">
    {{ Auth::user()->name }}
</a>
<ul class="dropdown-menu dropdown-menu-end">
    <li><a class="dropdown-item" href="{{ route('userinfo.userprofile',['id'=>Auth::id()]) }}">Profile</a></li>
    <li><a class="dropdown-item" href="{{ route('settings.index') }}">Settings</a></li>
    <li><hr class="dropdown-divider"></li>
    <li>
        <a class="dropdown-item text-danger"
           href="{{ route('logout') }}"
           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
           Logout
        </a>
        <form id="logout-form" method="POST" action="{{ route('logout') }}">@csrf</form>
    </li>
</ul>
</div>

</div>
</div>

<!-- ===== PAGE CONTENT ===== -->
<div class="page-content">
@yield('content')
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleSidebar(){
    document.getElementById('sidebar').classList.toggle('closed');
}
function toggleDropdown(id){
    document.getElementById(id).classList.toggle('show');
}
</script>

</body>
</html>
