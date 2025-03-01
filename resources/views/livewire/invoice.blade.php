<head>
    <link rel="icon" href="logo/car.png" type="image/x-icon">
</head>
<title>.</title>

<table align="center" border="0" cellpadding="0" cellspacing="0" style="height:842px; width:595px;font-size:12px;">
    <tbody>
        <tr>
            <td valign="top">
                <table width="100%" height="100" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td>
                                <div align="center" style="font-size: 14px;font-weight: bold;">Cloture : </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td valign="top" width="35%" style="font-size:12px;">
                                <strong>Auto Ecole Ait Mhand</strong><br>
                                <strong>Date de cloture : </strong>{{ $month }}<br>
                            </td>
                            <td valign="top" width="35%"></td>
                            <td valign="top" width="30%" style="font-size:12px;">
                                Date de Fiche: {{ now()->format('d/m/y') }}<br>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="100%" cellspacing="0" cellpadding="2" border="1" bordercolor="#CCCCCC">
                    <tbody>
                        <tr>
                            <td bordercolor="#ccc" bgcolor="#f2f2f2" style="font-size:12px;"><strong>Serie</strong></td>
                            <td bordercolor="#ccc" bgcolor="#f2f2f2" style="font-size:12px;"><strong>CIN</strong></td>
                            <td bordercolor="#ccc" bgcolor="#f2f2f2" style="font-size:12px;"><strong>Nom et prenom</strong></td>
                            <td bordercolor="#ccc" bgcolor="#f2f2f2" style="font-size:12px;"><strong>Categorie</strong></td>
                            <td bordercolor="#ccc" bgcolor="#f2f2f2" style="font-size:12px;"><strong>date d'inscription</strong></td>
                            <td bordercolor="#ccc" bgcolor="#f2f2f2" style="font-size:12px;"><strong>date de cloture</strong></td>
                            <td bordercolor="#ccc" bgcolor="#f2f2f2" style="font-size:12px;"><strong>date d'examen</strong></td>
                        </tr>
                        @if(isset($dossiers) && $dossiers->count() > 0)
                            @foreach($dossiers as $row)
                                <tr>
                                    <td valign='top' style='font-size:12px;'>{{ $row->n_serie }}</td>
                                    <td valign='top' style='font-size:12px;'>{{ $row->student->cin }}</td>
                                    <td valign='top' style='font-size:12px;'>{{ $row->student->lastname }} {{ $row->student->firstname }}</td>
                                    <td valign='top' style='font-size:12px;'>{{ $row['category'] }}</td>
                                    <td valign='top' style='font-size:12px;'>{{ \Carbon\Carbon::parse($row["date_inscription"])->format('d/m/Y H:i') }}</td>
                                    <td valign='top' style='font-size:12px;'>{{ \Carbon\Carbon::parse($row["date_cloture"])->format('d/m/Y H:i') }}</td>
                                    <td valign='top' style='font-size:12px;'>{{ \Carbon\Carbon::parse($row["date_exam"])->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">Aucun dossier trouvé.</td>
                            </tr>
                        @endif
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
                                            <td align="right" style="font-size:12px;"><b>Total </b>{{ $dossier_total }}</td>
                                            <td align="right" style="font-size:12px;"><b></b></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button class="print-button" onclick="printInvoice()">Imprimer</button>
            </td>
        </tr>
    </tbody>
</table>

<script>
    function printInvoice() {
        document.querySelector('.print-button').style.display = 'none';
        window.print();
    }
</script>