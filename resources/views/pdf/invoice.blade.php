<!DOCTYPE html>
<html>
<head>
    <title>Facture</title>
    <link rel="icon" href="{{ asset('logo/car.png') }}" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .print-button {
            margin: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
<table align="center" border="0" cellpadding="0" cellspacing="0" style="height:842px; width:595px;font-size:12px;">
    <tbody>
        <tr>
            <td valign="top">
                <table width="100%" height="100" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td><div align="center" style="font-size: 14px;font-weight: bold;">Facture</div></td>
                        </tr>
                    </tbody>
                </table>
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td valign="top" width="35%" style="font-size:12px;">
                                <strong>Auto Ecole Ait Mhand</strong><br>
                                @if($dossier->student->image_url)
                                    <img style='width:70px;' src='{{ asset("storage/" . $dossier->student->image_url) }}'><br>
                                @endif
                                <strong>Facture pour : </strong>{{ $dossier->student->lastname }} {{ $dossier->student->firstname }}<br>
                                <strong>Permis :</strong> {{ $dossier->category }}<br>
                            </td>
                            <td valign="top" width="35%">
                            </td>
                            <td valign="top" width="30%" style="font-size:12px;">
                                Date de facturation: {{ now()->format('d/m/y') }}<br>
                                <br>    
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="100%" cellspacing="0" cellpadding="2" border="1" bordercolor="#CCCCCC">
                    <tbody>
                        <tr>
                            <td width="35%" bordercolor="#ccc" bgcolor="#f2f2f2" style="font-size:12px;"><strong>Motif</strong></td>
                            <td bordercolor="#ccc" bgcolor="#f2f2f2" style="font-size:12px;"><strong>Date</strong></td>
                            <td bordercolor="#ccc" bgcolor="#f2f2f2" style="font-size:12px;"><strong>Nom du payeur</strong></td>
                            <td bordercolor="#ccc" bgcolor="#f2f2f2" style="font-size:12px;"><strong>Montant</strong></td>
                        </tr>
                        @foreach($reglements as $reg)
                        <tr>
                            <td valign='top' style='font-size:12px;'>{{ $reg->motif }}</td>
                            <td valign='top' style='font-size:12px;'>{{ $reg->date_reg->format('d/m/Y') }}</td>
                            <td valign='top' style='font-size:12px;'>{{ $reg->nom_du_payeur }}</td>
                            <td valign='top' style='font-size:12px;'>{{ $reg->price }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <table width="100%" cellspacing="0" cellpadding="2" border="0">
                    <tbody>
                        <tr>
                            <td style="font-size:12px;width:50%;"><strong> </strong></td>
                            <td>
                                <table width="100%" cellspacing="0" cellpadding="2" border="0">
                                    <tbody>
                                        <tr>
                                            <td align="right" style="font-size:12px;"><b>Total</b></td>
                                            <td align="right" style="font-size:12px;"><b>{{ $totalPaid }}</b></td>
                                        </tr>
                                        <tr>
                                            <td align="right" style="font-size:12px;"><b>Reste</b></td>
                                            <td align="right" style="font-size:12px;"><b>{{ $remaining }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                @if($reglements->count() == 1 && $reglements->first()->motif == "Free inscription")
                                    <p><strong>ملحوظة :</strong> مبلغ التسبيق غير قابل للاسترداد</p>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button class="print-button" onclick="window.print()">Imprimer</button>
            </td>
        </tr>
    </tbody>
</table>
<script>
    window.onload = function() {
        // Automatically open print dialog when page loads
        window.print();
    }
</script>
</body>
</html> 