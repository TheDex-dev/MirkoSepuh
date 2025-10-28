<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Electronic Medical Record (EMR)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --primary-color: #1a71ceff;
        --secondary-color: #6c757d;
        --bg-light: #f8f9fa;
        --bg-body: #eef2f7;
        --border-color: #dee2e6;
        --text-dark: #343a40;
        --text-light: #6c757d;
        --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        --border-radius: 0.5rem;
        --sidebar-width: 280px;
    }
    body {
        font-family: 'Poppins', sans-serif;
        background-color: var(--bg-body);
        color: var(--text-dark);
    }
    .header {
        background-color: #fff;
        padding: 10px 25px;
        z-index: 101;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        border-bottom: 1px solid var(--border-color);
        height: 65px;
    }
    .sidebar {
        background-color: #fff;
        height: calc(100vh - 65px);
        position: fixed;
        left: 0;
        top: 65px;
        width: var(--sidebar-width);
        overflow-y: auto;
        overflow-x: hidden;
        padding: 15px;
        border-right: 1px solid var(--border-color);
        z-index: 100;
        transition: transform 0.3s ease-in-out, width 0.3s ease-in-out;
        scrollbar-width: thin;
        scrollbar-color: #888 #f1f1f1;
    }
    .sidebar::-webkit-scrollbar {
        width: 6px;
    }
    .sidebar::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .sidebar::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }
    .sidebar::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    .sidebar.collapsed {
        transform: translateX(calc(-1 * var(--sidebar-width)));
    }
    .sidebar-toggle {
        position: fixed;
        left: var(--sidebar-width);
        top: 75px;
        z-index: 102;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 0 0.25rem 0.25rem 0;
        padding: 8px 10px;
        cursor: pointer;
        box-shadow: 2px 2px 8px rgba(0,0,0,0.2);
        transition: left 0.3s ease-in-out;
    }
    .sidebar-toggle:hover {
        background-color: #155a9e;
    }
    .sidebar-toggle.collapsed {
        left: 0;
    }
    .sidebar-overlay {
        position: fixed;
        top: 65px;
        left: 0;
        width: 100%;
        height: calc(100vh - 65px);
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 99;
        display: none;
        transition: opacity 0.3s ease-in-out;
    }
    .sidebar-overlay.active {
        display: block;
    }
    .content {
        margin-left: var(--sidebar-width);
        padding: 85px 25px 25px 25px;
        transition: margin-left 0.3s ease-in-out;
    }
    .content.expanded {
        margin-left: 0;
    }
    .patient-info {
        background-color: var(--bg-light);
        padding: 15px;
        border-radius: var(--border-radius);
        margin-bottom: 15px;
        border: 1px solid var(--border-color);
    }
    .patient-info h5 {
        font-size: 1rem;
        margin-bottom: 10px;
    }
    .patient-info img {
        width: 80px;
        height: 80px;
        object-fit: cover;
    }
    .patient-info table {
        font-size: 0.8rem;
    }
    .section-title {
        font-weight: 600;
        font-size: 0.8rem;
        color: var(--text-dark);
        margin-top: 15px;
        margin-bottom: 8px;
        padding-bottom: 4px;
        border-bottom: 2px solid var(--primary-color);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .vital-signs-table { 
        font-size: 0.8em;
    }
    .vital-signs-table td, .vital-signs-table th {
        padding: 0.4rem;
    }
    .nav-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        color: var(--text-light);
    }
    .nav-tabs .nav-link.active {
        color: var(--primary-color);
        border-color: var(--primary-color);
        background-color: transparent;
    }
    .nav-pills .nav-link.active {
        color: #fff;
        background-color: var(--primary-color);
    }
    .card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
    }
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid var(--border-color);
    }
    @media (max-width: 992px) {
        :root {
            --sidebar-width: 280px;
        }
        .sidebar { 
            transform: translateX(calc(-1 * var(--sidebar-width)));
        }
        .sidebar.mobile-open {
            transform: translateX(0);
        }
        .sidebar-toggle {
            left: 0;
        }
        .sidebar-toggle.mobile-open {
            left: var(--sidebar-width);
        }
        .content { 
            margin-left: 0;
            padding: 85px 15px 15px 15px;
        }
    }
    @media (max-width: 576px) {
        :root {
            --sidebar-width: 100%;
        }
        .sidebar-toggle {
            top: 70px;
            padding: 6px 8px;
            font-size: 0.9rem;
        }
    }
    #subTabs.nav-pills .nav-link {
            border-radius: 0.5rem 0.5rem 0 0 !important;
            background-color: #eef2f7;
            color: var(--text-light);
            border-bottom: none;
        }
        #subTabs.nav-pills .nav-link.active {
            background-color: #f8f9fa;
            color: var(--primary-color);
            font-weight: 500;
            margin-bottom: -1px;
        }
        #subTabs.nav-pills {
            margin-bottom: 0 !important;
        }
        #subTabContents .card {
            border-top-left-radius: 0;
        }
