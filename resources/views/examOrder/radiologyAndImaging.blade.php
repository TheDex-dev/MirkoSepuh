<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Radiology Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #495057;
            font-size: 0.875rem;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .main-container {
            background: #ffffff;
            margin: 0;
            border: none;
            overflow: hidden;
            min-height: 100vh;
        }
        .search-section {
            padding: 10px 15px;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            position: sticky;
            top: 0;
            z-index: 20;
        }
        .search-input {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 6px 10px;
            font-size: 0.8rem;
            background: #ffffff;
            flex: 1;
            min-width: 150px;
        }
        .search-input:focus {
            outline: none;
            border-color: #1a71ceff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .search-section .btn {
            padding: 6px 12px;
            font-size: 0.8rem;
            white-space: nowrap;
        }
        .results-wrapper {
            overflow-y: auto;
            overflow-x: auto;
            max-height: calc(100vh - 75px);
            position: relative;
        }
        .results-table {
            width: 100%;
            font-size: 0.75rem;
            border-collapse: separate;
            border-spacing: 0;
        }
        .results-table thead {
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .results-table th {
            background: #1a71ceff;
            color: #ffffff;
            padding: 10px 8px;
            text-align: center;
            font-weight: 600;
            font-size: 0.75rem;
            border: 1px solid #0066cc;
            white-space: nowrap;
        }
        .results-table td {
            padding: 8px 6px;
            border: 1px solid #dee2e6;
            text-align: center;
            vertical-align: middle;
            background: #ffffff;
            font-size: 0.75rem;
        }
        .results-table tr:nth-child(even) td {
            background: #f8f9fa;
        }
        .results-table tr:hover td {
            background: #e3f2fd;
        }
        .result-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-block;
            margin: 0.25rem;
        }
        .result-image:hover {
            transform: scale(1.05);
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.15);
        }
        .result-image-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
            justify-content: center;
        }
        ul { padding-left: 1.25rem; margin: 0; list-style-type: none; text-align: left;}
        ul li { margin-bottom: 0.5rem; position: relative; }
        ul li:before { content: "•"; color: #1a71ceff; font-weight: bold; position: absolute; left: -1rem; }

        @media screen and (max-width: 767px) {
            .results-table thead { display: none; }
            .results-table tr { display: block; margin-bottom: 1rem; border: 1px solid #dee2e6; border-radius: 0.25rem; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); }
            .results-table td { display: block; text-align: right; padding: 8px; padding-left: 50%; position: relative; border: none; border-bottom: 1px solid #e9ecef; }
            .results-table tr:last-of-type td:last-of-type { border-bottom: 0; }
            .results-table td::before { content: attr(data-label); position: absolute; left: 10px; top: 50%; transform: translateY(-50%); width: calc(50% - 20px); padding-right: 10px; text-align: left; font-weight: 600; white-space: normal; }
            .results-table td[data-label="Order"], .results-table td[data-label="Result"] { text-align: left; padding-left: 10px; }
            .results-table td[data-label="Order"]::before, .results-table td[data-label="Result"]::before { top: 10px; transform: translateY(0); position: relative; display: block; left: 0; width: 100%; margin-bottom: 8px; }
            .results-table td[data-label="RIS/PACS"] .result-image-container { justify-content: flex-end; }
        }
    </style>
</head>
<body>

<div class="main-container">
    <div class="search-section">
        <i class="fas fa-search text-muted d-none d-md-block"></i>
        <input type="text" class="search-input" id="search-input" placeholder="Cari data...">
        <button type="button" class="btn btn-outline-secondary" id="showAllBtn">
            <i class="fas fa-list"></i><span class="btn-text"> Show All</span>
        </button>
        <button type="button" class="btn btn-outline-secondary" id="refreshBtn">
            <i class="fas fa-sync-alt"></i><span class="btn-text"> Refresh</span>
        </button>
    </div>

    <div class="results-wrapper">
        <table class="results-table">
            <thead>
                <tr>
                    <th style="width: 15%;">Date</th>
                    <th style="width: 45%;">Order</th>
                    <th style="width: 20%;">RIS/PACS</th>
                    <th style="width: 20%;">Result</th>
                </tr>
            </thead>
            <tbody>
                <tr id="loading-row">
                    <td colspan="4" class="text-center p-5">
                        <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>
                        <p class="mt-2 mb-0 text-muted">Memuat data radiologi...</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 10px; top: 10px; z-index: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <img src="" class="img-fluid w-100" id="modalImage" alt="Full size image">
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    
    /**
     * @fileoverview Mengelola pengambilan, penampilan, dan pemfilteran data radiologi.
     * Skrip ini mengambil data order radiologi untuk pasien saat ini (berdasarkan reg_no),
     * menampilkannya dalam tabel, dan menyediakan fungsionalitas pencarian client-side.
     */

    // ===================================================================================
    // VARIABEL PENYIMPANAN & ELEMEN DOM
    // ===================================================================================

    const regNo = '{{ $reg_no ?? "" }}';
    const regNoUrlFormat = regNo.replace(/\//g, '+');

    let allRadiologyData = [];

    // HAPUS: 'activeSearchRegNos' tidak lagi diperlukan untuk logika baru
    // let activeSearchRegNos = null; 
    
    const tableBody = $('.results-table tbody');
    const searchInput = $('#search-input');

    // ===================================================================================
    // FUNGSI UTAMA
    // ===================================================================================

    function renderTable(dataToRender) {
        tableBody.empty();

        if (dataToRender.length > 0) {
            $.each(dataToRender, function(index, order) {
                let itemsHtml = '<ul>';
                $.each(order.items, function(i, item) { itemsHtml += `<li>${item}</li>`; });
                itemsHtml += '</ul>';

                let imagesHtml = '<div class="result-image-container">';
                $.each(order.images, function(i, image) {
                    imagesHtml += `<img src="${image}" alt="RIS/PACS Image" class="result-image" data-toggle="modal" data-target="#imageModal" data-image="${image}">`;
                });
                imagesHtml += '</div>';

                const row = `
                    <tr>
                        <td data-label="Date" class="text-center"><div class="date-time">${order.date}<br><small class="text-muted">${order.time}</small></div></td>
                        <td data-label="Order" style="text-align: left; vertical-align: top;"><strong>Reg No:</strong> ${order.reg_no}<br><strong>Tx No:</strong> ${order.tx_no}<br><strong>From:</strong> ${order.from}<br><strong>By:</strong> ${order.doctor}<hr class="my-2"><strong>Order Item:</strong> ${itemsHtml}</td>
                        <td data-label="RIS/PACS">${imagesHtml}</td>
                        <td data-label="Result" style="text-align: left; vertical-align: top;"><p class="text-muted mb-0">${order.result_text}</p></td>
                    </tr>`;
                tableBody.append(row);
            });
        } else {
            tableBody.html('<tr><td colspan="4" class="text-center text-muted p-5">Data tidak ditemukan.</td></tr>');
        }
        initializeEventListeners();
    }
    
    function initialDataLoad() {
        tableBody.html('<tr id="loading-row"><td colspan="4" class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div><p class="mt-2 mb-0 text-muted">Memuat data...</p></td></tr>');
        
        if (!regNoUrlFormat) {
            tableBody.html('<tr><td colspan="4" class="text-center text-danger p-5">Gagal memuat data: No Registrasi tidak ditemukan.</td></tr>');
            return;
        }

        $.ajax({
            url: "/radiology/data/" + regNoUrlFormat,
            success: function(response) {
                if (response.success && response.data) {
                    allRadiologyData = response.data;
                    applyFilters();
                }
            },
            error: function() {
                tableBody.html('<tr><td colspan="4" class="text-center text-danger p-5">Gagal memuat data.</td></tr>');
            }
        });
    }

    /**
     * PERUBAHAN LOGIKA DI SINI
     * Memfilter array 'allRadiologyData' berdasarkan query dari kotak pencarian.
     */
    function applyFilters() {
        let filteredData = allRadiologyData;
        
        // 1. Ambil query langsung dari input field
        const query = searchInput.val().toLowerCase().trim();

        // 2. Filter data berdasarkan query jika query tidak kosong
        if (query.length > 0) {
            filteredData = filteredData.filter(order => {
                // Buat satu string berisi semua data yang bisa dicari per baris
                let searchableText = [
                    order.reg_no,
                    order.tx_no,
                    order.from,
                    order.doctor,
                    order.result_text
                ].join(' ').toLowerCase();
                
                // Tambahkan 'items' ke string pencarian
                const itemsText = order.items.join(' ').toLowerCase();
                searchableText += ' ' + itemsText;
                
                // Kembalikan true jika string pencarian mengandung query
                return searchableText.includes(query);
            });
        }
        
        // 3. HAPUS: Logika 'activeSearchRegNos' tidak diperlukan lagi
        // if (activeSearchRegNos !== null) { ... }
        
        // Render data yang sudah difilter
        renderTable(filteredData);
    }
    
    function initializeEventListeners() {
        $('.result-image').off('click').on('click', function() {
            const imgSrc = $(this).data('image');
            $('#modalImage').attr('src', imgSrc);
        });
    }

    // ===================================================================================
    // EVENT HANDLERS (PENANGANAN AKSI PENGGUNA)
    // ===================================================================================
    
    let debounceTimer;

    /**
     * PERUBAHAN LOGIKA DI SINI
     * Menangani event 'keyup' untuk memfilter di sisi klien (client-side).
     */
    searchInput.on('keyup', function() {
        clearTimeout(debounceTimer);
        
        // Tidak perlu panggil AJAX, cukup panggil applyFilters setelah jeda
        debounceTimer = setTimeout(function() {
            applyFilters();
        }, 300); // Jeda 300ms setelah pengguna berhenti mengetik.
    });

    /**
     * Menangani event klik untuk tombol 'Refresh'.
     * (Logika ini sudah benar)
     */
    $('#refreshBtn').on('click', function() {
        searchInput.val('');
        // HAPUS: activeSearchRegNos = null;
        initialDataLoad(); // Memuat ulang data untuk reg_no saat ini
    });

    /**
     * Menangani event klik untuk tombol 'Show All'.
     * (Logika ini sudah benar)
     */
    $('#showAllBtn').on('click', function() {
        searchInput.val('');
        // HAPUS: activeSearchRegNos = null;
        applyFilters(); // Terapkan filter (yang sekarang kosong)
    });

    // ===================================================================================
    // INISIALISASI
    // ===================================================================================

    initialDataLoad();
});
</script>

</body>
</html>