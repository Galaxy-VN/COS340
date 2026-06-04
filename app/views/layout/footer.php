</div>
    </div>
</div>

<footer class="app-footer text-center py-4 mt-5">
    <div class="container">
        <p class="mb-0">&copy; <?php echo date('Y'); ?> COS340 Store • Trải nghiệm mua sắm thiết bị số 3D</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){
    if ($('#productTable').length) {
        $('#productTable').DataTable({
            pageLength: 15,
            lengthChange: true,
            searching: true,
            language: {
                search: "Tìm kiếm:",
                lengthMenu: "Mục mỗi trang: _MENU_",
                zeroRecords: "Không có dữ liệu",
                info: "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                paginate: { previous: "Trước", next: "Sau" }
            }
        });
    }
});
</script>
</body>
</html>
