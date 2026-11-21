@extends('admin.layout')

@section('title', 'Pesan Masuk - Beverly')
@section('topbar', 'Pesan Masuk')

@section('content')

<div class="page-title">
    <h1>Pesan Masuk</h1>
    <p>Lihat dan kelola pesan yang dikirim oleh pelanggan Beverly.</p>
</div>

<div class="card">

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <h3 style="margin-bottom:20px;">Daftar Pesan Pelanggan</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Subjek</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($messages as $message)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $message->name }}</td>
                    <td>{{ $message->email }}</td>
                    <td>{{ $message->subject }}</td>

                    <td>
                        @if($message->is_read)
                            <span class="status status-read">Sudah dibaca</span>
                        @else
                            <span class="status status-unread">Belum dibaca</span>
                        @endif
                    </td>

                    <td>
                        <div class="actions">
                            <a href="{{ route('admin.messages.read', $message->id) }}"
                               class="btn btn-gold">Lihat</a>

                            <form action="{{ route('admin.messages.delete', $message->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:30px;">
                        Belum ada pesan masuk.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
