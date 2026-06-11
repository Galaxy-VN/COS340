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

// --- Tabs ---
$('#mainTabs').on('click', '.nav-link', function () {
  const tab = $(this).data('tab') as string
  currentTab = tab
  $('#mainTabs .nav-link').removeClass('active')
  $(this).addClass('active')

  if (tab === 'products') {
    $('#products-section').show()
    $('#categories-section').hide()
    $('#docs-section').hide()
    loadProducts()
  } else if (tab === 'categories') {
    $('#products-section').hide()
    $('#categories-section').show()
    $('#docs-section').hide()
    loadCategories()
  } else if (tab === 'docs') {
    $('#products-section').hide()
    $('#categories-section').hide()
    $('#docs-section').show()
  }
})

// --- Products ---
async function loadProducts() {
  $('#products-loading').show()
  $('#products-table-wrap').hide()
  $('#products-empty').hide()

  try {
    const data: Product[] = await $.getJSON(`${API}/product`)
    $('#products-loading').hide()

    if (!data.length) {
      $('#products-empty').show()
      return
    }

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
            <button class="btn btn-sm btn-outline-info me-1 edit-product" data-id="${p.id}" title="Sửa">
              <i class="fas fa-pen"></i>
            </button>
            <button class="btn btn-sm btn-outline-danger delete-product" data-id="${p.id}" title="Xóa">
              <i class="fas fa-trash"></i>
            </button>
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
  const product: Product = await $.getJSON(`${API}/product/${id}`)
  openProductForm(product)
})

$('#products-tbody').on('click', '.delete-product', async function () {
  const id = $(this).data('id')
  if (!confirm('Xóa sản phẩm này?')) return
  await $.ajax({ url: `${API}/product/${id}`, method: 'DELETE' })
  loadProducts()
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
  const categories: Category[] = await $.getJSON(`${API}/category`)
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
    const data: Category[] = await $.getJSON(`${API}/category`)
    $('#categories-loading').hide()

    if (!data.length) {
      $('#categories-empty').show()
      return
    }

    const tbody = $('#categories-tbody').empty()
    data.forEach(c => {
      tbody.append(`
        <tr>
          <td>${c.id}</td>
          <td>${escapeHtml(c.name)}</td>
          <td>${escapeHtml(truncate(c.description, 60))}</td>
          <td>
            <button class="btn btn-sm btn-outline-info me-1 edit-category" data-id="${c.id}" title="Sửa">
              <i class="fas fa-pen"></i>
            </button>
            <button class="btn btn-sm btn-outline-danger delete-category" data-id="${c.id}" title="Xóa">
              <i class="fas fa-trash"></i>
            </button>
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
  const category: Category = await $.getJSON(`${API}/category/${id}`)
  openCategoryForm(category)
})

$('#categories-tbody').on('click', '.delete-category', async function () {
  const id = $(this).data('id')
  if (!confirm('Xóa danh mục này?')) return
  await $.ajax({ url: `${API}/category/${id}`, method: 'DELETE' })
  loadCategories()
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

  try {
    const resp = await fetch(url, {
      method,
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(body)
    })

    const result = await resp.json()

    if (resp.ok) {
      ;(window as any).bootstrap.Modal.getInstance('#formModal')?.hide()
      currentTab === 'products' ? loadProducts() : loadCategories()
    } else {
      const msgs = result.errors?.join('<br>') ?? result.error ?? 'Lỗi không xác định'
      $('#modal-errors').html(msgs).show()
    }
  } catch {
    $('#modal-errors').html('Lỗi kết nối.').show()
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
loadProducts()
