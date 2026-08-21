@extends('layouts.admin')

@section('page_title', 'Kelola Topik Tags')

@section('content')
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
    
    <!-- Add Tag Form -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Tag Baru</h3>
        </div>
        <form action="{{ route('admin.tags.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nama Tag *</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Contoh: InfrastrukturPUPR" required>
            </div>
            <div class="form-group">
                <label for="slug">Slug (Opsional)</label>
                <input type="text" id="slug" name="slug" class="form-control" placeholder="infrastrukturpupr">
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                <i class="fas fa-plus"></i> Simpan Tag
            </button>
        </form>
    </div>

    <!-- Tag List Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Tags ({{ $tags->total() }})</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nama Tag</th>
                    <th>Slug</th>
                    <th>Jumlah Berita</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tags as $tag)
                <tr>
                    <td><strong>#{{ $tag->name }}</strong></td>
                    <td><code>{{ $tag->slug }}</code></td>
                    <td><span class="badge badge-info">{{ $tag->articles_count }} Artikel</span></td>
                    <td>
                        <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus tag ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $tags->links() }}
        </div>
    </div>

</div>
@endsection
