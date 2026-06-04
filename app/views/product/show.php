<?php $title = 'Chi tiết sản phẩm • COS340 Store'; ?>
<?php $product = $product ?? (object) ['id' => '', 'name' => '', 'description' => '', 'price' => 0, 'image' => '']; ?>
<?php $category = $category ?? (object) ['name' => '—']; ?>
<?php $cartCount = $cartCount ?? 0; ?>
<?php include 'app/views/layout/header.php'; ?>

<!-- Custom Styles for Product Detail Page -->
<style>
    .detail-hero {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.45) 0%, rgba(30, 41, 59, 0.2) 100%);
        border: var(--glass-border);
        border-radius: var(--radius-xl);
        padding: 2rem;
        margin-bottom: 2.5rem;
        box-shadow: var(--shadow-soft), var(--liquid-highlight);
    }
    .product-visual-wrapper {
        position: relative;
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: var(--glass-border);
        background: rgba(15, 23, 42, 0.4);
        box-shadow: var(--shadow-soft), var(--liquid-highlight);
    }
    .visual-toggle-bar {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 10;
        background: rgba(15, 23, 42, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 4px;
        border-radius: 999px;
        backdrop-filter: blur(10px);
        display: flex;
        gap: 4px;
    }
    .visual-toggle-btn {
        background: transparent;
        border: none;
        color: var(--text-soft);
        padding: 0.4rem 0.8rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .visual-toggle-btn.active {
        background: var(--brand-500);
        color: white;
        box-shadow: 0 0 10px rgba(59, 130, 246, 0.3);
    }
    .visual-container {
        width: 100%;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .visual-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.3s ease;
    }
    #three-detail-canvas {
        width: 100%;
        height: 100%;
        outline: none;
        cursor: grab;
        display: none;
    }
    #three-detail-canvas:active {
        cursor: grabbing;
    }
    .detail-canvas-hint {
        position: absolute;
        bottom: 15px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 0.3rem 0.8rem;
        border-radius: 999px;
        font-size: 0.7rem;
        color: var(--text-soft);
        pointer-events: none;
        backdrop-filter: blur(8px);
        display: none;
        align-items: center;
        gap: 0.35rem;
        z-index: 5;
    }
</style>

