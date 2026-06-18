import $ from 'jquery'

const API = 'http://localhost:88/phamgiahuy/api'
let currentTab = 'products'
let currentFormType = 'product' as 'product' | 'category'

interface Product {
  id: number
  name: string
  description: string
  price: number
  category_id: number
  category_name: string
}

interface Category {
  id: number
  name: string
  description: string
}

interface User {
  id: number
  username: string
  fullname: string
  role: string
}

// --- Auth ---
function getToken(): string | null {
  return localStorage.getItem('jwt_token')
}

function getUser(): User | null {
  const raw = localStorage.getItem('jwt_user')
  return raw ? JSON.parse(raw) : null
}

function saveAuth(token: string, user: User) {
  localStorage.setItem('jwt_token', token)
  localStorage.setItem('jwt_user', JSON.stringify(user))
}

function clearAuth() {
  localStorage.removeItem('jwt_token')
  localStorage.removeItem('jwt_user')
}

function isLoggedIn(): boolean {
  return !!getToken()
}

function updateAuthUI() {
  const user = getUser()
  if (user) {
    $('#auth-section').html(`
      <span class="text-light me-2">
        <i class="fas fa-user-circle me-1"></i>${escapeHtml(user.fullname)} (${escapeHtml(user.role)})
      </span>
      <button class="btn btn-sm btn-outline-light" id="btn-logout">
        <i class="fas fa-right-from-bracket me-1"></i>Đăng xuất
      </button>
    `)
  } else {
    $('#auth-section').html(`
      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
        <i class="fas fa-right-to-bracket me-1"></i>Đăng nhập
      </button>
    `)
  }
}

$('#auth-section').on('click', '#btn-logout', () => {
  clearAuth()
  updateAuthUI()
  showToast('success', 'Đăng xuất', 'Bạn đã đăng xuất thành công.')
})

// --- Login Modal ---
$('#btn-login').on('click', async () => {
  const username = ($('#login-username').val() as string).trim()
  const password = ($('#login-password').val() as string).trim()

  if (!username || !password) {
    $('#login-error').text('Vui lòng nhập đầy đủ thông tin.').show()
    return
  }

  try {
    const resp = await fetch(`${API}/account`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ username, password })
    })

    const data = await resp.json()

    if (!resp.ok) {
      $('#login-error').text(data.error || 'Đăng nhập thất bại.').show()
      return
    }

    saveAuth(data.token, data.user);
    (window as any).bootstrap.Modal.getInstance('#loginModal')?.hide()
    $('#login-username').val('')
    $('#login-password').val('')
    $('#login-error').hide()
    updateAuthUI()
    showToast('success', 'Đăng nhập thành công', `Xin chào ${data.user.fullname}!`)
  } catch {
    $('#login-error').text('Lỗi kết nối.').show()
  }
})

// --- Toast ---
function showToast(type: 'success' | 'error' | 'info', title: string, message: string) {
  const icons: Record<string, string> = { success: 'fa-circle-check', error: 'fa-circle-exclamation', info: 'fa-circle-info' }
  const toast = $(`
    <div class="toast align-items-center text-bg-${type === 'error' ? 'danger' : type} border-0 show" role="alert">
      <div class="d-flex">
        <div class="toast-body">
          <i class="fas ${icons[type] ?? icons.info} me-2"></i>
          <strong>${escapeHtml(title)}</strong> ${escapeHtml(message)}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  `)
  $('#toast-container').append(toast)
  setTimeout(() => toast.fadeOut(300, () => toast.remove()), 4000)
}

// --- Auth Fetch Wrapper ---
async function authFetch(url: string, options: RequestInit = {}) {
  const token = getToken()
  const headers: Record<string, string> = {
    'Content-Type': 'application/json',
    ...((options.headers as Record<string, string>) || {})
  }
  if (token) {
    headers['Authorization'] = `Bearer ${token}`
  }

  const resp = await fetch(url, { ...options, headers })

  if (resp.status === 401) {
    showToast('error', 'Chưa đăng nhập', 'Vui lòng đăng nhập để thực hiện thao tác này.')
    return null
  }
  if (resp.status === 403) {
    showToast('error', 'Không có quyền', 'Bạn không có quyền thực hiện thao tác này.')
    return null
  }
  return resp
}

