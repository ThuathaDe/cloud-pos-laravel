<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cloud POS & Inventaris — Laravel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container">
      <span class="navbar-brand fw-bold">CloudPOS Laravel — Sistem Inventaris & Kasir Berbasis Cloud</span>
    </div>
  </nav>

  <div class="container">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="row g-4">
      <div class="col-md-5">
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-white fw-bold">1. Input Transaksi Kasir</div>
          <div class="card-body">
            <form action="{{ route('transaksi.store') }}" method="POST">
              @csrf
              <div class="mb-2">
                <label class="form-label">Pilih Produk</label>
                <select name="produk_id" class="form-select" required>
                  @foreach($produks as $p)
                    <option value="{{ $p->id }}">{{ $p->nama }} (Stok: {{ $p->stok }})</option>
                  @endforeach
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Jumlah Beli</label>
                <input type="number" name="jumlah" class="form-control" min="1" value="1" required>
              </div>
              <button type="submit" class="btn btn-success w-100">Proses Transaksi</button>
            </form>
          </div>
        </div>

        <div class="card shadow-sm">
          <div class="card-header bg-white fw-bold">2. Tambah Stok Produk Baru</div>
          <div class="card-body">
            <form action="{{ route('produk.store') }}" method="POST">
              @csrf
              <div class="mb-2">
                <input type="text" name="nama" class="form-control" placeholder="Nama Produk" required>
              </div>
              <div class="mb-2">
                <input type="number" name="harga" class="form-control" placeholder="Harga (Rp)" min="500" required>
              </div>
              <div class="mb-3">
                <input type="number" name="stok" class="form-control" placeholder="Stok Awal" min="1" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Simpan Produk</button>
            </form>
          </div>
        </div>
      </div>

      <div class="col-md-7">
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <span class="fw-bold">Daftar Inventaris (Cloud Database)</span>
            <a href="{{ route('pos.index') }}" class="btn btn-sm btn-outline-secondary">Refresh Data</a>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-bordered table-hover mb-0">
              <thead class="table-light">
                <tr>
                  <th>ID</th>
                  <th>Nama Produk</th>
                  <th>Harga</th>
                  <th>Sisa Stok</th>
                </tr>
              </thead>
              <tbody>
                @foreach($produks as $p)
                  <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->nama }}</td>
                    <td>Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                    <td>
                      <span class="badge {{ $p->stok > 5 ? 'bg-primary' : 'bg-danger' }}">
                        {{ $p->stok }}
                      </span>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <div class="card shadow-sm">
          <div class="card-header bg-white fw-bold">Riwayat Transaksi Terbaru</div>
          <div class="card-body table-responsive">
            <table class="table table-sm table-striped mb-0">
              <thead>
                <tr>
                  <th>Produk</th>
                  <th>Qty</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                @foreach($transaksis as $t)
                  <tr>
                    <td>{{ $t->nama_produk }}</td>
                    <td>{{ $t->jumlah }}</td>
                    <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>