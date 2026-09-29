@extends('layouts.app')

@section('title', 'Pesan Customer')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="display:flex; align-items:flex-end; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
        <div>
            <h1 style="margin: 0; font-size: 1.6rem; color: var(--secondary-color);">Pesan Customer</h1>
            <p style="margin: 0.35rem 0 0; color: var(--accent-color);">Daftar pesan yang dikirim melalui halaman Kontak.</p>
        </div>
    </div>

    <div style="margin-top: 1.25rem; background: var(--white); border-radius: 12px; box-shadow: var(--shadow); overflow: hidden;">
        <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #eee; display:flex; align-items:center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
            <h2 style="margin: 0; font-size: 1.1rem; color: var(--secondary-color);">Inbox</h2>
            <div style="color: var(--accent-color); font-size: 0.9rem;">Total: {{ $messages->count() }}</div>
        </div>

        @if($messages->isEmpty())
            <div style="padding: 1.25rem; color: var(--accent-color);">Belum ada pesan masuk.</div>
        @else
            <div style="padding: 1.25rem; overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; min-width: 780px;">
                    <thead>
                        <tr style="text-align:left; color: var(--secondary-color);">
                            <th style="padding: 0.75rem; border-bottom: 1px solid #eee;">Waktu</th>
                            <th style="padding: 0.75rem; border-bottom: 1px solid #eee;">Nama</th>
                            <th style="padding: 0.75rem; border-bottom: 1px solid #eee;">Email</th>
                            <th style="padding: 0.75rem; border-bottom: 1px solid #eee;">Telepon</th>
                            <th style="padding: 0.75rem; border-bottom: 1px solid #eee;">Subjek</th>
                            <th style="padding: 0.75rem; border-bottom: 1px solid #eee;">Pesan</th>
                        </tr>
                    </thead>
                    <tbody style="color: var(--text-color);">
                        @foreach($messages as $message)
                            <tr>
                                <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2; white-space: nowrap; color: var(--accent-color);">
                                    {{ $message->created_at?->format('d M Y, H:i') }}
                                </td>
                                <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2; font-weight: 700;">
                                    {{ $message->name }}
                                </td>
                                <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2;">
                                    <a href="mailto:{{ $message->email }}" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">{{ $message->email }}</a>
                                </td>
                                <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2; white-space: nowrap;">
                                    {{ $message->phone }}
                                </td>
                                <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2;">
                                    {{ $message->subject }}
                                </td>
                                <td style="padding: 0.75rem; border-bottom: 1px solid #f2f2f2; line-height: 1.5;">
                                    {!! nl2br(e($message->message)) !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
