<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laboratory Test Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #495057;
            font-size: 0.875rem;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .main-container {
            background: #ffffff;
            margin: 0;
            border: none;
            overflow: hidden;
            min-height: 100vh;
        }

        /* Mobile responsive - stack panels vertically on small screens */
        @media (max-width: 767px) {
            .row.no-gutters {
                height: auto !important;
                flex-direction: column;
            }
            
            .col-md-4, .col-md-8 {
                max-width: 100%;
                flex: none;
            }
            
            .test-orders-section {
                border-right: none;
                border-bottom: 1px solid #dee2e6;
                max-height: 40vh;
                overflow-y: auto;
            }
            
            .results-section h6 {
                padding: 10px 15px;
                font-size: 0.85rem;
            }
            
            .results-wrapper {
                max-height: 50vh !important;
            }
            
            .results-table thead {
                position: sticky;
                top: 0;
            }
            
            .results-table th {
                font-size: 0.65rem;
                padding: 6px 4px;
            }
            
            .results-table td {
                font-size: 0.65rem;
                padding: 4px 2px;
            }
            
            .order-item {
                padding: 10px;
                margin-bottom: 10px;
            }
            
            .order-info {
                font-size: 0.7rem;
            }
            
            .urgent-tag {
                font-size: 0.6rem;
                padding: 1px 4px;
                top: 4px;
                right: 4px;
            }
        }

        .test-orders-section {
            padding: 15px;
            background: #ffffff;
            height: 100%;
            border-right: 1px solid #dee2e6;
        }

        .test-orders-section h6 {
            color: #1a71ceff;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            position: sticky;
            top: 0;
            background: #ffffff;
            z-index: 10;
            padding-bottom: 10px;
        }

        .test-orders-section h6 i {
            color: #1a71ceff;
            font-size: 1rem;
        }

        .order-item {
            background: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            margin-bottom: 12px;
            padding: 12px;
            position: relative;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .order-item:hover {
            border-color: #1a71ceff;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            background: #f8f9fa;
        }

        .order-item.selected {
            border-color: #1a71ceff;
            background: #e3f2fd;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 123, 255, 0.25);
        }

        .order-item.active {
            border-color: #1a71ceff;
            border-width: 2px;
            background: #e3f2fd;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 123, 255, 0.35);
        }

        .order-item.active .order-date {
            color: #1a71ceff;
            font-weight: 700;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .order-date {
            font-weight: 600;
            color: #495057;
            font-size: 0.8rem;
        }

        .order-info {
            font-size: 0.75rem;
            color: #6c757d;
            line-height: 1.4;
        }

        .order-info strong {
            color: #495057;
            font-weight: 600;
        }

        .urgent-tag {
            background: #dc3545;
            color: #ffffff;
            padding: 2px 6px;
            border-radius: 12px;
            font-size: 0.65rem;
            font-weight: 600;
            position: absolute;
            top: 6px;
            right: 6px;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        /* Responsive order items - simplified */
        @media (max-width: 767px) {
            .test-orders-section {
                padding: 15px;
            }

            .order-item {
                padding: 12px;
                margin-bottom: 12px;
            }

            .order-info {
                font-size: 0.75rem;
            }

            .urgent-tag {
                font-size: 0.65rem;
                padding: 2px 6px;
                top: 6px;
                right: 6px;
            }
        }

        .results-section {
            padding: 0;
            background: #ffffff;
            height: 100%;
            overflow: hidden;
        }

        .results-section h6 {
            color: #1a71ceff;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 15px 20px 10px 20px;
            background: #ffffff;
            border-bottom: 2px solid #dee2e6;
        }

        .results-section h6 i {
            font-size: 1rem;
        }

        .results-wrapper {
            overflow-y: auto;
            overflow-x: auto;
            max-height: calc(100vh - 220px);
            position: relative;
        }

        .results-wrapper::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .results-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .results-wrapper::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .results-wrapper::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .results-table {
            width: 100%;
            font-size: 0.75rem;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 0;
        }

        .results-table thead {
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .results-wrapper.scrolled .results-table thead::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(to bottom, rgba(0,0,0,0.1), transparent);
            pointer-events: none;
        }

        .results-table th {
            background: #1a71ceff;
            color: #ffffff;
            padding: 8px 6px;
            text-align: center;
            font-weight: 600;
            font-size: 0.7rem;
            border: 1px solid #0066cc;
            white-space: nowrap;
        }

        .results-table td {
            padding: 6px 4px;
            border: 1px solid #dee2e6;
            text-align: center;
            vertical-align: middle;
            background: #ffffff;
            font-size: 0.7rem;
        }

        .results-table tr:nth-child(even) td {
            background: #f8f9fa;
        }

        .results-table tr:hover td {
            background: #e3f2fd;
        }

        .order-item.active {
            border-color: #1a71ceff;
            background: #e3f2fd;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 123, 255, 0.25);
        }

        .test-row-filtered {
            display: none;
        }

        .group-header {
            background: #6c757d !important;
            color: #ffffff !important;
            text-align: left !important;
            padding: 8px 12px !important;
            font-weight: 600;
            font-size: 0.75rem;
            cursor: pointer;
            border: 1px solid #5a6268 !important;
        }

        .group-header:hover {
            background: #5a6268 !important;
        }

        .group-header i {
            margin-right: 6px;
        }

        .result-value {
            font-weight: 600;
            font-family: 'Courier New', monospace;
        }

        .flag-h {
            color: #dc3545;
            font-weight: 600;
            background: rgba(220, 53, 69, 0.1);
            padding: 2px 6px;
            border-radius: 0.25rem;
        }

        .flag-l {
            color: #1a71ceff;
            font-weight: 600;
            background: rgba(0, 123, 255, 0.1);
            padding: 2px 6px;
            border-radius: 0.25rem;
        }

        /* Responsive table */
        @media (max-width: 767px) {
            .results-section {
                padding: 10px 5px;
            }

            .results-table {
                font-size: 9px;
                min-width: 800px;
            }

            .results-table th,
            .results-table td {
                padding: 4px 3px;
                font-size: 9px;
            }

            .group-header {
                font-size: 10px;
                padding: 6px 8px !important;
            }

            .results-table td[style*="padding-left"] {
                padding-left: 10px !important;
            }
        }

        @media (max-width: 480px) {
            .results-table {
                min-width: 700px;
                font-size: 8px;
            }

            .results-table th,
            .results-table td {
                padding: 3px 2px;
                font-size: 8px;
            }
        }

        /* Table scroll indicator - removed for simplicity */
        
        /* Duplicate styles - cleaned up */

        /* Responsive action buttons */
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

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .loading-overlay.show {
            display: flex;
        }

        .spinner-border-custom {
            width: 3rem;
            height: 3rem;
            border: 0.25em solid #1a71ceff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .ajax-error {
            display: none;
            margin: 15px;
            padding: 15px;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 0.25rem;
            color: #721c24;
            font-size: 0.875rem;
        }

        .ajax-success {
            display: none;
            margin: 15px;
            padding: 15px;
            background: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 0.25rem;
            color: #155724;
            font-size: 0.875rem;
        }

        /* Print styles */
        @media print {
            .search-section,
            .main-container {
                margin: 0;
                background: #ffffff;
            }

            .results-table {
                font-size: 0.75rem;
            }
        }
    </style>
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Tab Content -->
        <div class="tab-content" id="mainTabContent">
            <!-- Laboratory Tab -->
            <div class="tab-pane fade show active" id="laboratory" role="tabpanel">
                <!-- Search Section -->
                <div class="search-section">
                    <i class="fas fa-search text-muted"></i>
                    <input type="text" class="search-input" id="searchInput" placeholder="Cari data...">
                    <button type="button" class="btn btn-outline-secondary" id="showAllBtn">
                        <i class="fas fa-list"></i><span class="btn-text"> Show All</span>
                    </button>
                    <button type="button" class="btn btn-outline-secondary" id="refreshBtn">
                        <i class="fas fa-sync-alt"></i><span class="btn-text"> Refresh</span>
                    </button>
                </div>

                <!-- Loading Overlay -->
                <div class="loading-overlay" id="loadingOverlay">
                    <div class="spinner-border spinner-border-custom text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

                <!-- Error Message -->
                <div class="ajax-error" id="ajaxError"></div>

                <!-- Success Message -->
                <div class="ajax-success" id="ajaxSuccess"></div>

                <!-- Side by Side Layout -->
                <div class="row no-gutters" style="height: calc(100vh - 120px);">
                    <!-- Left Panel - Laboratory Test Orders -->
                    <div class="col-md-4 border-right">
                        <div class="test-orders-section" id="testOrdersSection">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-plus-circle"></i> Laboratory Test Orders
                            </h6>
                            
                            <div id="ordersContainer" style="max-height: calc(100vh - 220px); overflow-y: auto;">
                                <!-- Orders will be loaded via AJAX -->
                            </div>
                        </div>
                    </div>

                    <!-- Right Panel - Results Section -->
                    <div class="col-md-8">
                        <div class="results-section" id="resultsSection">
                            <h6 class="text-primary">
                                <i class="fas fa-chart-line"></i> Test Results
                            </h6>
                            <div class="results-wrapper">
                                <table class="results-table table" id="resultsTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%">Chart / Exam Name</th>
                                            <th style="width: 12%">Result Date</th>
                                            <th style="width: 8%">Flag</th>
                                            <th style="width: 12%">Result</th>
                                            <th style="width: 10%">Unit</th>
                                            <th style="width: 15%">Standard Value</th>
                                            <th style="width: 8%">Result Comment</th>
                                            <th style="width: 5%">Result Note</th>
                                            <th style="width: 5%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="resultsTableBody">
                                        <!-- Results will be loaded via AJAX -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Get reg_no from URL or pass it from controller
            const regNo = '{{ $reg_no ?? "" }}';
            const regNoUrlFormat = regNo.replace(/\//g, '+'); // Convert / to + for URLs
            
            // Setup AJAX with CSRF token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /**
             * Timer untuk debouncing pencarian.
             */
            let searchDebounceTimer;

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Load initial data
            loadTestOrders();
            loadTestResults();

            // Refresh button functionality
            $('#refreshBtn').on('click', function() {
                $('#searchInput').val('');
                loadTestOrders();
                loadTestResults();
                // Remove active class from all orders
                $('.order-item').removeClass('active');
                showSuccess('Data refreshed successfully!');
            });

            // Show All button functionality
            $('#showAllBtn').on('click', function() {
                $('#searchInput').val('');
                $('.order-item').show(); // Show all orders
                // Remove active class from all orders
                $('.order-item').removeClass('active');
                showSuccess('Showing all test orders');
            });

            // Search functionality - client-side filtering for orders only
            $('#searchInput').on('input', function() {
                clearTimeout(searchDebounceTimer);
                const query = $(this).val().toLowerCase().trim();

                searchDebounceTimer = setTimeout(function() {
                    filterOrdersPanel(query);
                }, 300); // Jeda 300ms setelah pengguna berhenti mengetik.
            });

            // Client-side search function - filters laboratory test orders only
            function filterOrdersPanel(searchQuery) {
                const $orderItems = $('.order-item');
                let visibleOrdersCount = 0;

                if (searchQuery === '') {
                    // Show all orders if search is empty
                    $orderItems.show();
                    return;
                }

                // Filter each order item
                $orderItems.each(function() {
                    const $order = $(this);
                    const orderText = $order.text().toLowerCase();
                    
                    // Check if order matches search query
                    if (orderText.includes(searchQuery)) {
                        $order.show();
                        visibleOrdersCount++;
                    } else {
                        $order.hide();
                    }
                });

                // Show feedback
                if (visibleOrdersCount === 0) {
                    showError('Tidak ada order yang ditemukan untuk pencarian "' + searchQuery + '"');
                } else {
                    showSuccess(`Ditemukan ${visibleOrdersCount} order`);
                }
            }

            // Load test orders via AJAX
            function loadTestOrders() {
                showLoading(true);
                
                $.ajax({
                    url: '/laboratory/orders/' + regNoUrlFormat,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success && response.data) {
                            renderTestOrders(response.data);
                        }
                        showLoading(false);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading test orders:', error);
                        showError('Failed to load test orders. ' + (xhr.responseJSON?.message || ''));
                        showLoading(false);
                    }
                });
            }

            // Load test results via AJAX
            function loadTestResults() {
                showLoading(true);
                
                // Load all results (from all orders for this patient)
                if (regNoUrlFormat) {
                    // Get first order's results or show empty state
                    $.ajax({
                        url: '/laboratory/orders/' + regNoUrlFormat,
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.success && response.data && response.data.length > 0) {
                                // Load results for first order
                                loadTestResultsByOrder(response.data[0].id);
                            } else {
                                $('#resultsTableBody').html(
                                    '<tr><td colspan="9" class="text-center text-muted py-4">' +
                                    '<i class="fas fa-info-circle"></i> No laboratory orders found for this patient.' +
                                    '</td></tr>'
                                );
                                showLoading(false);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error loading initial results:', error);
                            showError('Failed to load test results.');
                            showLoading(false);
                        }
                    });
                } else {
                    showError('Registration number not found.');
                    showLoading(false);
                }
            }

            // Render test orders
            function renderTestOrders(orders) {
                const container = $('#ordersContainer');
                container.empty(); // Clear existing content
                
                // Use forEach to iterate through orders (similar to PHP foreach)
                orders.forEach(function(order) {
                    let itemsHtml = '';
                    
                    // Use forEach for order items
                    order.items.forEach(function(item, index) {
                        itemsHtml += '• ' + item;
                        if (index < order.items.length - 1) {
                            itemsHtml += '<br>';
                        }
                    });
                    
                    const urgentTag = order.urgent ? '<div class="urgent-tag">URGENT</div>' : '';
                    const doctorInfo = order.doctor ? `<strong>By:</strong> ${order.doctor}<br>` : '';
                    const priceInfo = order.price ? `<br><strong>(${order.price})</strong>` : '';
                    
                    const orderHtml = `
                        <div class="order-item" data-order-id="${order.id}">
                            ${urgentTag}
                            <div class="order-header">
                                <span class="order-date">${order.date}</span>
                            </div>
                            <div class="order-info">
                                <strong>Req No:</strong> ${order.req_no}<br>
                                <strong>Tx No:</strong> ${order.tx_no}<br>
                                <strong>From:</strong> ${order.from}<br>
                                ${doctorInfo}
                                ${itemsHtml.length > 0 ? '<strong>Order Item:</strong><br>' + itemsHtml : ''}
                                ${priceInfo}
                            </div>
                        </div>
                    `;
                    
                    container.append(orderHtml);
                });
                
                // Add click handler for order selection
                $('.order-item').off('click').on('click', function() {
                    const $clickedOrder = $(this);
                    const orderId = $clickedOrder.data('order-id');
                    
                    // Clear search when selecting an order
                    $('#searchInput').val('');
                    
                    // Remove active class from all orders
                    $('.order-item').removeClass('active');
                    
                    // Add active class to clicked order
                    $clickedOrder.addClass('active');
                    
                    // Load filtered results based on order ID
                    loadTestResultsByOrder(orderId);
                });
                
                console.log('Test orders rendered:', orders.length + ' orders');
            }

            // Render test results
            function renderTestResults(results) {
                const tbody = $('#resultsTableBody');
                tbody.empty(); // Clear existing content
                
                // Use forEach to iterate through result groups (similar to PHP foreach)
                results.forEach(function(group) {
                    // Add group header
                    const groupHeaderHtml = `
                        <tr>
                            <td class="group-header" colspan="9">
                                <i class="fas fa-chevron-down mr-2"></i>Group: ${group.group}
                            </td>
                        </tr>
                    `;
                    tbody.append(groupHeaderHtml);
                    
                    // Use forEach to iterate through tests in each group
                    group.tests.forEach(function(test) {
                        let flagHtml = '';
                        if (test.flag === 'H') {
                            flagHtml = '<span class="flag-h">H</span>';
                        } else if (test.flag === 'L') {
                            flagHtml = '<span class="flag-l">L</span>';
                        }
                        
                        const testRowHtml = `
                            <tr data-test-id="${test.id}">
                                <td style="padding-left: 20px;">${test.name}</td>
                                <td>${test.result_date}</td>
                                <td>${flagHtml}</td>
                                <td class="result-value">${test.result}</td>
                                <td>${test.unit}</td>
                                <td>${test.standard_value}</td>
                                <td>${test.result_comment}</td>
                                <td>${test.result_note}</td>
                                <td></td>
                            </tr>
                        `;
                        
                        tbody.append(testRowHtml);
                    });
                });
                
                console.log('Test results rendered:', results.length + ' groups');
            }



            // Load test results filtered by order ID
            function loadTestResultsByOrder(orderId) {
                showLoading(true);
                
                $.ajax({
                    url: '/laboratory/testbydate/' + orderId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            if (response.data && response.data.length > 0) {
                                renderTestResults(response.data);
                                showSuccess('Showing results for selected order');
                            } else {
                                // Clear results if no data
                                $('#resultsTableBody').html(
                                    '<tr><td colspan="9" class="text-center text-muted py-4">' +
                                    '<i class="fas fa-info-circle"></i> No test results available for this order yet.' +
                                    '</td></tr>'
                                );
                                showSuccess('No results found for selected order');
                            }
                        }
                        showLoading(false);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading test results by order:', error);
                        showError('Failed to load test results for selected order.');
                        showLoading(false);
                    }
                });
            }

            // Highlight results related to selected order (deprecated - now using loadTestResultsByOrder)
            function highlightRelatedResults(orderId) {
                // This function is now deprecated in favor of loadTestResultsByOrder
                // Keeping for backward compatibility
                console.log('Loading results for order:', orderId);
            }

            // Old search functions removed - using improved implementation above

            // Show/hide loading overlay
            function showLoading(show) {
                if (show) {
                    $('#loadingOverlay').addClass('show');
                } else {
                    $('#loadingOverlay').removeClass('show');
                }
            }

            // Show error message
            function showError(message) {
                const errorDiv = $('#ajaxError');
                errorDiv.text(message).fadeIn();
                setTimeout(function() {
                    errorDiv.fadeOut();
                }, 5000);
            }

            // Show success message (using alert, can be replaced with toast)
            function showSuccess(message) {
                const successDiv = $('#ajaxSuccess');
                successDiv.text(message).fadeIn();
                setTimeout(function() {
                    successDiv.fadeOut();
                }, 3000);
            }

                // Group expand/collapse functionality
            $(document).on('click', '.group-header', function() {
                const $icon = $(this).find('i');
                const $currentRow = $(this).closest('tr');
                const rows = [];
                let $nextRow = $currentRow.next();
                
                while ($nextRow.length && !$nextRow.hasClass('group-header')) {
                    rows.push($nextRow);
                    $nextRow = $nextRow.next();
                }

                if ($icon.hasClass('fa-chevron-down')) {
                    $icon.removeClass('fa-chevron-down').addClass('fa-chevron-right');
                    rows.forEach($row => $row.hide());
                } else {
                    $icon.removeClass('fa-chevron-right').addClass('fa-chevron-down');
                    rows.forEach($row => $row.show());
                }
            });

            $('.group-header').css('cursor', 'pointer');

            // Tab switching with AJAX data loading
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                const target = $(e.target).attr("href");
                const tabId = target.substring(1);
                
                // Load data for specific tab if needed
                if (tabId === 'radiology') {
                    loadRadiologyData();
                } else if (tabId === 'pathology') {
                    loadPathologyData();
                } else if (tabId === 'diagnostic') {
                    loadDiagnosticData();
                } else if (tabId === 'other') {
                    loadOtherData();
                }
            });

            // Load data for other tabs (placeholder functions)
            function loadRadiologyData() {
                console.log('Loading radiology data...');
                // AJAX call to load radiology data
            }

            function loadPathologyData() {
                console.log('Loading pathology data...');
                // AJAX call to load pathology data
            }

            function loadDiagnosticData() {
                console.log('Loading diagnostic data...');
                // AJAX call to load diagnostic data
            }

            function loadOtherData() {
                console.log('Loading other data...');
                // AJAX call to load other data
            }

            // Responsive behavior
            handleResponsiveLayout();
            $(window).on('resize', debounce(handleResponsiveLayout, 250));

            // Handle responsive layout changes
            function handleResponsiveLayout() {
                const windowWidth = $(window).width();
                
                // Mobile specific behavior
                if (windowWidth < 768) {
                    // Adjust heights for mobile stacked layout
                    $('.row.no-gutters').css('height', 'auto');
                    $('#ordersContainer').css('max-height', '40vh');
                    $('.results-wrapper').css('max-height', '50vh');
                    
                    // Add horizontal scroll hint for table
                    if (!$('.scroll-hint').length) {
                        $('.results-section h6').after(
                            '<div class="alert alert-info scroll-hint" style="font-size: 0.7rem; padding: 5px; margin: 10px 15px;">' +
                            '<i class="fas fa-hand-point-right"></i> Scroll horizontally to view all columns' +
                            '</div>'
                        );
                    }
                } else {
                    // Desktop: remove scroll hint and restore heights
                    $('.scroll-hint').remove();
                    $('.row.no-gutters').css('height', 'calc(100vh - 120px)');
                    $('#ordersContainer').css('max-height', 'calc(100vh - 220px)');
                    $('.results-wrapper').css('max-height', 'calc(100vh - 220px)');
                }

                // Adjust table minimum width based on screen size
                if (windowWidth >= 768 && windowWidth < 992) {
                    $('.results-table').css('min-width', '700px');
                } else if (windowWidth >= 992) {
                    $('.results-table').css('min-width', 'auto');
                } else {
                    $('.results-table').css('min-width', '600px');
                }
            }

            // Debounce function for resize events
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }



            // Detect scroll position for table shadow
            $('.results-wrapper').on('scroll', function() {
                const scrollTop = $(this).scrollTop();
                const scrollLeft = $(this).scrollLeft();
                const scrollWidth = this.scrollWidth;
                const clientWidth = this.clientWidth;
                
                // Add scrolled class when scrolled down
                if (scrollTop > 0) {
                    $(this).addClass('scrolled');
                } else {
                    $(this).removeClass('scrolled');
                }
                
                // Handle horizontal scroll
                if (scrollLeft > 0) {
                    $(this).addClass('scrolled-left');
                } else {
                    $(this).removeClass('scrolled-left');
                }
                
                if (scrollLeft + clientWidth >= scrollWidth - 10) {
                    $(this).addClass('scrolled-end');
                } else {
                    $(this).removeClass('scrolled-end');
                }
            });

            // Handle orientation change
            $(window).on('orientationchange', function() {
                setTimeout(function() {
                    handleResponsiveLayout();
                }, 100);
            });

            // Prevent zoom on double-tap for nav links (iOS)
            $('.nav-tabs .nav-link').on('touchend', function(e) {
                e.preventDefault();
                $(this).click();
            });

            // Virtual keyboard handling for mobile search
            if ($(window).width() < 768) {
                $('#searchInput').on('focus', function() {
                    setTimeout(function() {
                        window.scrollTo(0, 0);
                        document.body.scrollTop = 0;
                    }, 300);
                });
            }

            // Lazy load images if any (future enhancement)
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            imageObserver.unobserve(img);
                        }
                    });
                });

                $('img[data-src]').each(function() {
                    imageObserver.observe(this);
                });
            }

            // Network status handling for offline capability
            window.addEventListener('online', function() {
                showSuccess('Connection restored. Refreshing data...');
                loadTestOrders();
                loadTestResults();
            });

            window.addEventListener('offline', function() {
                showError('No internet connection. Showing cached data.');
            });

            // Initialize with responsive layout
            handleResponsiveLayout();
        });
    </script>
</body>
</html>