@extends('layouts.admin')

@section('page_title', 'Kelola Topik Tags')

@section('content')
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
    
    <!-- Add / Edit Tag Form -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title" id="tagFormTitle"><i class="fas fa-tag"></i> Tambah Tag Baru</h3>
            <button type="button" class="btn btn-sm btn-secondary" id="btnCancelTagEdit" style="display: none;" onclick="resetTagForm()">
                <i class="fas fa-times"></i> Batal Edit
            </button>
        </div>
        <form id="tagForm" action="{{ route('admin.tags.store') }}" method="POST">
            @csrf
            <div id="tagMethodField"></div>

            <div class="form-group">
                <label for="name">Nama Tag *</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Contoh: InfrastrukturPUPR" required>
            </div>

            <div class="form-group">
                <label for="slug">Slug URL (Opsional)</label>
                <input type="text" id="slug" name="slug" class="form-control" placeholder="infrastrukturpupr">
            </div>

            <button type="submit" id="tagSubmitBtn" class="btn btn-primary" style="width: 100%; justify-content: center;">
                <i class="fas fa-plus"></i> Simpan Tag
            </button>
        </form>
    </div>

    <!-- Tag List Table -->
    <div class="card">
        <div class="card-header" style="flex-wrap: wrap; gap: 12px;">
            <h3 class="card-title"><i class="fas fa-tags"></i> Daftar Tags ({{ $tags->total() }})</h3>
            <form action="{{ route('admin.tags.index') }}" method="GET" style="display: flex; gap: 8px;">
                <input type="text" name="search" class="form-control" style="max-width: 180px; padding: 4px 10px; font-size: 13px;" placeholder="Cari tag..." value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                @if($search ?? '')
                    <a href="{{ route('admin.tags.index') }}" class="btn btn-sm btn-secondary" style="background-color: #94a3b8; color: #fff;"><i class="fas fa-undo"></i></a>
                @endif
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nama Tag</th>
                    <th>Slug</th>
                    <th>Jumlah Berita</th>
                    <th style="width: 110px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tags as $tag)
                <tr>
                    <td><strong>#{{ $tag->name }}</strong></td>
                    <td><code>{{ $tag->slug }}</code></td>
                    <td><span class="badge badge-info">{{ $tag->articles_count }} Artikel</span></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary" title="Edit Tag" onclick="editTag({{ json_encode($tag) }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus tag #{{ $tag->name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 24px; color: var(--admin-muted);">
                        Tidak ada tag ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $tags->links() }}
        </div>
    </div>

</div>

@push('scripts')
<script>
    function editTag(tag) {
        document.getElementById('tagFormTitle').innerHTML = '<i class="fas fa-edit"></i> Edit Tag: #' + tag.name;
        document.getElementById('tagForm').action = '/admin/tags/' + tag.id;
        document.getElementById('tagMethodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        
        document.getElementById('name').value = tag.name;
        document.getElementById('slug').value = tag.slug;
        
        document.getElementById('tagSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Perbarui Tag';
        document.getElementById('btnCancelTagEdit').style.display = 'inline-flex';
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function resetTagForm() {
        document.getElementById('tagFormTitle').innerHTML = '<i class="fas fa-tag"></i> Tambah Tag Baru';
        document.getElementById('tagForm').action = "{{ route('admin.tags.store') }}";
        document.getElementById('tagMethodField').innerHTML = '';
        
        document.getElementById('name').value = '';
        document.getElementById('slug').value = '';
        
        document.getElementById('tagSubmitBtn').innerHTML = '<i class="fas fa-plus"></i> Simpan Tag';
        document.getElementById('btnCancelTagEdit').style.display = 'none';
    }
</script>
@endpush
@endsection
