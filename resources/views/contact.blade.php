
<!DOCTYPE html>
<html>
<head>
    <title>Contact Beverly</title>
</head>
<body>

<h2>Hubungi Beverly</h2>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<form action="{{ route('contact.store') }}" method="POST">
    @csrf

    <input type="text" name="name" placeholder="Nama" required>
    <br><br>

    <input type="email" name="email" placeholder="Email" required>
    <br><br>

    <input type="text" name="subject" placeholder="Subjek" required>
    <br><br>

    <textarea name="message" placeholder="Tulis pesan..." required></textarea>
    <br><br>

    <button type="submit">Kirim Pesan</button>
</form>

</body>
</html>
