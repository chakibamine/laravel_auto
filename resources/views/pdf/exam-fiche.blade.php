<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fiche d'examen - {{ $dossier->student->lastname }} {{ $dossier->student->firstname }}</title>
    <link rel="icon" href="{{ asset('logo/car.png') }}" type="image/x-icon">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .content {
            width: 80%;
        }
        .header {
            font-size: 2em;
            border: 2px solid #000;
            padding-bottom: 10px;
            text-align: center;
            margin-bottom: 30px;
        }
        .student-photo {
            width: 120px;
            margin-right: 20px;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        td {
            border: 1px solid #000;
            padding: 20px;
            font-size: 2em;
        }
        .score-table {
            width: auto;
            margin-top: 70px;
            margin-left: 100px;
            border: none;
        }
        .score-table td {
            font-size: 4em;
            border: none;
        }
        .score {
            border-top: 3px solid black;
        }
        .score-right {
            margin-left: 300px;
        }
        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <button class="print-button" onclick="printFiche()">Imprimer</button>
            <h1 class="header">Auto Ecole Ait Mhand</h1>

            @if($dossier->student->image_url)
                <img src="{{ Storage::url($dossier->student->image_url) }}" alt="Photo d'étudiant" class="student-photo">
            @endif

            <table>
                <tr>
                    <td>Nom et prenom</td>
                    <td style="width: 50%;">{{ strtoupper($dossier->student->lastname) }} {{ ucfirst($dossier->student->firstname) }}</td>
                </tr>
                <tr>
                    <td>C.I.N</td>
                    <td>{{ $dossier->student->cin }}</td>
                </tr>
                <tr>
                    <td>Categorie</td>
                    <td>{{ $dossier->category }}</td>
                </tr>
                <tr>
                    <td>Date d'examen</td>
                    <td>{{ $exam->date_exam->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td>Tel d'école</td>
                    <td>0613951020</td>
                </tr>
            </table>

            <table class="score-table">
                <tr>
                    <td><p class="score">40</p></td>
                    <td><p class="score score-right">40</p></td>
                </tr>
            </table>
        </div>
    </div>

    <script>
        function printFiche() {
            document.querySelector('.print-button').style.display = 'none';
            window.print();
            setTimeout(function() {
                document.querySelector('.print-button').style.display = 'block';
            }, 100);
        }

        // Auto-print when the page loads
        window.onload = function() {
            printFiche();
        };
    </script>
</body>
</html> 