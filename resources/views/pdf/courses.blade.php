<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Liste des Cours - {{ $dossier->student->lastname }} {{ $dossier->student->firstname }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .student-info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Liste des Cours</h2>
    </div>

    <div class="student-info">
        <p><strong>C.I.N :</strong> {{ $dossier->student->cin }}</p>
        <p><strong>Nom et prénom :</strong> {{ strtoupper($dossier->student->lastname) }} {{ ucfirst($dossier->student->firstname) }}</p>
        <p><strong>N° Dossier :</strong> {{ $dossier->ref }}</p>
        <p><strong>Date d'inscription :</strong> {{ $dossier->date_inscription ? $dossier->date_inscription->format('d/m/Y') : '-' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Ajouté par</th>
                <th>Date d'ajout</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dossier->courses->sortBy('date_cours') as $course)
                <tr>
                    <td>{{ $course->date_cours->format('d/m/Y') }}</td>
                    <td>{{ $course->type }}</td>
                    <td>{{ $course->insert_user }}</td>
                    <td>{{ $course->date_insertion->format('d/m/Y H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <p><strong>Total cours théoriques :</strong> {{ $dossier->courses->where('type', 'Theorique')->count() }}</p>
        <p><strong>Total cours pratiques :</strong> {{ $dossier->courses->where('type', 'Pratique')->count() }}</p>
    </div>

    <div class="footer">
        <p>Document généré le {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html> 