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
<script>
$(document).ready(function() {
    
    /**
     * @fileoverview Mengelola pengambilan, penampilan, dan pemfilteran data radiologi.
     * Skrip ini mengambil semua data order radiologi saat halaman dimuat, menampilkannya dalam tabel,
     * dan menyediakan fungsionalitas pencarian real-time. Teks pencarian dikirim ke server
     * untuk mendapatkan daftar ID yang cocok, yang kemudian digunakan untuk memfilter data di sisi klien (browser).
     */

    // ===================================================================================
    // VARIABEL PENYIMPANAN & ELEMEN DOM
    // ===================================================================================

    /**
     * Menyimpan array utama dari semua objek order radiologi yang diambil dari server.
     * Cache lokal ini digunakan untuk memfilter dan merender ulang tampilan tanpa perlu panggilan tambahan ke server.
     * @type {Array<Object>}
     */
    let allRadiologyData = [];

    /**
     * Menyimpan array nomor registrasi (`reg_no`) yang cocok dengan query pencarian saat ini.
     * Jika nilainya `null`, berarti tidak ada filter pencarian yang aktif.
     * Jika nilainya berupa array (bahkan array kosong), berarti filter pencarian sedang aktif.
     * @type {Array<string>|null}
     */
    let activeSearchRegNos = null;
    
    /**
     * Objek jQuery yang menyimpan elemen body tabel untuk meningkatkan performa.
     * Menghindari pencarian DOM berulang kali.
     * @type {jQuery}
     */
    const tableBody = $('.results-table tbody');
    
    /**
     * Objek jQuery yang menyimpan elemen input pencarian.
     * @type {jQuery}
     */
    const searchInput = $('#search-input');

    // ===================================================================================
    // FUNGSI UTAMA
    // ===================================================================================

    /**
     * Merender (mengubah) array objek order menjadi baris tabel HTML dan menambahkannya ke body tabel.
     * Fungsi ini bertanggung jawab untuk membuat konten tabel secara dinamis.
     * @param {Array<Object>} dataToRender Array berisi objek order radiologi yang akan ditampilkan.
     */
    function renderTable(dataToRender) {
        // Kosongkan konten sebelumnya sebelum merender data baru.
        tableBody.empty();

        if (dataToRender.length > 0) {
            $.each(dataToRender, function(index, order) {
                // Membuat HTML untuk daftar item order.
                let itemsHtml = '<ul>';
                $.each(order.items, function(i, item) { itemsHtml += `<li>${item}</li>`; });
                itemsHtml += '</ul>';

                // Membuat HTML untuk kontainer gambar RIS/PACS.
                let imagesHtml = '<div class="result-image-container">';
                $.each(order.images, function(i, image) {
                    imagesHtml += `<img src="${image}" alt="RIS/PACS Image" class="result-image" data-toggle="modal" data-target="#imageModal" data-image="${image}">`;
                });
                imagesHtml += '</div>';

                // Struktur HTML lengkap untuk satu baris tabel.
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
            // Tampilkan pesan jika tidak ada data untuk ditampilkan.
            tableBody.html('<tr><td colspan="4" class="text-center text-muted p-5">Data tidak ditemukan.</td></tr>');
        }
        // Pasang kembali event listener ke elemen yang baru dibuat (seperti gambar).
        initializeEventListeners();
    }
    
    /**
     * Mengambil daftar lengkap data radiologi dari server.
     * Fungsi ini biasanya hanya dipanggil sekali saat halaman dimuat atau saat di-refresh manual.
     */
    function initialDataLoad() {
        // Tampilkan indikator loading kepada pengguna.
        tableBody.html('<tr id="loading-row"><td colspan="4" class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div><p class="mt-2 mb-0 text-muted">Memuat data...</p></td></tr>');
        
        $.ajax({
            url: "{{ route('radiology.data') }}",
            success: function(response) {
                if (response.success && response.data) {
                    // Simpan data yang diambil ke dalam cache lokal.
                    allRadiologyData = response.data;
                    // Terapkan filter untuk merender semua data di awal.
                    applyFilters();
                }
            },
            error: function() {
                // Tampilkan pesan error jika panggilan AJAX gagal.
                tableBody.html('<tr><td colspan="4" class="text-center text-danger p-5">Gagal memuat data.</td></tr>');
            }
        });
    }

    /**
     * Memfilter array utama `allRadiologyData` berdasarkan hasil pencarian yang aktif,
     * lalu memanggil `renderTable` untuk memperbarui tampilan.
     */
    function applyFilters() {
        let filteredData = allRadiologyData;

        // Jika pencarian aktif (activeSearchRegNos adalah sebuah array), filter data utama.
        if (activeSearchRegNos !== null) {
            // Gunakan Set untuk pencarian yang lebih cepat (kompleksitas O(1)) dibandingkan Array.includes() (O(n)).
            const searchIdSet = new Set(activeSearchRegNos);
            filteredData = filteredData.filter(order => searchIdSet.has(order.reg_no));
        }
        
        // Render data akhir yang sudah difilter ke dalam tabel.
        renderTable(filteredData);
    }
    
    /**
     * Menginisialisasi atau menginisialisasi ulang event listener untuk elemen yang dibuat secara dinamis.
     * Ini penting untuk dijalankan setelah `renderTable` selesai, karena fungsi tersebut mengganti elemen lama dengan yang baru.
     */
    function initializeEventListeners() {
        // Memasang event handler 'click' pada setiap gambar hasil untuk membuka modal.
        // .off().on() mencegah event handler ganda terpasang saat render ulang.
        $('.result-image').off('click').on('click', function() {
            const imgSrc = $(this).data('image');
            $('#modalImage').attr('src', imgSrc);
        });
    }

    // ===================================================================================
    // EVENT HANDLERS (PENANGANAN AKSI PENGGUNA)
    // ===================================================================================
    
    /**
     * Timer yang digunakan untuk menunda eksekusi fungsi pencarian (debouncing).
     * Ini mencegah pengiriman permintaan AJAX untuk setiap ketukan tombol.
     */
    let debounceTimer;

    /**
     * Menangani event `keyup` pada kolom input pencarian.
     * Menggunakan mekanisme debouncing untuk memicu pencarian hanya setelah pengguna berhenti mengetik.
     */
    searchInput.on('keyup', function() {
        clearTimeout(debounceTimer);
        const query = $(this).val();

        debounceTimer = setTimeout(function() {
            // Jika kotak pencarian kosong, reset filter pencarian dan tampilkan semua data.
            if (query.length === 0) {
                activeSearchRegNos = null;
                applyFilters();
                return;
            }
            // Jika ada query, kirim ke endpoint pencarian di server.
            $.ajax({
                url: `{{ route('radiology.search') }}?q=${encodeURIComponent(query)}`,
                success: function(response) {
                    if (response.success) {
                        // Simpan array nomor registrasi yang cocok.
                        activeSearchRegNos = response.data;
                        // Terapkan filter pencarian yang baru ke tampilan.
                        applyFilters();
                    }
                }
            });
        }, 300); // Jeda 300ms setelah pengguna berhenti mengetik.
    });

    /**
     * Menangani event klik untuk tombol 'Refresh'.
     * Mereset semua filter dan mengambil ulang semua data dari server.
     */
    $('#refreshBtn').on('click', function() {
        searchInput.val('');
        activeSearchRegNos = null;
        initialDataLoad();
    });

    /**
     * Menangani event klik untuk tombol 'Show All'.
     * Mereset semua filter di sisi klien dan menampilkan data `allRadiologyData` yang ada di cache lokal
     * tanpa membuat permintaan baru ke server.
     */
    $('#showAllBtn').on('click', function() {
        searchInput.val('');
        activeSearchRegNos = null;
        applyFilters(); // Cukup terapkan filter tanpa query aktif, maka semua data akan ditampilkan.
    });

    // ===================================================================================
    // INISIALISASI
    // ===================================================================================

    /**
     * Panggilan fungsi awal untuk memulai proses memuat data ke halaman.
     */
    initialDataLoad();
});
</script>

</body>
</html>