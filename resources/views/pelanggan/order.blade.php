@extends('layouts.appPelanggan')

@section('title', 'Dashboard Penjahit')

@section('content')
    {{-- <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data"> --}}
    @csrf

    <!-- Pilih Kategori -->
    <div class="mb-3">
        <label for="kategori" class="form-label">Pilih Kategori</label>
        <select id="kategori" name="kategori" class="form-select" required>
            <option value="" disabled selected>-- Pilih Kategori --</option>
            <option value="atasan">Atasan</option>
            <option value="bawahan">Bawahan</option>
            <option value="terusan">Terusan</option>
        </select>
    </div>

    <!-- Form Detail Produk -->
    <div id="form-detail" style="display: none;">
        <div class="mb-2">
            <label for="jenis_kain" class="form-label">Jenis Kain</label>
            <input type="text" name="jenis_kain" id="jenis_kain" class="form-control" required>
        </div>

        <div class="mb-2">
            <label for="warna" class="form-label">Warna</label>
            <input type="text" name="warna" id="warna" class="form-control" required>
        </div>

        <div class="mb-2">
            <label for="ukuran" class="form-label">Ukuran</label>
            <input type="text" name="ukuran" id="ukuran" class="form-control" required>
        </div>

        <div class="mb-2">
            <label for="deskripsi" class="form-label">Deskripsi Tambahan</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="images" class="form-label">Upload Gambar (maks. 10)</label>
            <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple required>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
document.getElementById("kategori").addEventListener("change", function () {
    const formDetail = document.getElementById("form-detail");
    formDetail.style.display = this.value !== "" ? "block" : "none";
});

document.getElementById("images").addEventListener("change", function () {
    if (this.files.length > 10) {
        alert("Maksimal 10 gambar yang bisa diunggah.");
        this.value = "";
    }
});
</script>

@endsection