<!-- Detail Hero / Top Bar -->
<div class="detail-hero d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
    <div>
        <div class="d-inline-flex align-items-center gap-2 mb-2 small text-uppercase tracking-wider fw-semibold opacity-75">
            <i class="ph ph-sparkle text-primary"></i>
            <span>Thông tin chi tiết</span>
        </div>
        <h1 class="h3 fw-bold text-white mb-0"><?php echo htmlspecialchars($product->name); ?></h1>
    </div>
    <div class="d-flex gap-2">
        <a href="/phamgiahuy/product" class="btn btn-light d-flex align-items-center gap-2"><i class="ph ph-arrow-left"></i> Quay lại</a>
        <a href="/phamgiahuy/product/cart" class="btn btn-warning text-dark fw-semibold d-flex align-items-center gap-2">
            <i class="ph ph-shopping-cart"></i> Giỏ hàng
            <?php if ($cartCount > 0): ?>
                <span class="badge bg-dark text-white rounded-pill px-2"><?php echo $cartCount; ?></span>
            <?php endif; ?>
        </a>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="/phamgiahuy/product/edit/<?php echo $product->id; ?>" class="btn btn-glass d-flex align-items-center gap-2"><i class="ph ph-pencil-simple"></i> Chỉnh sửa</a>
        <?php endif; ?>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Visuals Container -->
    <div class="col-lg-5">
        <div class="product-visual-wrapper">
            <!-- Visual Toggle -->
            <div class="visual-toggle-bar">
                <button class="visual-toggle-btn active" id="btn-show-photo" onclick="toggleVisualMode('photo')">
                    <i class="ph ph-image"></i> Ảnh thực tế
                </button>
                <button class="visual-toggle-btn" id="btn-show-3d" onclick="toggleVisualMode('3d')">
                    <i class="ph ph-cube"></i> Mô hình 3D
                </button>
            </div>
            
            <!-- Visual Content -->
            <div class="visual-container">
                <?php if (!empty($product->image) && file_exists('uploads/' . $product->image)): ?>
                    <img src="/phamgiahuy/uploads/<?php echo htmlspecialchars($product->image); ?>" alt="<?php echo htmlspecialchars($product->name); ?>" class="visual-image" id="product-photo-img">
                <?php else: ?>
                    <div class="visual-image d-flex align-items-center justify-content-center bg-dark" id="product-photo-img">
                        <i class="ph ph-image-square text-muted" style="font-size: 4rem;"></i>
                    </div>
                <?php endif; ?>
                
                <canvas id="three-detail-canvas"></canvas>
                <div class="detail-canvas-hint" id="three-canvas-hint">
                    <i class="ph ph-hand-grabbing"></i> Xoay chuột để xem 360°
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Specs and Info -->
    <div class="col-lg-7">
        <div class="surface-card p-4 h-100 d-flex flex-column justify-content-between">
            <div>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge bg-secondary">ID: <?php echo $product->id; ?></span>
                    <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-10"><?php echo htmlspecialchars($category->name ?? 'Mặc định'); ?></span>
                </div>
                <h2 class="h3 fw-bold text-white mb-3"><?php echo htmlspecialchars($product->name); ?></h2>
                
                <div class="field-card mb-3">
                    <div class="text-muted small text-uppercase tracking-wider fw-semibold mb-1">Giá bán</div>
                    <div class="fs-3 fw-bold text-primary"><?php echo number_format($product->price, 0, ',', '.'); ?>đ</div>
                </div>
                
                <div class="field-card mb-4">
                    <div class="text-muted small text-uppercase tracking-wider fw-semibold mb-2">Mô tả sản phẩm</div>
                    <div class="text-white-50 lh-lg" style="white-space: pre-line;"><?php echo htmlspecialchars($product->description); ?></div>
                </div>
            </div>

            / <!-- Buy Card Form -->
            <div class="field-card mt-auto">
                <form action="/phamgiahuy/product/addToCart" method="POST" class="row g-3 align-items-end">
                    <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                    <input type="hidden" name="redirect_to" value="/phamgiahuy/product/show/<?php echo $product->id; ?>">
                    <div class="col-sm-4">
                        <label for="quantity" class="form-label text-muted small text-uppercase tracking-wider fw-semibold">Số lượng</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" step="1">
                    </div>
                    <div class="col-sm-8 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1 py-3 rounded-3 d-flex align-items-center justify-content-center gap-2">
                            <i class="ph ph-shopping-cart-simple" style="font-size: 1.25rem;"></i> Thêm vào giỏ
                        </button>
                        <a href="/phamgiahuy/product/cart" class="btn btn-glass px-3" title="Xem giỏ hàng">
                            <i class="ph ph-eye" style="font-size: 1.25rem;"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Three.js Visualizer logic -->
<script>
let scene, camera, renderer, objectGroup, controls;
let threeInitialized = false;

function toggleVisualMode(mode) {
    const photo = document.getElementById('product-photo-img');
    const canvas = document.getElementById('three-detail-canvas');
    const hint = document.getElementById('three-canvas-hint');
    const btnPhoto = document.getElementById('btn-show-photo');
    const btn3d = document.getElementById('btn-show-3d');

    if (mode === '3d') {
        photo.style.display = 'none';
        canvas.style.display = 'block';
        hint.style.display = 'flex';
        btnPhoto.classList.remove('active');
        btn3d.classList.add('active');

        if (!threeInitialized) {
            initThree();
        }
    } else {
        photo.style.display = 'block';
        canvas.style.display = 'none';
        hint.style.display = 'none';
        btnPhoto.classList.add('active');
        btn3d.classList.remove('active');
    }
}

