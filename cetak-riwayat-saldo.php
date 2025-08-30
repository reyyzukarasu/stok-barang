<?php
require_once "config/db.php";
require("fpdf/fpdf.php");

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Riwayat Top Up & Tarik Saldo', 0, 1, 'C');
        $this->Ln(3);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(10, 30, 'No', 1, 0, 'C');
        $this->Cell(25, 30, 'Tipe', 1, 0, 'C');
        $this->Cell(25, 30, 'Metode', 1, 0, 'C');
        $this->Cell(25, 30, 'Jumlah', 1, 0, 'C');
        $this->Cell(35, 30, 'Bukti', 1, 0, 'C');
        $this->Cell(35, 30, 'Tanggal', 1, 0, 'C');
        $this->Ln();
    }
}

function formatTanggalIndonesia($datetime)
{
    $bulan = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];
    $timestamp = strtotime($datetime);
    $tgl = date('j', $timestamp);
    $bln = $bulan[(int) date('n', $timestamp)];
    $thn = date('Y', $timestamp);
    $jam = date('H:i', $timestamp);
    return "$tgl $bln $thn $jam";
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

$query = "SELECT * FROM balance_logs ORDER BY created_at DESC";
$result = $conn->query($query);
$no = 1;

while ($row = $result->fetch_assoc()) {
    $pdf->Cell(10, 30, $no++, 1, 0, 'C');
    $pdf->Cell(25, 30, ucfirst($row['type']), 1, 0, 'C');
    $pdf->Cell(25, 30, ucfirst($row['method']), 1, 0, 'C');
    $pdf->Cell(25, 30, 'Rp' . number_format($row['amount']), 1, 0, 'L');

    // Gambar bukti (jika ada dan file-nya ada)
    if ($row['proof'] && file_exists($row['proof'])) {
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->Cell(35, 30, '', 1); // buat cell kosong
        $pdf->Image($row['proof'], $x + 1, $y + 1, 20); // tampilkan gambar dalam cell
    } else {
        $pdf->Cell(35, 30, '-', 1, 0, 'C');
    }

    $pdf->Cell(35, 30, formatTanggalIndonesia($row['created_at']), 1, 0, 'C');
    $pdf->Ln();
}

$pdf->Output("I", "riwayat-saldo.pdf");
