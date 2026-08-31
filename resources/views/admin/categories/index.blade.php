@extends('layouts.admin')

@section('page_title', 'Kelola Kategori Berita')

@section('content')
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
    
    <!-- Add / Edit Category Form -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title" id="formTitle"><i class="fas fa-folder-plus"></i> Tambah Kategori Baru</h3>
            <button type="button" class="btn btn-sm btn-secondary" id="btnCancelEdit" style="display: none;" onclick="resetForm()">
                <i class="fas fa-times"></i> Batal Edit
            </button>
        </div>
        <form id="categoryForm" action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div id="methodField"></div>

            <div class="form-group">
                <label for="name">Nama Kategori *</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Contoh: Nasional" required>
            </div>

            <div class="form-group">
                <label for="slug">Slug URL (Opsional)</label>
                <input type="text" id="slug" name="slug" class="form-control" placeholder="nasional">
            </div>

            <div class="form-group">
                <label for="color">Warna Label Kategori</label>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                    <input type="color" id="colorPicker" value="#1a56db" style="width: 44px; height: 38px; border: 1px solid var(--admin-border); border-radius: 6px; padding: 2px; cursor: pointer;">
                    <input type="text" id="color" name="color" class="form-control" value="#1a56db" placeholder="#1a56db" style="flex: 1;">
                </div>
                <!-- Quick Palette Presets -->
                <div style="display: flex; gap: 6px; flex-wrap: wrap; align-items: center;">
                    <span style="font-size: 11px; color: var(--admin-muted); margin-right: 4px;">Pilihan Cepat:</span>
                    @php
                        $presets = ['#1a56db', '#dc2626', '#059669', '#d97706', '#7c3aed', '#0284c7', '#db2777', '#475569', '#ea580c', '#0d9488'];
                    @endphp
                    @foreach($presets as $pColor)
                        <button type="button" onclick="selectColor('{{ $pColor }}')" style="width: 22px; height: 22px; border-radius: 50%; background-color: {{ $pColor }}; border: 2px solid #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.2); cursor: pointer;" title="{{ $pColor }}"></button>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label for="order">Urutan Tampilan Menu</label>
                <input type="number" id="order" name="order" class="form-control" value="0">
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description" class="form-control" rows="3" placeholder="Deskripsi singkat rubrik berita..."></textarea>
            </div>

            <button type="submit" id="submitBtn" class="btn btn-primary" style="width: 100%; justify-content: center;">
                <i class="fas fa-plus"></i> Simpan Kategori
            </button>
        </form>
    </div>

    <!-- Category List Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-list"></i> Daftar Kategori ({{ $categories->count() }})</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width: 60px;">Urutan</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Jumlah Berita</th>
                    <th style="width: 110px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                <tr>
                    <td><strong>{{ $cat->order }}</strong></td>
                    <td>
                        <span style="display: inline-flex; align-items: center; gap: 6px; font-weight: 700; color: {{ $cat->color }};">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background-color: {{ $cat->color }}; display: inline-block;"></span>
                            {{ $cat->name }}
                        </span>
                        @if($cat->description)
                            <div style="font-size: 11.5px; color: var(--admin-muted); margin-top: 2px;">{{ Str::limit($cat->description, 50) }}</div>
                        @endif
                    </td>
                    <td><code>{{ $cat->slug }}</code></td>
                    <td><span class="badge badge-info">{{ $cat->articles_count }} Berita</span></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary" title="Edit Kategori" onclick="editCategory({{ json_encode($cat) }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus kategori {{ $cat->name }}? Seluruh berita dalam kategori ini akan terpengaruh.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@push('scripts')
<script>
    const colorPicker = document.getElementById('colorPicker');
    const colorInput = document.getElementById('color');

    colorPicker.addEventListener('input', (e) => {
        colorInput.value = e.target.value;
    });

    colorInput.addEventListener('input', (e) => {
        if (/^#[0-9A-Fa-f]{6}$/.test(e.target.value)) {
            colorPicker.value = e.target.value;
        }
    });

    function selectColor(hex) {
        colorPicker.value = hex;
        colorInput.value = hex;
    }

    function editCategory(cat) {
        document.getElementById('formTitle').innerHTML = '<i class="fas fa-edit"></i> Edit Kategori: ' + cat.name;
        document.getElementById('categoryForm').action = '/admin/categories/' + cat.id;
        document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        
        document.getElementById('name').value = cat.name;
        document.getElementById('slug').value = cat.slug;
        document.getElementById('color').value = cat.color || '#1a56db';
        document.getElementById('colorPicker').value = cat.color || '#1a56db';
        document.getElementById('order').value = cat.order || 0;
        document.getElementById('description').value = cat.description || '';
        
        document.getElementById('submitBtn').innerHTML = '<i class="fas fa-save"></i> Perbarui Kategori';
        document.getElementById('btnCancelEdit').style.display = 'inline-flex';
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function resetForm() {
        document.getElementById('formTitle').innerHTML = '<i class="fas fa-folder-plus"></i> Tambah Kategori Baru';
        document.getElementById('categoryForm').action = "{{ route('admin.categories.store') }}";
        document.getElementById('methodField').innerHTML = '';
        
        document.getElementById('name').value = '';
        document.getElementById('slug').value = '';
        document.getElementById('color').value = '#1a56db';
        document.getElementById('colorPicker').value = '#1a56db';
        document.getElementById('order').value = 0;
        document.getElementById('description').value = '';
        
        document.getElementById('submitBtn').innerHTML = '<i class="fas fa-plus"></i> Simpan Kategori';
        document.getElementById('btnCancelEdit').style.display = 'none';
    }
</script>
@endpush
@endsection