// --- Tabs ---
$('#mainTabs').on('click', '.nav-link', function () {
  const tab = $(this).data('tab') as string
  currentTab = tab
  $('#mainTabs .nav-link').removeClass('active')
  $(this).addClass('active')

  if (tab === 'products') {
    $('#products-section').show()
    $('#categories-section').hide()
    loadProducts()
  } else if (tab === 'categories') {
    $('#products-section').hide()
    $('#categories-section').show()
    loadCategories()
  }
})

// --- Products ---
async function loadProducts() {
  $('#products-loading').show()
  $('#products-table-wrap').hide()
  $('#products-empty').hide()

  try {
    const resp = await fetch(`${API}/product`)
    const data: Product[] = await resp.json()
    $('#products-loading').hide()

    if (!data.length) {
      $('#products-empty').show()
      return
    }

    const user = getUser()
    const isAdmin = user?.role === 'admin'

    const tbody = $('#products-tbody').empty()
    data.forEach(p => {
      tbody.append(`
        <tr>
          <td>${p.id}</td>
          <td>${escapeHtml(p.name)}</td>
          <td>${escapeHtml(truncate(p.description, 50))}</td>
          <td>${formatPrice(p.price)}đ</td>
          <td>${escapeHtml(p.category_name || '-')}</td>
          <td>
            ${isAdmin ? `
              <button class="btn btn-sm btn-outline-info me-1 edit-product" data-id="${p.id}" title="Sửa">
                <i class="fas fa-pen"></i>
              </button>
              <button class="btn btn-sm btn-outline-danger delete-product" data-id="${p.id}" title="Xóa">
                <i class="fas fa-trash"></i>
              </button>
            ` : ''}
          </td>
        </tr>
      `)
    })
    $('#products-table-wrap').show()
  } catch {
    $('#products-loading').hide()
    $('#products-empty').show().text('Lỗi tải dữ liệu.')
  }
}

$('#btn-add-product').on('click', () => openProductForm())

$('#products-tbody').on('click', '.edit-product', async function () {
  const id = $(this).data('id')
  const resp = await fetch(`${API}/product/${id}`)
  const product: Product = await resp.json()
  openProductForm(product)
})

$('#products-tbody').on('click', '.delete-product', async function () {
  const id = $(this).data('id')
  if (!confirm('Xóa sản phẩm này?')) return
  const resp = await authFetch(`${API}/product/${id}`, { method: 'DELETE' })
  if (!resp) return
  const data = await resp.json()
  if (resp.ok) {
    showToast('success', 'Thành công', 'Sản phẩm đã được xóa.')
    loadProducts()
  } else {
    showToast('error', 'Lỗi', data.error || 'Xóa sản phẩm thất bại.')
  }
})

function openProductForm(product?: Product) {
  currentFormType = 'product'
  $('#modal-title').text(product ? `Sửa sản phẩm #${product.id}` : 'Thêm sản phẩm mới')
  $('#form-id').val(product?.id ?? '')
  $('#modal-errors').hide()

  $('#form-fields').html(`
    <div class="mb-3">
      <label class="form-label">Tên sản phẩm *</label>
      <input type="text" class="form-control" id="field-name" value="${escapeAttr(product?.name ?? '')}" required />
    </div>
    <div class="mb-3">
      <label class="form-label">Mô tả</label>
      <textarea class="form-control" id="field-description" rows="3">${escapeHtml(product?.description ?? '')}</textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Giá *</label>
      <input type="number" class="form-control" id="field-price" value="${product?.price ?? ''}" step="0.01" min="0" required />
    </div>
    <div class="mb-3">
      <label class="form-label">Danh mục ID *</label>
      <select class="form-select" id="field-category_id" required>
        <option value="">-- Chọn --</option>
      </select>
    </div>
  `)

  loadCategoryOptions(product?.category_id)
  new (window as any).bootstrap.Modal('#formModal').show()
}

async function loadCategoryOptions(selectedId?: number) {
  const resp = await fetch(`${API}/category`)
  const categories: Category[] = await resp.json()
  const select = $('#field-category_id')
  select.find('option:gt(0)').remove()
  categories.forEach(c => {
    const selected = c.id === selectedId ? 'selected' : ''
    select.append(`<option value="${c.id}" ${selected}>${escapeHtml(c.name)}</option>`)
  })
}

