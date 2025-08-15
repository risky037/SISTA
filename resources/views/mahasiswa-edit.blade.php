<h1>Edit Mahasiswa</h1>
<form action="{{ route('mahasiswa.update', $mahasiswa->id) }}" method="POST">
    @csrf
    @method('PUT')
    Nama: <input type="text" name="nama" value="{{ $mahasiswa->nama }}"><br>
    NIM: <input type="text" name="nim" value="{{ $mahasiswa->nim }}"><br>
    Jurusan: <input type="text" name="jurusan" value="{{ $mahasiswa->jurusan }}"><br>
    Email: <input type="email" name="email" value="{{ $mahasiswa->email }}"><br>
    <button type="submit">Update</button>
</form>