function initThree() {
    const canvas = document.getElementById('three-detail-canvas');
    if (!canvas) return;

    if (typeof THREE === 'undefined') {
        console.error('Three.js not loaded.');
        return;
    }

    const container = canvas.parentElement;
    const width = container.clientWidth;
    const height = container.clientHeight;

    // Scene
    scene = new THREE.Scene();

    // Camera
    camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 100);
    camera.position.z = 6;

    // Renderer
    renderer = new THREE.WebGLRenderer({
        canvas: canvas,
        antialias: true,
        alpha: true
    });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setSize(width, height);
    renderer.shadowMap.enabled = true;

    // Controls
    if (typeof THREE.OrbitControls !== 'undefined') {
        controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;
        controls.dampingFactor = 0.05;
        controls.enableZoom = true;
        controls.autoRotate = true;
        controls.autoRotateSpeed = 1.0;
    }

    // Geometry Generation based on product category/name (procedural logic)
    const categoryName = "<?php echo addslashes($category->name ?? ''); ?>".toLowerCase();
    const productName = "<?php echo addslashes($product->name ?? ''); ?>".toLowerCase();

    objectGroup = new THREE.Group();
    let mainGeom;

    // Choose geometry shape based on text keywords
    if (categoryName.includes('laptop') || productName.includes('laptop') || productName.includes('macbook')) {
        // Futuristic double box (clam shell look)
        mainGeom = new THREE.BoxGeometry(1.6, 0.1, 1.2);
        const screenGeom = new THREE.BoxGeometry(1.6, 1.1, 0.08);
        const screenMesh = new THREE.Mesh(screenGeom, new THREE.MeshPhysicalMaterial({
            color: 0x0f172a, roughness: 0.1, metalness: 0.9, transmission: 0.3
        }));
        screenMesh.position.set(0, 0.55, -0.56);
        screenMesh.rotation.x = -0.15;
        objectGroup.add(screenMesh);
    } else if (categoryName.includes('phone') || productName.includes('phone') || productName.includes('iphone')) {
        // Rounded box (smartphone panel)
        mainGeom = new THREE.BoxGeometry(1.0, 1.9, 0.1);
    } else if (categoryName.includes('tai nghe') || productName.includes('tai nghe') || productName.includes('headphone')) {
        // Torus knot for abstract accessory
        mainGeom = new THREE.TorusGeometry(0.8, 0.25, 32, 100);
    } else {
        // Default premium shape: Refractive Octahedron or Dodecahedron
        mainGeom = new THREE.OctahedronGeometry(1.2, 0);
    }

    // Material with high-quality glassy refraction
    const glassMat = new THREE.MeshPhysicalMaterial({
        color: 0x3b82f6,
        metalness: 0.15,
        roughness: 0.05,
        transparent: true,
        opacity: 0.8,
        transmission: 0.7,
        ior: 1.45,
        clearcoat: 1.0,
        clearcoatRoughness: 0.05,
        side: THREE.DoubleSide
    });

    const mainMesh = new THREE.Mesh(mainGeom, glassMat);
    objectGroup.add(mainMesh);

    // Wireframe overlay for glowing look
    const wireframeMat = new THREE.MeshBasicMaterial({
        color: 0xf43f5e,
        wireframe: true,
        transparent: true,
        opacity: 0.3
    });
    const wireframeMesh = new THREE.Mesh(mainGeom.clone(), wireframeMat);
    wireframeMesh.scale.multiplyScalar(1.01);
    objectGroup.add(wireframeMesh);

    scene.add(objectGroup);

    // Lights
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.4);
    scene.add(ambientLight);

    const blueLight = new THREE.DirectionalLight(0x3b82f6, 2);
    blueLight.position.set(4, 4, 3);
    scene.add(blueLight);

    const pinkLight = new THREE.DirectionalLight(0xf43f5e, 2);
    pinkLight.position.set(-4, -4, 3);
    scene.add(pinkLight);

    const pointLight = new THREE.PointLight(0xffffff, 1.2, 10);
    pointLight.position.set(0, 0, 4);
    scene.add(pointLight);

    // Interaction handler
    let mouseX = 0, mouseY = 0;
    let targetX = 0, targetY = 0;
    window.addEventListener('mousemove', (e) => {
        mouseX = (e.clientX / window.innerWidth) - 0.5;
        mouseY = (e.clientY / window.innerHeight) - 0.5;
    });

    // Resize handler
    window.addEventListener('resize', () => {
        if (!threeInitialized) return;
        const w = container.clientWidth;
        const h = container.clientHeight;
        camera.aspect = w / h;
        camera.updateProjectionMatrix();
        renderer.setSize(w, h);
    });

    // Animation Loop
    const animate = () => {
        if (!threeInitialized) return;
        requestAnimationFrame(animate);

        if (controls) {
            controls.update();
        } else {
            objectGroup.rotation.y += 0.01;
            objectGroup.rotation.x += 0.005;
        }

        // Mouse follow lag
        targetX = mouseX * 1.0;
        targetY = mouseY * 1.0;
        objectGroup.position.x += (targetX - objectGroup.position.x) * 0.05;
        objectGroup.position.y += (-targetY - objectGroup.position.y) * 0.05;

        renderer.render(scene, camera);
    };

    threeInitialized = true;
    animate();
}
</script>

<?php include 'app/views/layout/footer.php'; ?>