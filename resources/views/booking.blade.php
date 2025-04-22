<form method="POST" action="{{ route('booking.store') }}">
    @csrf
    <input type="text" name="nama_pelanggan" placeholder="Nama Pelanggan" required>
    <input type="number" name="jumlah_mobil" placeholder="Jumlah Mobil" required min="1">
    <input type="datetime-local" name="waktu_mulai" required>
    <button type="submit">Booking</button>
</form>
