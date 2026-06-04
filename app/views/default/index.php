<?php $title = 'Trang chủ • COS340 Store'; ?>
<?php $products = $products ?? []; ?>
<?php $categories = $categories ?? []; ?>
<?php $cartCount = $cartCount ?? 0; ?>
<?php include 'app/views/layout/header.php'; ?>

<!-- Custom Styles for Landing Page -->
<style>
    .hero-section {
        min-height: calc(85vh - 72px);
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        border-radius: var(--radius-xl);
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.4), rgba(30, 41, 59, 0.2));
        border: var(--glass-border);
        box-shadow: var(--shadow-soft), var(--liquid-highlight);
        padding: 4rem 2rem;
        margin-bottom: 3rem;
    }
    .hero-glow {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 70% 30%, rgba(59, 130, 246, 0.15) 0%, transparent 60%),
                    radial-gradient(circle at 30% 70%, rgba(244, 63, 94, 0.1) 0%, transparent 60%);
        pointer-events: none;
        z-index: 0;
    }
    .hero-canvas-container {
        position: relative;
        width: 100%;
        height: 450px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
    }
    #three-hero-canvas {
        width: 100%;
        height: 100%;
        outline: none;
        border-radius: var(--radius-lg);
        cursor: grab;
    }
    #three-hero-canvas:active {
        cursor: grabbing;
    }
    .hero-content {
        position: relative;
        z-index: 2;
    }
    .text-gradient {
        background: linear-gradient(135deg, #fff 30%, var(--brand-300) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .text-accent-gradient {
        background: linear-gradient(135deg, var(--brand-300), var(--accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .badge-premium {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 0.5rem 1rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 500;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        backdrop-filter: blur(10px);
    }
    .bento-container {
        margin-bottom: 4rem;
    }
    .bento-card {
        background: var(--paper);
        border: var(--glass-border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-soft), var(--liquid-highlight);
        padding: 2rem;
        height: 100%;
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
        position: relative;
        overflow: hidden;
    }
    .bento-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-float), var(--liquid-highlight), 0 0 25px rgba(59, 130, 246, 0.15);
    }
    .bento-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--brand-300);
        margin-bottom: 1.5rem;
    }
    .bento-card:hover .bento-icon {
        background: linear-gradient(135deg, var(--brand-500), var(--accent));
        color: white;
        box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);
    }
    .product-showcase-title {
        position: relative;
        display: inline-block;
        margin-bottom: 2.5rem;
    }
    .product-showcase-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, var(--brand-500), var(--accent));
        border-radius: 99px;
    }
    .product-card-premium {
        background: var(--paper);
        border: var(--glass-border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-soft), var(--liquid-highlight);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        overflow: hidden;
    }
    .product-card-premium:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-float), var(--liquid-highlight), 0 0 30px rgba(244, 63, 94, 0.15);
        border-color: rgba(244, 63, 94, 0.3);
    }
    .product-image-wrap {
        position: relative;
        padding-top: 100%;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.02);
    }
    .product-image-wrap img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .product-card-premium:hover .product-image-wrap img {
        transform: scale(1.08);
    }
    .product-overlay-btn {
        position: absolute;
        bottom: 15px;
        right: 15px;
        width: 44px;
        height: 44px;
        border-radius: 999px;
        background: rgba(15, 23, 42, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    .product-card-premium:hover .product-overlay-btn {
        opacity: 1;
        transform: translateY(0);
    }
    .product-overlay-btn:hover {
        background: var(--brand-500);
        box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
    }
    .cta-banner {
        border-radius: var(--radius-xl);
        background: linear-gradient(135deg, rgba(244, 63, 94, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 4rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
        margin-top: 4rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-soft);
    }
    .cta-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, transparent 50%);
        pointer-events: none;
    }
    .three-controls-hint {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 0.4rem 1rem;
        border-radius: 999px;
        font-size: 0.75rem;
        color: var(--text-soft);
        pointer-events: none;
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: opacity 0.3s;
    }
</style>

<!-- Hero Section -->
<div class="hero-section row g-4 align-items-center">
    <div class="hero-glow"></div>
    <div class="col-lg-6 hero-content">
        <div class="badge-premium">
            <i class="ph ph-sparkle"></i> Trải nghiệm tương tác 3D thế hệ mới
        </div>
        <h1 class="display-4 fw-extrabold mb-3 text-gradient">Khám Phá Vũ Trụ<br><span class="text-accent-gradient">Thiết Bị Số Cao Cấp</span></h1>
        <p class="lead mb-4 text-muted" style="max-width: 500px;">
            Giao diện 3D tương tác thời gian thực. Trải nghiệm mua sắm thiết bị công nghệ đỉnh cao được thiết kế trực quan và đẳng cấp.
        </p>
        <div class="d-flex gap-3 flex-wrap">
            <a href="/phamgiahuy/product" class="btn btn-primary btn-lg px-4 py-3 rounded-4 d-inline-flex align-items-center gap-2">
                <i class="ph ph-shopping-bag"></i> Mua sắm ngay
            </a>
            <?php if (!isset($_SESSION['username'])): ?>
                <a href="/phamgiahuy/account/register" class="btn btn-light btn-lg px-4 py-3 rounded-4">
                    Tạo tài khoản
                </a>
            <?php else: ?>
                <a href="/phamgiahuy/product/orders" class="btn btn-light btn-lg px-4 py-3 rounded-4 d-inline-flex align-items-center gap-2">
                    <i class="ph ph-receipt"></i> Đơn hàng của tôi
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="hero-canvas-container">
            <canvas id="three-hero-canvas"></canvas>
            <div class="three-controls-hint">
                <i class="ph ph-hand-grabbing"></i> Kéo để xoay mô hình 3D
            </div>
        </div>
    </div>
</div>

<!-- Bento Grid Stats / Features -->
<div class="bento-container">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="bento-card">
                <div class="bento-icon">
                    <i class="ph ph-cube"></i>
                </div>
                <h3 class="h5 fw-bold mb-2">Không Gian 3D</h3>
                <p class="text-muted mb-0">Tất cả sản phẩm được hiển thị mô phỏng 3D tương tác trực tiếp giúp hình dung rõ nét.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bento-card">
                <div class="bento-icon">
                    <i class="ph ph-shield-check"></i>
                </div>
                <h3 class="h5 fw-bold mb-2">Bảo Hành Cao Cấp</h3>
                <p class="text-muted mb-0">Cam kết chính hãng 100%, bảo hành 12 tháng 1 đổi 1 nhanh chóng và tin cậy.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bento-card">
                <div class="bento-icon">
                    <i class="ph ph-lightning"></i>
                </div>
                <h3 class="h5 fw-bold mb-2">Giao Hàng Siêu Tốc</h3>
                <p class="text-muted mb-0">Đơn hàng được chuẩn bị và bàn giao vận chuyển trong vòng 2 giờ tại nội thành.</p>
            </div>
        </div>
    </div>
</div>

<!-- Featured Products Showcase -->
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="h3 fw-bold product-showcase-title">Sản phẩm nổi bật</h2>
            <p class="text-muted mb-0">Tuyển chọn các thiết bị số được săn đón nhiều nhất trong tuần.</p>
        </div>
        <a href="/phamgiahuy/product" class="btn btn-glass d-inline-flex align-items-center gap-2">
            Xem tất cả <i class="ph ph-arrow-right"></i>
        </a>
    </div>

    <div class="row g-4">
        <?php if (empty($products)): ?>
            <div class="col-12">
                <div class="empty-state">
                    <p class="mb-0">Chưa có sản phẩm nào được cập nhật.</p>
                </div>
            </div>
        <?php else: ?>
            <?php 
            // Display up to 3 featured products
            $featured = array_slice($products, 0, 3);
            foreach ($featured as $prod): 
            ?>
                <div class="col-md-4">
                    <div class="product-card-premium h-100 d-flex flex-column">
                        <div class="product-image-wrap">
                            <?php if (!empty($prod->image) && file_exists('uploads/' . $prod->image)): ?>
                                <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($prod->image); ?>" alt="<?php echo htmlspecialchars($prod->name); ?>">
                            <?php else: ?>
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-dark" style="position:absolute;">
                                    <i class="ph ph-image-square text-muted" style="font-size: 3rem;"></i>
                                </div>
                            <?php endif; ?>
                            <a href="/phamgiahuy/product/show/<?php echo $prod->id; ?>" class="product-overlay-btn" title="Xem chi tiết">
                                <i class="ph ph-eye" style="font-size: 1.25rem;"></i>
                            </a>
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-10 align-self-start mb-2"><?php echo htmlspecialchars($prod->category_name ?? 'Thiết bị'); ?></span>
                            <h3 class="h6 fw-bold mb-2">
                                <a href="/phamgiahuy/product/show/<?php echo $prod->id; ?>" class="text-decoration-none text-reset hover-accent">
                                    <?php echo htmlspecialchars($prod->name); ?>
                                </a>
                            </h3>
                            <p class="small text-muted flex-grow-1 mb-3">
                                <?php echo htmlspecialchars(mb_strimwidth($prod->description, 0, 90, '...')); ?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top border-white border-opacity-5">
                                <div class="fw-bold fs-5 text-primary"><?php echo number_format($prod->price, 0, ',', '.'); ?>đ</div>
                                <form action="/phamgiahuy/product/addToCart" method="POST" class="m-0">
                                    <input type="hidden" name="product_id" value="<?php echo $prod->id; ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="redirect_to" value="/">
                                    <button type="submit" class="btn btn-primary px-3 btn-sm d-flex align-items-center gap-1">
                                        <i class="ph ph-shopping-cart-simple"></i> Thêm vào giỏ
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- CTA Banner -->
<div class="cta-banner">
    <h2 class="h2 fw-extrabold text-gradient mb-3">Sẵn Sàng Trải Nghiệm Mua Sắm Mới?</h2>
    <p class="text-muted mb-4 mx-auto" style="max-width: 550px;">
        Đăng ký tài khoản ngay hôm nay để nhận thông báo về sản phẩm mới nhất và cập nhật trạng thái đơn hàng trực tuyến nhanh nhất.
    </p>
    <?php if (!isset($_SESSION['username'])): ?>
        <a href="/phamgiahuy/account/register" class="btn btn-primary btn-lg px-4 py-3 rounded-4">Tạo Tài Khoản Ngay</a>
    <?php else: ?>
        <a href="/phamgiahuy/product" class="btn btn-primary btn-lg px-4 py-3 rounded-4">Đi Đến Cửa Hàng</a>
    <?php endif; ?>
</div>

<!-- Three.js Interactive Setup Script -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('three-hero-canvas');
    if (!canvas) return;

    // Check if Three is loaded
    if (typeof THREE === 'undefined') {
        console.error('Three.js is not loaded.');
        return;
    }

    // Set sizes
    const container = canvas.parentElement;
    let width = container.clientWidth;
    let height = container.clientHeight;

    // Scene
    const scene = new THREE.Scene();

    // Camera
    const camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 100);
    camera.position.z = 8;

    // Renderer
    const renderer = new THREE.WebGLRenderer({
        canvas: canvas,
        antialias: true,
        alpha: true
    });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setSize(width, height);
    renderer.shadowMap.enabled = true;

    // OrbitControls
    let controls = null;
    if (typeof THREE.OrbitControls !== 'undefined') {
        controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;
        controls.dampingFactor = 0.05;
        controls.enableZoom = false; // Disable zoom on landing page for scroll integrity
        controls.autoRotate = true;
        controls.autoRotateSpeed = 0.5;
    }

    // Create a beautiful, premium geometric object
    // We create a group containing a glass Torus Knot and an outer glowing wireframe Torus Knot
    const objectGroup = new THREE.Group();

    // 1. Torus Knot Core
    const geometry = new THREE.TorusKnotGeometry(1.2, 0.4, 150, 20);
    
    // Glassy material
    const material = new THREE.MeshPhysicalMaterial({
        color: 0x3b82f6, // Cobalt
        metalness: 0.1,
        roughness: 0.1,
        transparent: true,
        opacity: 0.85,
        transmission: 0.6, // Glass transparency
        ior: 1.5,
        side: THREE.DoubleSide,
        clearcoat: 1.0,
        clearcoatRoughness: 0.1
    });
    const coreMesh = new THREE.Mesh(geometry, material);
    objectGroup.add(coreMesh);

    // 2. Glowing wireframe overlay
    const wireframeGeo = new THREE.TorusKnotGeometry(1.21, 0.41, 150, 20);
    const wireframeMat = new THREE.MeshBasicMaterial({
        color: 0xf43f5e, // Crimson accent
        wireframe: true,
        transparent: true,
        opacity: 0.25
    });
    const wireframeMesh = new THREE.Mesh(wireframeGeo, wireframeMat);
    objectGroup.add(wireframeMesh);

    scene.add(objectGroup);

    // Lights
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
    scene.add(ambientLight);

    const dirLight1 = new THREE.DirectionalLight(0x3b82f6, 2.5); // Blue
    dirLight1.position.set(5, 5, 2);
    scene.add(dirLight1);

    const dirLight2 = new THREE.DirectionalLight(0xf43f5e, 2.5); // Pink
    dirLight2.position.set(-5, -5, 2);
    scene.add(dirLight2);

    const pointLight = new THREE.PointLight(0xffffff, 1);
    pointLight.position.set(0, 0, 5);
    scene.add(pointLight);

    // Interaction setup
    let mouseX = 0;
    let mouseY = 0;
    let targetX = 0;
    let targetY = 0;

    window.addEventListener('mousemove', (e) => {
        // Normalize mouse positions between -0.5 and 0.5
        mouseX = (e.clientX / window.innerWidth) - 0.5;
        mouseY = (e.clientY / window.innerHeight) - 0.5;
    });

    // Resize handler
    window.addEventListener('resize', () => {
        width = container.clientWidth;
        height = container.clientHeight;

        camera.aspect = width / height;
        camera.updateProjectionMatrix();

        renderer.setSize(width, height);
    });

    // Animation Loop
    const clock = new THREE.Clock();

    const animate = () => {
        requestAnimationFrame(animate);

        const elapsedTime = clock.getElapsedTime();

        // Standard auto-rotation if no drag
        if (controls) {
            controls.update();
        } else {
            objectGroup.rotation.y = elapsedTime * 0.2;
            objectGroup.rotation.x = elapsedTime * 0.1;
        }

        // Add subtle mouse lag movement
        targetX = mouseX * 1.5;
        targetY = mouseY * 1.5;

        objectGroup.position.x += (targetX - objectGroup.position.x) * 0.05;
        objectGroup.position.y += (-targetY - objectGroup.position.y) * 0.05;

        // Wave animation on geometry vertices if needed, otherwise dynamic scale pulsating
        const scaleVal = 1 + Math.sin(elapsedTime * 1.5) * 0.04;
        objectGroup.scale.set(scaleVal, scaleVal, scaleVal);

        // Render
        renderer.render(scene, camera);
    };

    animate();
});
</script>

<?php include 'app/views/layout/footer.php'; ?>