</style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img src="https://via.placeholder.com/40" alt="Logo" class="mr-3">
            <span>Electronic Medical Record (EMR)</span>
        </div>
        <div class="text-right">
            <small>Welcome, <strong>Dr. Smith</strong></small>
        </div>
    </div>

    <div class="d-flex flex-wrap flex-lg-nowrap">
        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
        
        <!-- Sidebar Toggle Button -->
        <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()">
            <i class="fas fa-chevron-left"></i>
        </button>
        
        <div class="sidebar" id="sidebar">
            <div class="patient-info text-center">
                <h5 class="mb-2">{{ strtoupper($patient->name ?? 'N/A') }}</h5>
                <img src="https://static.vecteezy.com/system/resources/thumbnails/026/375/249/small_2x/ai-generative-portrait-of-confident-male-doctor-in-white-coat-and-stethoscope-standing-with-arms-crossed-and-looking-at-camera-photo.jpg" alt="Patient Photo" class="img-thumbnail mb-2">
                <table class="table table-sm table-borderless text-left mt-2" style="font-size: 0.75rem;">
                    <tr><td><strong>MRN</strong></td><td>: {{ $patient->mrn ?? '-' }}</td></tr>
                    <tr><td><strong>Reg. No</strong></td><td>: {{ $patient->reg_no ?? '-' }}</td></tr>
                    <tr><td><strong>Reg. Date</strong></td><td>: {{ $patient->reg_date ? \Carbon\Carbon::parse($patient->reg_date)->format('d-M-Y') : '-' }}</td></tr>
                    <tr><td><strong>Gender</strong></td><td>: {{ $patient->gender ?? '-' }}</td></tr>
                    <tr><td><strong>DOB</strong></td><td>: {{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('d-M-Y') : '-' }} ({{ $age }})</td></tr>
                    <tr><td><strong>Guarantor</strong></td><td>: {{ $patient->guarantor ?? '-' }}</td></tr>
                    <tr><td><strong>Unit</strong></td><td>: {{ $patient->unit ?? '-' }}</td></tr>
                    <tr><td><strong>Physician</strong></td><td>: {{ $patient->physician ?? '-' }}</td></tr>
                </table>
            </div>

            <div class="section-title">Billing Summary</div>
            <div class="p-2" style="font-size: 0.85rem;">
                <strong>Plafond :</strong> <span class="float-right">{{ number_format($billing['plafond'], 2) }}</span><br>
                <strong>Billing :</strong> <span class="float-right">{{ number_format($billing['total'], 2) }}</span><br>
                <strong>Selisih :</strong> <span class="float-right {{ $billing['selisih'] < 0 ? 'text-danger' : 'text-success' }}">{{ number_format($billing['selisih'], 2) }}</span>
            </div>

            <div class="section-title">Allergies</div>
            <div class="p-2 text-muted" style="font-size: 0.85rem;">- None recorded</div>

            <div class="section-title">Diagnosis</div>
            <div class="p-2 text-muted" style="font-size: 0.85rem;">- No diagnosis recorded</div>

            <div class="section-title">Vital Signs</div>
            <table class="table table-sm vital-signs-table">
                <thead>
                    <tr><th>Vital</th><th>Value</th><th>Time</th><th></th></tr>
                </thead>
                <tbody>
                    @if(count($vitalSigns) > 0)
                        @foreach($vitalSigns as $vital)
                        <tr>
                            <td>{{ $vital->name }}</td>
                            <td>{{ $vital->value }} {{ $vital->unit }}</td>
                            <td>{{ $vital->time ? \Carbon\Carbon::parse($vital->time)->format('H:i') : '-' }}</td>
                            <td>
                                <i class="fas fa-chart-line text-success"></i> 
                                <i class="fas fa-edit text-primary ml-1"></i>
                            </td>
                        </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="4" class="text-center text-muted">No vital signs recorded</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            
        </div>

        <div class="content flex-grow-1">
            <ul class="nav nav-tabs" id="mainTabs" role="tablist">
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#integrated-notes">Integrated Notes</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#medication">Medication</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#surgical-history">Surgical History</a></li>
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#exam-order">Exam Order</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#health-record">Health Record</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#care-plan">Care Plan</a></li>
            </ul>

            <div class="tab-content mt-4" id="mainTabContent">
                <div class="tab-pane fade show active" id="exam-order" role="tabpanel">
                    <ul class="nav nav-pills mb-3" id="subTabs" role="tablist">
                        <li class="nav-item mr-1"><a class="nav-link active" id="laboratory-tab" data-toggle="tab" href="#laboratory">Laboratory</a></li>
                        <li class="nav-item mr-1"><a class="nav-link" id="radiology-tab" data-toggle="tab" href="#radiology">Radiology</a></li>
                        <li class="nav-item mr-1"><a class="nav-link" id="pathology-tab" data-toggle="tab" href="#pathology">Pathology</a></li>
                        <li class="nav-item mr-1"><a class="nav-link" id="diagnostic-tab" data-toggle="tab" href="#diagnostic">Diagnostic</a></li>
                        <li class="nav-item"><a class="nav-link" id="other-tab" data-toggle="tab" href="#other">Other</a></li>
                    </ul>

                    <div class="tab-content" id="subTabContents">
                        <div class="tab-pane fade show active" id="laboratory" role="tabpanel">
                            <div class="card">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6>Laboratory Orders</h6>
                                    <div>
                                        <button class="btn btn-sm btn-outline-success mr-2" onclick="openLabInNewTab()"><i class="fas fa-external-link-alt"></i> Open</button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div id="lab-iframe-container" class="iframe-container position-relative">
                                            <iframe id="lab-iframe"
                                                    src="{{ route('laboratory', ['reg_no' => str_replace('/', '+', $patient->reg_no)]) }}"
                                                    frameborder="0"
                                                    style="width: 100%; height: 80vh; border: none; display: none;"
                                                    onload="this.style.display='block'"
                                                    onerror="handleIframeError('lab-iframe', 'lab-error')">
                                            </iframe>                                        <div class="iframe-error text-center py-5 d-none" id="lab-error">
                                            <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                                            <h5>Unable to Load System</h5>
                                            <p class="text-muted">Please contact system administrator.</p>
                                            <button class="btn btn-primary" onclick="retryLabIframe()"><i class="fas fa-redo"></i> Retry</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="radiology" role="tabpanel">
                            <div class="card">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6>Radiology and Imaging Orders</h6>
                                    <div>
                                        <button class="btn btn-sm btn-outline-success mr-2" onclick="openRadInNewTab()"><i class="fas fa-external-link-alt"></i> Open</button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div id="radiology-iframe-container" class="iframe-container position-relative">
                                            <iframe id="rad-iframe"
                                                    src="{{ route('radiology.imaging', ['reg_no' => str_replace('/', '+', $patient->reg_no)]) }}"
                                                    frameborder="0"
                                                    style="width: 100%; height: 80vh; border: none; display: none;"
                                                    onload="this.style.display='block'"
                                                    onerror="handleIframeError('rad-iframe', 'rad-error')">
                                            </iframe>
                                        <div class="iframe-error text-center py-5 d-none" id="rad-error">
                                            <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                                            <h5>Unable to Load System</h5>
                                            <p class="text-muted">Please contact system administrator.</p>
                                            <button class="btn btn-primary" onclick="retryRadIframe()"><i class="fas fa-redo"></i> Retry</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pathology"><div class="card"><div class="card-body">Pathology content here.</div></div></div>
                        <div class="tab-pane fade" id="diagnostic"><div class="card"><div class="card-body">Diagnostic content here.</div></div></div>
                        <div class="tab-pane fade" id="other"><div class="card"><div class="card-body">Other content here.</div></div></div>
                    </div>
                </div>

                <div class="tab-pane fade" id="integrated-notes"><div class="card"><div class="card-body">Notes content here.</div></div></div>
                <div class="tab-pane fade" id="medication"><div class="card"><div class="card-body">Medication content here.</div></div></div>
                <div class="tab-pane fade" id="surgical-history"><div class="card"><div class="card-body">Surgical History content here.</div></div></div>
                <div class="tab-pane fade" id="health-record"><div class="card"><div class="card-body">Health Record content here.</div></div></div>
                <div class="tab-pane fade" id="care-plan"><div class="card"><div class="card-body">Care Plan content here.</div></div></div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

