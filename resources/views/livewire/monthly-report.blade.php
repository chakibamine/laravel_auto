<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bilan Mensuel</title>
    <link rel="icon" href="{{ asset('logo/car.png') }}" type="image/x-icon">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
        }
        .report-container {
            width: 21cm;
            margin: 0 auto;
            padding: 1cm;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #CCCCCC;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: bold;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 12px;
        }
        .totals-row {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        @media print {
            .print-button {
                display: none;
            }
            @page {
                size: A4;
                margin: 1cm;
            }
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="printReport()">Imprimer</button>
    
    <div class="report-container">
        <div class="header">
            <div>Bilan</div>
        </div>

        <div class="info-row">
            <div>
                <strong>Auto Ecole Ait Mhand</strong><br>
                <strong>Mois : </strong>{{ sprintf('%02d', $currentMonth) }}/{{ $currentYear }}
            </div>
            <div>
                Date de Fiche: {{ now()->format('d/m/y') }}
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>الباقي</th>
                    <th>قيمة المصروف</th>
                    <th>نوع المصروف</th>
                    <th>قيمة المدخول</th>
                    <th>نوع المدخول</th>
                    <th>التاريخ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportData['days'] as $date => $day)
                    @php
                        $maxRows = max(
                            count($day['entries']),
                            count($day['exits'])
                        );
                    @endphp

                    @if($maxRows == 0)
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{ $day['date'] }}</td>
                        </tr>
                    @else
                        @for($i = 0; $i < $maxRows; $i++)
                            <tr>
                                <td>
                                    @php
                                        $entryAmount = isset($day['entries'][$i]) ? $day['entries'][$i]['montant'] : 0;
                                        $exitAmount = isset($day['exits'][$i]) ? $day['exits'][$i]['montant'] : 0;
                                        $balance = $entryAmount - $exitAmount;
                                    @endphp
                                    {{ number_format($balance, 2) }}
                                </td>
                                <td>{{ isset($day['exits'][$i]) ? number_format($day['exits'][$i]['montant'], 2) : '' }}</td>
                                <td>{{ isset($day['exits'][$i]) ? $day['exits'][$i]['motif'] : '' }}</td>
                                <td>{{ isset($day['entries'][$i]) ? number_format($day['entries'][$i]['montant'], 2) : '' }}</td>
                                <td>{{ isset($day['entries'][$i]) ? $day['entries'][$i]['motif'] : '' }}</td>
                                <td>{{ $i == 0 ? $day['date'] : '' }}</td>
                            </tr>
                        @endfor
                    @endif
                @endforeach

                <tr class="totals-row">
                    <td>{{ number_format($reportData['total_balance'], 2) }} DH</td>
                    <td>{{ number_format($reportData['total_exits'], 2) }} DH</td>
                    <td><strong></strong></td>
                    <td>{{ number_format($reportData['total_entries'], 2) }} DH</td>
                    <td><strong></strong></td>
                    <td><strong>المجموع</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        function printReport() {
            document.querySelector('.print-button').style.display = 'none';
            window.print();
            setTimeout(() => {
                document.querySelector('.print-button').style.display = 'block';
            }, 100);
        }

        // Auto-print when the page loads
        window.onload = function() {
            printReport();
        };
    </script>
</body>
</html> 