<!DOCTYPE html>
<html>
<head>
    <title>Fiche de Conduite</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #CCCCCC;
            padding: 8px;
            text-align: center;
        }
        .header-cell {
            background-color: #cccaca;
            font-weight: bold;
            font-size: 20px;
        }
        .empty-row td {
            height: 20px;
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
                                    <strong>Date de Fiche:</strong> {{ now()->format('d/m/y') }}<br><br>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Male Students Section -->
                    <table width="100%" cellspacing="0" cellpadding="2" border="1">
                        <thead>
                            <tr>
                                <th class="header-cell" style="width: 30px;">Serie</th>
                                <th class="header-cell" style="width: 30px;">CIN</th>
                                <th class="header-cell" style="width: 250px;">Nom et Prénom</th>
                                <th class="header-cell" style="width: 100px;">Exam</th>
                                <th class="header-cell" style="width: 60px;">N/C</th>
                                <th class="header-cell" style="width: 60px;"></th>
                                <th class="header-cell" style="width: 60px;"></th>
                                <th class="header-cell" style="width: 60px;"></th>
                                <th class="header-cell" style="width: 60px;"></th>
                                <th class="header-cell" style="width: 60px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($dossiers as $dossier)
                                @if($dossier->category === 'B' && $dossier->student->gender === 'masculin')
                                    <tr>
                                        <td class="header-cell">{{ $i++ }}</td>
                                        <td>{{ $dossier->student->cin }}</td>
                                        <td>{{ $dossier->student->lastname }} {{ $dossier->student->firstname }}</td>
                                        <td>
                                            @if($dossier->exams->first())
                                                {{ $dossier->exams->first()->type_exam === 'Theorique' ? 'T:' : 'P:' }}
                                                {{ $dossier->exams->first()->date_exam->format('d/m/Y H:i') }}
                                            @endif
                                        </td>
                                        <td>{{ $dossier->courses->where('type_cours', 'Pratique')->count() }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endif
                            @endforeach

                            @for($j = 1; $j <= 3; $j++)
                                <tr class="empty-row">
                                    <td class="header-cell">{{ $i++ }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>

                    <!-- Female Students Section -->
                    <table width="100%" cellspacing="0" cellpadding="2" border="1" style="margin-top: 20px;">
                        <thead>
                            <tr>
                                <th class="header-cell" style="width: 30px;">Serie</th>
                                <th class="header-cell" style="width: 30px;">CIN</th>
                                <th class="header-cell" style="width: 250px;">Nom et Prénom</th>
                                <th class="header-cell" style="width: 100px;">Exam</th>
                                <th class="header-cell" style="width: 60px;">N/C</th>
                                <th class="header-cell" style="width: 60px;"></th>
                                <th class="header-cell" style="width: 60px;"></th>
                                <th class="header-cell" style="width: 60px;"></th>
                                <th class="header-cell" style="width: 60px;"></th>
                                <th class="header-cell" style="width: 60px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($dossiers as $dossier)
                                @if($dossier->category === 'B' && $dossier->student->gender === 'feminin')
                                    <tr>
                                        <td class="header-cell">{{ $i++ }}</td>
                                        <td>{{ $dossier->student->cin }}</td>
                                        <td>{{ $dossier->student->lastname }} {{ $dossier->student->firstname }}</td>
                                        <td>
                                            @if($dossier->exams->first())
                                                {{ $dossier->exams->first()->type_exam === 'Theorique' ? 'T:' : 'P:' }}
                                                {{ $dossier->exams->first()->date_exam->format('d/m/Y H:i') }}
                                            @endif
                                        </td>
                                        <td>{{ $dossier->courses->where('type_cours', 'Pratique')->count() }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endif
                            @endforeach

                            @for($j = 1; $j <= 3; $j++)
                                <tr class="empty-row">
                                    <td class="header-cell">{{ $i++ }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
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