<script>
// =================================================================
// Fungsi Toggle Sidebar
// =================================================================
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const content = document.querySelector('.content');
    const icon = sidebarToggle.querySelector('i');
    const isMobile = window.innerWidth <= 992;
    
    // Toggle collapsed class
    sidebar.classList.toggle('collapsed');
    sidebarToggle.classList.toggle('collapsed');
    content.classList.toggle('expanded');
    
    // Toggle mobile open class for mobile devices
    if (isMobile) {
        sidebar.classList.toggle('mobile-open');
        sidebarToggle.classList.toggle('mobile-open');
        sidebarOverlay.classList.toggle('active');
        
        // Prevent body scroll when sidebar is open on mobile
        if (sidebar.classList.contains('mobile-open')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    }
    
    // Change icon direction
    if (sidebar.classList.contains('collapsed')) {
        icon.classList.remove('fa-chevron-left');
        icon.classList.add('fa-chevron-right');
    } else {
        icon.classList.remove('fa-chevron-right');
        icon.classList.add('fa-chevron-left');
    }
    
    // Save state to localStorage (only for desktop)
    if (!isMobile) {
        localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
    }
}

// Restore sidebar state on page load
function restoreSidebarState() {
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    const isMobile = window.innerWidth <= 992;
    
    // On mobile, start collapsed by default
    if (isMobile && !localStorage.getItem('sidebarCollapsed')) {
        toggleSidebar();
    } else if (isCollapsed && !isMobile) {
        toggleSidebar();
    }
}

