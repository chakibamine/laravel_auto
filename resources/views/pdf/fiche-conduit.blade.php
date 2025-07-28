<!DOCTYPE html>
<html>
<head>
    <title>Fiche de Conduite</title>
    <link rel="icon" href="{{ asset('logo/car.png') }}" type="image/x-icon">
    <style>
        @page {
            size: A4;
            margin: 100px;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #CCCCCC;
            text-align: center;
            
        }
        .header-cell {
            background-color: #cccaca;
            font-weight: bold;
            font-size: 15px;
        }
        .empty-row td {
            height: 20px;
        }
    </style>
</head>
<body>
    <table align="center" border="0" cellpadding="0" cellspacing="0" style="height:100%; width:100%;font-size:12px;">
        <tbody>
            <tr>
                <td valign="top">
                    <table width="100%" height="100" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td><div align="center" style="font-size: 25px;font-weight: bold;">Fiche de Conduite</div></td>
                            </tr>
                        </tbody>
                    </table>
                    <table width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td valign="top" width="35%" style="font-size:15px;">
                                    <strong>Auto Ecole Ait Mhand</strong><br>
                                </td>
                                <td valign="top" width="35%"></td>
                                <td valign="top" width="30%" style="font-size:15px;">
                                    <strong>Date de Fiche:</strong> {{ now()->format('d/m/y') }}<br>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table width="100%" cellspacing="0" cellpadding="2" border="1" bordercolor="#CCCCCC">
                        <thead>
                            <tr>
                                <td class="header-cell" style="width: 30px;"><strong>Serie</strong></td>
                                <td class="header-cell" style="width: 30px;"><strong>CIN</strong></td>
                                <td class="header-cell" style="width: 250px;"><strong>Nom et Prénom</strong></td>
                                <td class="header-cell" style="width: 100px;"><strong>Exam</strong></td>
                                <td class="header-cell" style="width: 60px;"><strong>N/C</strong></td>
                                <td class="header-cell" style="width: 60px;"></td>
                                <td class="header-cell" style="width: 60px;"></td>
                                <td class="header-cell" style="width: 60px;"></td>
                                <td class="header-cell" style="width: 60px;"></td>
                                <td class="header-cell" style="width: 60px;"></td>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($dossiers as $dossier)
                                @if($dossier->category === 'B' && $dossier->student->gender === 'Masculin')
                                    <tr>
                                        <th valign='top' align='center' bgcolor='#cccaca' style='font-size:15px;'>{{ $i++ }}</td>
                                        <td>{{ $dossier->student->cin }}</td>
                                        <td valign='top' align='center' style='font-size:14px;'>{{ $dossier->student->lastname }} {{ $dossier->student->firstname }}</td>
                                        <td valign='top' align='center' style='font-size:14px;'>
                                            @if($dossier->exams->first())
                                                {{ $dossier->exams->first()->type_exam === 'Theorique' ? 'T:' : 'P:' }}
                                                {{ $dossier->exams->first()->date_exam->format('d/m/Y') }}
                                            @endif
                                        </td>
                                        <td valign='top' align='center' style='font-size:14px;'>{{ $dossier->courses->where('type_cours', 'Pratique')->count() }}</td>
                                        <td valign='top' align='center' style='font-size:14px;'></td>
                                        <td valign='top' align='center' style='font-size:14px;'></td>
                                        <td valign='top' align='center' style='font-size:14px;'></td>
                                        <td valign='top' align='center' style='font-size:14px;'></td>
                                        <td valign='top' align='center' style='font-size:14px;'></td>
                                    </tr>
                                @endif
                            @endforeach

                            @for($j = 1; $j <= 3; $j++)
                            <tr>
              <th valign='top' align='center' bgcolor='#cccaca' style='font-size:15px; hight: 20px;'>{{ $i++ }}</th>
              <td valign='top' align='center' style='font-size:12px; height: 20px;'></td>
              <td valign='top' align='center' style='font-size:12px; height: 20px;'></td>
              <td valign='top' align='center' style='font-size:12px; height: 20px;'></td>
              <td valign='top' align='center' style='font-size:12px; height: 20px;'></td>
              <td valign='top' align='center' style='font-size:12px; height: 20px;'></td>
              <td valign='top' align='center' style='font-size:12px; height: 20px;'></td>
              <td valign='top' align='center' style='font-size:12px; height: 20px;'></td>
              <td valign='top' align='center' style='font-size:12px; height: 20px;'></td>
              <td valign='top' align='center' style='font-size:12px; height: 20px;'></td>
             </tr>
                            @endfor
                        </tbody>
                    </table>
                    <table width="100%" cellspacing="0" cellpadding="2" border="1" style="margin-top: 20px;">
                        <thead>
                            <tr>
                            <td class="header-cell" style="width: 30px;"><strong>Serie</strong></td>
                                <td class="header-cell" style="width: 30px;"><strong>CIN</strong></td>
                                <td class="header-cell" style="width: 250px;"><strong>Nom et Prénom</strong></td>
                                <td class="header-cell" style="width: 100px;"><strong>Exam</strong></td>
                                <td class="header-cell" style="width: 60px;"><strong>N/C</strong></td>
                                <td class="header-cell" style="width: 60px;"></td>
                                <td class="header-cell" style="width: 60px;"></td>
                                <td class="header-cell" style="width: 60px;"></td>
                                <td class="header-cell" style="width: 60px;"></td>
                                <td class="header-cell" style="width: 60px;"></td>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($dossiers as $dossier)
                                @if($dossier->category === 'B' && $dossier->student->gender === 'Féminin')
                                    <tr>
                                        <th valign='top' align='center' bgcolor='#cccaca' style='font-size:15px;'>{{ $i++ }}</td>
                                        <td>{{ $dossier->student->cin }}</td>
                                        <td valign='top' align='center' style='font-size:14px;'>{{ $dossier->student->lastname }} {{ $dossier->student->firstname }}</td>
                                        <td valign='top' align='center' style='font-size:14px;'>
                                            @if($dossier->exams->first())
                                                {{ $dossier->exams->first()->type_exam === 'Theorique' ? 'T:' : 'P:' }}
                                                {{ $dossier->exams->first()->date_exam->format('d/m/Y') }}
                                            @endif
                                        </td>
                                        <td valign='top' align='center' style='font-size:14px;'>{{ $dossier->courses->where('type_cours', 'Pratique')->count() }}</td>
                                        <td valign='top' align='center' style='font-size:14px;'></td>
                                        <td valign='top' align='center' style='font-size:14px;'></td>
                                        <td valign='top' align='center' style='font-size:14px;'></td>
                                        <td valign='top' align='center' style='font-size:14px;'></td>
                                        <td valign='top' align='center' style='font-size:14px;'></td>
                                    </tr>
                                @endif
                            @endforeach

                            @for($j = 1; $j <= 3; $j++)
                            <tr>
              <th valign='top' align='center' bgcolor='#cccaca' style='font-size:15px; hight: 20px;'>{{ $i++ }}</th>
              <td valign='top' align='center' style='font-size:12px; height: 20px;'></td>
              <td valign='top' align='center' style='font-size:12px; height: 20px;'></td>
              <td valign='top' align='center' style='font-size:12px; height: 20px;'></td>
              <td valign='top' align='center' style='font-size:12px; height: 20px;'></td>
              <td valign='top' align='center' style='font-size:12px; height: 20px;'></td>
              <td valign='top' align='center' style='font-size:12px; height: 20px;'></td>
              <td valign='top' align='center' style='font-size:12px; height: 20px;'></td>
              <td valign='top' align='center' style='font-size:12px; height: 20px;'></td>
              <td valign='top' align='center' style='font-size:12px; height: 20px;'></td>
             </tr>
                            @endfor
                        </tbody>
                    </table>
                    <button class="print-button" onclick="window.print()">Imprimer</button>
                </td>
            </tr>
        </tbody>
    </table>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html> 