// --- Categories ---
async function loadCategories() {
  $('#categories-loading').show()
  $('#categories-table-wrap').hide()
  $('#categories-empty').hide()

  try {
    const resp = await fetch(`${API}/category`)
    const data: Category[] = await resp.json()
    $('#categories-loading').hide()

    if (!data.length) {
      $('#categories-empty').show()
      return
    }

    const user = getUser()
    const isAdmin = user?.role === 'admin'

    const tbody = $('#categories-tbody').empty()
    data.forEach(c => {
      tbody.append(`
        <tr>
          <td>${c.id}</td>
          <td>${escapeHtml(c.name)}</td>
          <td>${escapeHtml(truncate(c.description, 60))}</td>
          <td>
            ${isAdmin ? `
              <button class="btn btn-sm btn-outline-info me-1 edit-category" data-id="${c.id}" title="Sửa">
                <i class="fas fa-pen"></i>
              </button>
              <button class="btn btn-sm btn-outline-danger delete-category" data-id="${c.id}" title="Xóa">
                <i class="fas fa-trash"></i>
              </button>
            ` : ''}
          </td>
        </tr>
      `)
    })
    $('#categories-table-wrap').show()
  } catch {
    $('#categories-loading').hide()
    $('#categories-empty').show().text('Lỗi tải dữ liệu.')
  }
}

$('#btn-add-category').on('click', () => openCategoryForm())

$('#categories-tbody').on('click', '.edit-category', async function () {
  const id = $(this).data('id')
  const resp = await fetch(`${API}/category/${id}`)
  const category: Category = await resp.json()
  openCategoryForm(category)
})

$('#categories-tbody').on('click', '.delete-category', async function () {
  const id = $(this).data('id')
  if (!confirm('Xóa danh mục này?')) return
  const resp = await authFetch(`${API}/category/${id}`, { method: 'DELETE' })
  if (!resp) return
  const data = await resp.json()
  if (resp.ok) {
    showToast('success', 'Thành công', 'Danh mục đã được xóa.')
    loadCategories()
  } else {
    showToast('error', 'Lỗi', data.error || 'Xóa danh mục thất bại.')
  }
})

function openCategoryForm(category?: Category) {
  currentFormType = 'category'
  $('#modal-title').text(category ? `Sửa danh mục #${category.id}` : 'Thêm danh mục mới')
  $('#form-id').val(category?.id ?? '')
  $('#modal-errors').hide()

  $('#form-fields').html(`
    <div class="mb-3">
      <label class="form-label">Tên danh mục *</label>
      <input type="text" class="form-control" id="field-name" value="${escapeAttr(category?.name ?? '')}" required />
    </div>
    <div class="mb-3">
      <label class="form-label">Mô tả</label>
      <textarea class="form-control" id="field-description" rows="3">${escapeHtml(category?.description ?? '')}</textarea>
    </div>
  `)

  new (window as any).bootstrap.Modal('#formModal').show()
}

// --- Save ---
$('#btn-save').on('click', async () => {
  const id = $('#form-id').val() as string
  const name = ($('#field-name').val() as string).trim()
  const description = ($('#field-description').val() as string).trim()
  const isEdit = !!id
  const url = isEdit ? `${API}/${currentFormType}/${id}` : `${API}/${currentFormType}`
  const method = isEdit ? 'PUT' : 'POST'

  const body: Record<string, string | number> = { name, description }

  if (currentFormType === 'product') {
    body.price = parseFloat($('#field-price').val() as string) || 0
    body.category_id = parseInt($('#field-category_id').val() as string) || 0
  }

  const resp = await authFetch(url, {
    method,
    body: JSON.stringify(body)
  })

  if (!resp) return

  const result = await resp.json()

  if (resp.ok) {
    ;(window as any).bootstrap.Modal.getInstance('#formModal')?.hide()
    showToast('success', 'Thành công', isEdit ? 'Cập nhật thành công.' : 'Tạo mới thành công.')
    currentTab === 'products' ? loadProducts() : loadCategories()
  } else {
    const msgs = result.errors?.join('<br>') ?? result.error ?? 'Lỗi không xác định'
    $('#modal-errors').html(msgs).show()
  }
})

// --- Utils ---
function escapeHtml(text: string): string {
  if (!text) return ''
  const d = document.createElement('div')
  d.textContent = text
  return d.innerHTML
}

function escapeAttr(text: string): string {
  return text.replace(/"/g, '&quot;').replace(/'/g, '&#39;')
}

function truncate(text: string, len: number): string {
  if (!text) return ''
  return text.length > len ? text.substring(0, len) + '...' : text
}

function formatPrice(price: number): string {
  return new Intl.NumberFormat('vi-VN').format(price)
}

// --- Init ---
updateAuthUI()
loadProducts()
