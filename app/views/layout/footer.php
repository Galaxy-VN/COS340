<footer class="bg-dark text-white text-center py-3 mt-5">
    <div class="container">
        <p class="mb-0">&copy; <?php echo date('Y'); ?> Quản lý sản phẩm. All rights reserved.</p>
    </div>
</footer>

<!-- jQuery (required by DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS (Bootstrap 5 integration) -->
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        if ($.fn.DataTable.isDataTable('#productTable')) {
            $('#productTable').DataTable().destroy();
        }
        $('#productTable').DataTable({
            "language": {
                "lengthMenu": "Hiển thị _MENU_ mục",
                "zeroRecords": "Không tìm thấy sản phẩm nào",
                "info": "Trang _PAGE_ / _PAGES_ — Tổng _TOTAL_ sản phẩm",
                "infoEmpty": "Không có dữ liệu",
                "infoFiltered": "(đã lọc từ _MAX_ sản phẩm)",
                "search": "Tìm kiếm:",
                "paginate": {
                    "first": "Đầu",
                    "last": "Cuối",
                    "next": "Tiếp",
                    "previous": "Trước"
                }
            },
            "pagingType": "bootstrap",
            "responsive": true
        });
    });
</script>
</body>
</html>