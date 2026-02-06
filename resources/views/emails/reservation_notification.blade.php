<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #334155;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            width: 100%;
            padding: 40px 0;
            background-color: #f8fafc;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }

        .header {
            background: #0f172a;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }

        .header h2 {
            margin: 0;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-size: 24px;
        }

        .content {
            padding: 40px;
        }

        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 16px;
        }

        /* Role Badge */
        .role-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        .badge-admin {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .badge-user {
            background-color: #f0fdf4;
            color: #166534;
        }

        .status-hero {
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 500;
        }

        .status-confirmed {
            background-color: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .status-cancelled {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .status-pending {
            background-color: #fffbeb;
            color: #92400e;
            border: 1px solid #fef3c7;
        }

        .detail-card {
            background: #f1f5f9;
            border-radius: 12px;
            padding: 25px;
            margin: 20px 0;
        }

        .detail-item {
            display: flex;
            margin-bottom: 12px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 8px;
        }

        .detail-label {
            font-size: 13px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: 40%;
        }

        .detail-value {
            font-size: 15px;
            color: #0f172a;
            font-weight: 600;
            width: 60%;
            text-align: right;
        }

        .footer {
            padding: 30px;
            background: #f8fafc;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #0f172a;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <h2>ZOCCO COFFEE</h2>
            </div>

            <div class="content">
                @if ($role == 'admin')
                    <div class="role-badge badge-admin">Notifikasi Internal Admin</div>
                    <p class="greeting">Halo Tim {{ $reservation->outlet->name }},</p>
                    <p>Ada pesanan reservasi baru yang memerlukan perhatian Anda. Mohon segera periksa ketersediaan
                        meja.</p>
                @else
                    <div class="role-badge badge-user">Konfirmasi Reservasi</div>
                    <p class="greeting">Halo, {{ $reservation->customer_name }} 👋</p>
                @endif

                {{-- PESAN DINAMIS BERDASARKAN STATUS --}}
                @if ($reservation->status == 'confirmed')
                    <div class="status-hero status-confirmed">
                        ✨ Reservasi telah <strong>DIKONFIRMASI</strong>.
                    </div>
                @elseif($reservation->status == 'cancelled')
                    <div class="status-hero status-cancelled">
                        ⚠️ Reservasi telah <strong>DIBATALKAN</strong>.
                    </div>
                    @if ($reservation->rejection_reason)
                        <p
                            style="font-size: 14px; color: #991b1b; padding: 12px; border-left: 4px solid #ef4444; background: #fff1f2; border-radius: 4px;">
                            <strong>Alasan:</strong> {{ $reservation->rejection_reason }}
                        </p>
                    @endif
                @else
                    <div class="status-hero status-pending">
                        ☕ Status: <strong>MENUNGGU KONFIRMASI</strong>
                    </div>
                @endif

                <p style="margin-top: 25px; font-weight: bold; color: #1e293b;">Rincian Reservasi:</p>

                <div class="detail-card">
                    <div class="detail-item">
                        <span class="detail-label">ID Reservasi</span>
                        <span class="detail-value">#RES-{{ $reservation->id }}</span>
                    </div>

                    @if ($role == 'admin')
                        <div class="detail-item">
                            <span class="detail-label">Nama Tamu</span>
                            <span class="detail-value">{{ $reservation->customer_name }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">No. Telepon</span>
                            <span class="detail-value">{{ $reservation->phone_number }}</span>
                        </div>
                    @endif

                    <div class="detail-item">
                        <span class="detail-label">Outlet</span>
                        <span class="detail-value">{{ $reservation->outlet->name }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Waktu</span>
                        <span
                            class="detail-value">{{ \Carbon\Carbon::parse($reservation->reservation_date)->translatedFormat('d F Y, H:i') }}
                            WIB</span>
                    </div>
                    <div class="detail-item" style="border-bottom: none;">
                        <span class="detail-label">Tamu</span>
                        <span class="detail-value">{{ $reservation->guests }} Orang</span>
                    </div>
                </div>

                @if ($reservation->note)
                    <p style="font-size: 14px; color: #64748b; font-style: italic;">
                        <strong>Catatan Pelanggan:</strong> "{{ $reservation->note }}"
                    </p>
                @endif

                @if ($role == 'admin')
                    <div style="text-align: center;">
                        <a href="{{ url('/admin/reservasi') }}" class="button">Kelola di Dashboard</a>
                    </div>
                @elseif($reservation->status == 'confirmed')
                    <p style="font-size: 14px; text-align: center; color: #475569;">
                        Tunjukkan email ini kepada staf kami saat tiba di lokasi.
                    </p>
                    <div style="text-align: center;">
                        <a href="https://maps.google.com" class="button">Navigasi ke Lokasi</a>
                    </div>
                @endif
            </div>

            <div class="footer">
                <p>&copy; {{ date('Y') }} <strong>Zocco Coffee Indonesia</strong>. <br>
                    Sistem Manajemen Reservasi Terintegrasi.</p>
            </div>
        </div>
    </div>
</body>

</html>
