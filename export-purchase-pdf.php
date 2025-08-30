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
$pdf->Cell(0, 10, 'Riwayat Pembelian Barang', 0, 1, 'C');
$pdf->Ln(5);

// Header tabel
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 10, 'No', 1, 0, 'C');
$pdf->Cell(45, 10, 'Nama Barang', 1, 0, 'C');
$pdf->Cell(25, 10, 'Harga Satuan', 1, 0, 'C');
$pdf->Cell(15, 10, 'Jumlah', 1, 0, 'C');
$pdf->Cell(20, 10, 'Total', 1, 0, 'C');
$pdf->Cell(20, 10, 'untung', 1, 0, 'C');
$pdf->Cell(20, 10, 'Ongkir', 1, 0, 'C');
$pdf->Cell(40, 10, 'Tanggal', 1, 0, 'C');
$pdf->Ln();

// Ambil data pembelian & join ke items
$pdf->SetFont('Arial', '', 10);
$no = 1;

$query = "
  SELECT 
    p.*, 
    i.name AS item_name, 
    i.purchase_price, 
    i.profit 
  FROM purchases p
  JOIN items i ON p.item_id = i.id
  ORDER BY p.purchase_date DESC
";

$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
  $pdf->Cell(10, 10, $no++, 1, 0, 'C');
  $pdf->Cell(45, 10, $row['item_name'], 1, 0, 'L');
  $pdf->Cell(25, 10, 'Rp' . number_format($row['purchase_price']), 1, 0, 'C');
  $pdf->Cell(15, 10, $row['quantity'], 1, 0, 'C');
  $total_price = $row['purchase_price'] * $row['quantity'];
  $pdf->Cell(20, 10, 'Rp' . number_format($total_price), 1, 0, 'C');
  $total_profit = $row['quantity'] * $row['profit'];
  $pdf->Cell(20, 10, 'Rp' . number_format($total_profit), 1, 0, 'C');
  $pdf->Cell(20, 10, 'Rp' . number_format($row['shipping_cost']), 1, 0, 'C');
  $pdf->Cell(40, 10, formatTanggalIndonesia($row['purchase_date']), 1, 0, 'C');
  $pdf->Ln();
}

$pdf->Output("I", "riwayat-pembelian.pdf");
