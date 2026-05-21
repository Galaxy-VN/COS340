</div>
    </div>
</div>

<footer class="bg-white text-center py-4 border-top mt-5">
    <div class="container">
        <p class="mb-0 text-muted">&copy; <?php echo date('Y'); ?> Quản lý sản phẩm</p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#productTable')) {
        $('#productTable').DataTable().destroy();
    }
    $('#productTable').DataTable({
        language: { lengthMenu: "Hiển thị _MENU_", zeroRecords: "Không có dữ liệu", info: "Trang _PAGE_ / _PAGES_", search: "Tìm:", paginate: { first: "Đầu", last: "Cuối", next: "Tiếp", previous: "Trước" } },
        pagingType: "bootstrap", responsive: true
    });
});
</script>
</body>
</html>
