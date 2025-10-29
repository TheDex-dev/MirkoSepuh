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
        /* ... (CSS tetap sama, tidak diubah) ... */
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
            <div class="patient-info text-center" id="patient-info">
                <h5 class="mb-2">Loading...</h5>
                <img src="https://static.vecteezy.com/system/resources/thumbnails/026/375/249/small_2x/ai-generative-portrait-of-confident-male-doctor-in-white-coat-and-stethoscope-standing-with-arms-crossed-and-looking-at-camera-photo.jpg" alt="Patient Photo" class="img-thumbnail mb-2">
                <table class="table table-sm table-borderless text-left mt-2" style="font-size: 0.75rem;">
                    <tr><td><strong>MRN</strong></td><td>: -</td></tr>
                    <tr><td><strong>Reg. No</strong></td><td>: -</td></tr>
                    <tr><td><strong>Reg. Date</strong></td><td>: -</td></tr>
                    <tr><td><strong>Gender</strong></td><td>: -</td></tr>
                    <tr><td><strong>DOB</strong></td><td>: -</td></tr>
                    <tr><td></td><td>-</td></tr>
                    <tr><td><strong>Guarantor</strong></td><td>: -</td></tr>
                    <tr><td><strong>Unit</strong></td><td>: -</td></tr>
                    <tr><td><strong>Physician</strong></td><td>: -</td></tr>
                </table>
            </div>

            <div class="section-title">Billing Summary</div>
            <div class="p-2" style="font-size: 0.85rem;" id="billing-summary">
                <strong>Plafond :</strong> <span class="float-right">-</span><br>
                <strong>Billing :</strong> <span class="float-right">-</span><br>
                <strong>Selisih :</strong> <span class="float-right">-</span>
            </div>

            <div class="section-title">Allergies</div>
            <div class="p-2 text-muted" style="font-size: 0.85rem;" id="allergies-section">- Loading...</div>

            <div class="section-title">Diagnosis</div>
            <div class="p-2" style="font-size: 0.85rem;" id="diagnosis-section">
                <strong>Main:</strong><p class="mb-1">-</p>
                <strong>Secondary:</strong><p class="mb-0">-</p>
            </div>

            <div class="section-title">Vital Signs</div>
            <table class="table table-sm vital-signs-table">
                <thead>
                    <tr><th>Vital</th><th>Value</th><th>Time</th><th></th></tr>
                </thead>
                <tbody id="vital-signs-body">
                    <tr><td colspan="4" class="text-center">Loading...</td></tr>
                </tbody>
            </table>
        </div>

        <div class="content flex-grow-1">
            <!-- ... (bagian tab content tetap sama) ... -->
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
                                            src="{{ route('laboratory', ['reg_no' => $regno]) }}"
                                            frameborder="0"
                                            style="width: 100%; height: 80vh; border: none; display: none;"
                                            onload="this.style.display='block'"
                                            onerror="handleIframeError('lab-iframe', 'lab-error')">
                                        </iframe>
                                        <div class="iframe-error text-center py-5 d-none" id="lab-error">
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
                                        src="{{ route('radiology.imaging', ['reg_no' => $regno]) }}"
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
$(document).ready(function() {
    const regno = "{{ $regno ?? '' }}";
    
    if (regno) {
        loadPatientData(regno);
    }

    function loadPatientData(regno) {
        $.ajax({
            url: "{{ route('emr.findPatient') }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                regno: regno
            },
            success: function(res) {
                if (res.success) {
                    updatePatientInfo(res.data);
                } else {
                    alert('Gagal memuat data pasien: ' + res.error);
                }
            },
            error: function(xhr) {
                let msg = "Terjadi kesalahan saat memuat data pasien.";
                if (xhr.responseJSON?.error) msg = xhr.responseJSON.error;
                alert(msg);
            }
        });
    }

    function updatePatientInfo(data) {
        // Nama
        $('#patient-info h5').text(data.name.toUpperCase());

        // Tabel info
        let ageText = '-';
        if (data.dob) {
            const dob = new Date(data.dob);
            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const monthDiff = today.getMonth() - dob.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) age--;
            ageText = age + 'y';
        }

        $('#patient-info table tbody').html(`
            <tr><td><strong>MRN</strong></td><td>: ${data.mrn || '-'}</td></tr>
            <tr><td><strong>Reg. No</strong></td><td>: ${data.reg_no || '-'}</td></tr>
            <tr><td><strong>Reg. Date</strong></td><td>: ${formatDate(data.reg_date) || '-'}</td></tr>
            <tr><td><strong>Gender</strong></td><td>: ${data.gender || '-'}</td></tr>
            <tr><td><strong>DOB</strong></td><td>: ${formatDate(data.dob) || '-'} (${ageText})</td></tr>
            <tr><td><strong>Guarantor</strong></td><td>: ${data.guarantor || '-'}</td></tr>
            <tr><td><strong>Unit</strong></td><td>: ${data.unit || '-'}</td></tr>
            <tr><td><strong>Physician</strong></td><td>: ${data.physician || '-'}</td></tr>
        `);

        // Billing
        $('#billing-summary').html(`
            <strong>Plafond :</strong> <span class="float-right">${formatCurrency(data.billing_plafond)}</span><br>
            <strong>Billing :</strong> <span class="float-right">${formatCurrency(data.billing_total)}</span><br>
            <strong>Selisih :</strong> <span class="float-right ${data.billing_total - data.billing_plafond < 0 ? 'text-danger' : 'text-success'}">
                ${formatCurrency(data.billing_total - data.billing_plafond)}
            </span>
        `);

        // Allergies
        $('#allergies-section').html(data.allergies || '- None recorded');

        // Diagnosis
        $('#diagnosis-section').html(`
            <strong>Main:</strong><p class="mb-1">${data.diagnosis_main || '-'}</p>
            <strong>Secondary:</strong><p class="mb-0">${data.diagnosis_secondary || '-'}</p>
        `);

        // Vital Signs
        const vitalBody = $('#vital-signs-body');
        if (data.vital_signs && data.vital_signs.length > 0) {
            let rows = '';
            data.vital_signs.forEach(v => {
                rows += `
                    <tr>
                        <td>${v.vital}</td>
                        <td>${v.value}</td>
                        <td>${v.time}</td>
                        <td>
                            <i class="fas fa-chart-line text-success"></i> 
                            <i class="fas fa-edit text-primary ml-1"></i>
                        </td>
                    </tr>
                `;
            });
            vitalBody.html(rows);
        } else {
            vitalBody.html('<tr><td colspan="4" class="text-center text-muted">No vital signs recorded</td></tr>');
        }
    }

    function formatDate(dateStr) {
        if (!dateStr) return '-';
        const d = new Date(dateStr);
        const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        return `${d.getDate().toString().padStart(2, '0')}-${months[d.getMonth()]}-${d.getFullYear()}`;
    }

    function formatCurrency(num) {
        if (num == null || num === '') return '0.00';
        return parseFloat(num).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    // --- Fungsi sidebar & iframe tetap sama ---
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const content = document.querySelector('.content');
        const icon = sidebarToggle.querySelector('i');
        const isMobile = window.innerWidth <= 992;
        
        sidebar.classList.toggle('collapsed');
        sidebarToggle.classList.toggle('collapsed');
        content.classList.toggle('expanded');
        
        if (isMobile) {
            sidebar.classList.toggle('mobile-open');
            sidebarToggle.classList.toggle('mobile-open');
            sidebarOverlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
        }
        
        if (sidebar.classList.contains('collapsed')) {
            icon.classList.replace('fa-chevron-left', 'fa-chevron-right');
        } else {
            icon.classList.replace('fa-chevron-right', 'fa-chevron-left');
        }
        
        if (!isMobile) {
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        }
    }

    function restoreSidebarState() {
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        const isMobile = window.innerWidth <= 992;
        if (isMobile && !localStorage.getItem('sidebarCollapsed')) {
            toggleSidebar();
        } else if (isCollapsed && !isMobile) {
            toggleSidebar();
        }
    }

    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const isMobile = window.innerWidth <= 992;
        if (isMobile && sidebar.classList.contains('mobile-open') && 
            !sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
            toggleSidebar();
        }
    });

    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
            e.preventDefault();
            toggleSidebar();
        }
    });

    function handleIframeError(iframeId, errorId) {
        const iframe = document.getElementById(iframeId);
        const error = document.getElementById(errorId);
        if (iframe) iframe.style.display = 'none';
        if (error) error.classList.remove('d-none');
    }

    function openLabInNewTab() { 
        window.open(document.getElementById('lab-iframe').src, '_blank'); 
    }
    function openRadInNewTab() { 
        window.open(document.getElementById('rad-iframe').src, '_blank'); 
    }
    function retryLabIframe() { 
        const iframe = document.getElementById('lab-iframe');
        iframe.src = iframe.src; 
    }
    function retryRadIframe() { 
        const iframe = document.getElementById('rad-iframe');
        iframe.src = iframe.src; 
    }

    restoreSidebarState();
});
</script>

</body>
</html>
