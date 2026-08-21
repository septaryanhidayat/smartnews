@extends('layouts.admin')

@section('page_title', 'Kelola Kategori Berita')

@section('content')
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
    
    <!-- Add New Category Form -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Kategori Baru</h3>
        </div>
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nama Kategori *</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Contoh: Nasional" required>
            </div>
            <div class="form-group">
                <label for="slug">Slug URL (Opsional)</label>
                <input type="text" id="slug" name="slug" class="form-control" placeholder="nasional">
            </div>
            <div class="form-group">
                <label for="color">Warna Aksen</label>
                <input type="text" id="color" name="color" class="form-control" value="#1a56db" placeholder="#1a56db">
            </div>
            <div class="form-group">
                <label for="order">Urutan Menu</label>
                <input type="number" id="order" name="order" class="form-control" value="0">
            </div>
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description" class="form-control" rows="3" placeholder="Deskripsi singkat kategori..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                <i class="fas fa-plus"></i> Simpan Kategori
            </button>
        </form>
    </div>

    <!-- Category List Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Kategori ({{ $categories->count() }})</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Urutan</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Jumlah Berita</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                <tr>
                    <td>{{ $cat->order }}</td>
                    <td>
                        <strong style="color: {{ $cat->color }};">{{ $cat->name }}</strong>
                    </td>
                    <td><code>{{ $cat->slug }}</code></td>
                    <td><span class="badge badge-info">{{ $cat->articles_count }} Berita</span></td>
                    <td>
                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus kategori ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
