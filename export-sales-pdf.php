<?php
require_once "config/db.php";
require("fpdf/fpdf.php");

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

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Riwayat Penjualan Barang', 0, 1, 'C');
$pdf->Ln(5);

// Header tabel
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 10, 'No', 1, 0, 'C');
$pdf->Cell(50, 10, 'Nama Barang', 1, 0, 'C');
$pdf->Cell(30, 10, 'Jumlah Keluar', 1, 0, 'C');
$pdf->Cell(30, 10, 'Keuntungan', 1, 0, 'C');
$pdf->Cell(50, 10, 'Tanggal', 1, 1, 'C');

// Ambil data penjualan & join ke items
$pdf->SetFont('Arial', '', 10);
$no = 1;

$query = "
  SELECT 
    s.*, 
    i.name AS item_name, 
    i.purchase_price, 
    i.profit 
  FROM sales s
  JOIN items i ON s.item_id = i.id
  ORDER BY s.sale_date DESC
";

$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $pdf->Cell(10, 10, $no++, 1, 0, 'C');
    $pdf->Cell(50, 10, $row['item_name'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['quantity'], 1, 0, 'C');
    $total_profit = $row['quantity'] * $row['profit'];
    $pdf->Cell(30, 10, 'Rp' . number_format($total_profit), 1, 0, 'C');
    $pdf->Cell(50, 10, formatTanggalIndonesia($row['sale_date']), 1, 0, 'C');
    $pdf->Ln();

}

$pdf->Output("I", "riwayat-penjualan.pdf");