// Close sidebar when clicking outside on mobile
function handleOutsideClick(event) {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const isMobile = window.innerWidth <= 992;
    
    if (isMobile && 
        sidebar.classList.contains('mobile-open') && 
        !sidebar.contains(event.target) && 
        !sidebarToggle.contains(event.target)) {
        toggleSidebar();
    }
}

// Keyboard shortcut: Ctrl/Cmd + B to toggle sidebar
document.addEventListener('keydown', function(event) {
    if ((event.ctrlKey || event.metaKey) && event.key === 'b') {
        event.preventDefault();
        toggleSidebar();
    }
});

// =================================================================
// Fungsi Pemuatan Iframe
// =================================================================
function loadIframe(iframeId, errorId) {
    const iframe = document.getElementById(iframeId);
    const error = document.getElementById(errorId);
    if (!iframe || !error) {
        console.error("Fatal Error: Iframe or Error element not found.", { iframeId, errorId });
        return;
    }

    // Ambil URL dari atribut data-src
    const url = iframe.getAttribute('src');
    if (!url) {
        console.error(`Fatal Error: Atribut 'data-src' tidak ditemukan pada iframe #${iframeId}`);
        return;
    }
    
    console.log(`Loading URL: ${url} into #${iframeId}`);
    error.classList.add('d-none');
    iframe.style.display = 'block';
    iframe.src = url;
}

function handleIframeError(iframeId, errorId) {
    console.error(`Failed to load iframe #${iframeId}`);
    const iframe = document.getElementById(iframeId);
    const error = document.getElementById(errorId);
    if (iframe) iframe.style.display = 'none';
    if (error) error.classList.remove('d-none');
}

// =================================================================
// Fungsi Spesifik untuk setiap Iframe
// =================================================================
function openLabInNewTab() { window.open(document.getElementById('lab-iframe').getAttribute('src'), '_blank', 'noopener,noreferrer'); }
function retryLabIframe() { refreshLabIframe(); }

function openRadInNewTab() { window.open(document.getElementById('rad-iframe').getAttribute('src'), '_blank', 'noopener,noreferrer'); }
function retryRadIframe() { refreshRadIframe(); }

// =================================================================
// Event Listeners (Bagian Utama)
// =================================================================
$(document).ready(function() {
    // Restore sidebar state from localStorage
    restoreSidebarState();
    
    // Add click outside listener for mobile
    document.addEventListener('click', handleOutsideClick);
    
    // Handle window resize
    let resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            const sidebar = document.getElementById('sidebar');
            const isMobile = window.innerWidth <= 992;
            
            // If transitioning to desktop and sidebar is mobile-open, remove mobile classes
            if (!isMobile && sidebar.classList.contains('mobile-open')) {
                sidebar.classList.remove('mobile-open');
                document.getElementById('sidebarToggle').classList.remove('mobile-open');
            }
        }, 250);
    });
    
    // Fungsi ini akan memeriksa apakah iframe di sebuah tab perlu dimuat
    function loadContentForTab(tabElement) {
        const targetPaneId = $(tabElement).attr('href');
        const iframe = $(targetPaneId).find('iframe')[0];

        // Hanya muat jika ada iframe dan src-nya masih kosong atau 'about:blank'
        if (iframe && (iframe.src.includes('about:blank') || iframe.src === '')) {
            if (iframe.id === 'lab-iframe') {
                refreshLabIframe();
            } else if (iframe.id === 'rad-iframe') {
                refreshRadIframe();
            }
        }
    }

    // Listener untuk saat pengguna meng-klik tab
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        loadContentForTab(e.target);
    });

    // [PEMICU OTOMATIS]
    // Memicu event 'show' pada tab yang sudah aktif dari awal.
    const initiallyActiveTab = $('#subTabs .nav-link.active');
    if (initiallyActiveTab.length > 0) {
        initiallyActiveTab.tab('show');
    }
});
</script>

</body>
</html>