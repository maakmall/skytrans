<?php

use Carbon\Carbon;

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('formatDate')) {
    function formatDate($date)
    {
        $formattedDate = explode(' ', Carbon::createFromFormat('Y-m-d', $date)->format('j F Y'));

        $formattedDate[1] = match ($formattedDate[1]) {
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'October' => 'Oktober',
            'December' => 'Desember',
        };

        return implode(' ', $formattedDate);
    }
}

if (! function_exists('timeAgo')) {
    function timeAgo($timestamp) {
        $now = now();
        $timeDiff = $now->diffInMilliseconds(\Carbon\Carbon::parse($timestamp));

        $intervals = [
            ['label' => 'tahun', 'value' => 1000 * 60 * 60 * 24 * 365],
            ['label' => 'bulan', 'value' => 1000 * 60 * 60 * 24 * 30],
            ['label' => 'minggu', 'value' => 1000 * 60 * 60 * 24 * 7],
            ['label' => 'hari', 'value' => 1000 * 60 * 60 * 24],
            ['label' => 'jam', 'value' => 1000 * 60 * 60],
            ['label' => 'menit', 'value' => 1000 * 60],
            ['label' => 'detik', 'value' => 1000],
        ];

        foreach ($intervals as $interval) {
            $count = floor($timeDiff / $interval['value']);
            if ($count >= 1) {
                return $count . ' ' . $interval['label'] . ' yang lalu';
            }
        }

        return 'Baru saja';
    }
}

if (! function_exists('mapDeliveryForQrCode')) {
    function mapDeliveryForQrCode($delivery) {
        return json_encode([
            'kode' => $delivery->qr_code,
            'no_surat_jalan' => $delivery->no,
            'pengirim' => $delivery->company_name,
            'tanggal_kirim' => $delivery->date,
            'kode_material' => $delivery->material_code,
            'nama_material' => $delivery->material_name,
            'no_plat_kendaraan' => $delivery->vehicle_plat_number,
            'jenis_kendaraan' => $delivery->vehicle_type,
            'kapasitas_maksimal_kendaraan' => $delivery->vehicle_max_capacity,
            'nama_supir' => $delivery->driver_name,
            'kontak_supir' => $delivery->driver_contact,
        ]);
    }
}

if (! function_exists('mapMaterialForUser')) {
    function mapMaterialForUser($materials) {
        $transformedData = [];

        foreach ($materials as $item) {
            $transformedData[] = [
                'id' => $item['id'],
                'code' => $item['material']['code'] ?? '-',
                'name' => $item['material']['name'] ?? '-',
            ];
        }

        return $transformedData;
    }
}
