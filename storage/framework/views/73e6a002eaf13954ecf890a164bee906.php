<!DOCTYPE html>
<html>
<head>
    <title>Fiche de Formation</title>
    <style>
        @media print {
            .print-button {
                display: none;
            }
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 21cm;
            margin: 0 auto;
            background: white;
        }
        .header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .student-info {
            font-size: 14px;
            line-height: 1.5;
        }
        .date-info {
            text-align: right;
            font-size: 14px;
        }
        .student-photo {
            width: 100px;
            height: auto;
            margin: 10px 0;
        }
        .course-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }
        .course-table th, 
        .course-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        .course-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .serie-col {
            width: 60px;
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .date-col {
            width: 200px;
        }
        .type-col {
            width: 100px;
        }
        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }
        .print-button {
            margin-top: 20px;
            padding: 8px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .print-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Fiche de Formation</div>
        
        <div class="info-section">
            <div class="student-info">
                <strong>Auto Ecole Ait Mhand</strong><br>
                <?php if($dossier->student->image_url): ?>
                    <img class="student-photo" src="<?php echo e(asset('storage/' . $dossier->student->image_url)); ?>" alt="Photo"><br>
                <?php endif; ?>
                <strong>C.I.N : </strong><?php echo e($dossier->student->cin); ?><br>
                <strong>Candidat : </strong><?php echo e($dossier->student->lastname); ?> <?php echo e($dossier->student->firstname); ?><br>
                <strong>Dossier : </strong><?php echo e($dossier->ref); ?>

            </div>
            <div class="date-info">
                <strong>Date de Fiche : </strong><?php echo e(now()->format('d/m/y')); ?>

            </div>
        </div>

        <table class="course-table">
            <thead>
                <tr>
                    <th class="serie-col">Serie</th>
                    <th class="date-col">Date Théorique</th>
                    <th class="serie-col">Serie</th>
                    <th class="date-col">Date Pratique</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $theoretical = $dossier->courses->where('type_cours', 'Theorique')->sortBy('date_cours')->values();
                    $practical = $dossier->courses->where('type_cours', 'Pratique')->sortBy('date_cours')->values();
                    $maxCount = max($theoretical->count(), $practical->count());

                    // Debug output
                    echo "<!-- Debug Info:";
                    echo "\nTheoretical Courses: " . $theoretical->count();
                    echo "\nPractical Courses: " . $practical->count();
                    echo "\nAll Courses Types: " . $dossier->courses->pluck('type_cours')->unique()->implode(', ');
                    echo "\n-->";
                ?>

                <?php for($i = 0; $i < $maxCount; $i++): ?>
                    <tr>
                        <td class="serie-col"><?php echo e($i + 1); ?></td>
                        <td><?php echo e($theoretical->get($i) ? $theoretical->get($i)->date_cours->format('d/m/Y') : ''); ?></td>
                        <td class="serie-col"><?php echo e($i + 1); ?></td>
                        <td><?php echo e($practical->get($i) ? $practical->get($i)->date_cours->format('d/m/Y') : ''); ?></td>
                    </tr>
                <?php endfor; ?>

                <tr class="total-row">
                    <td>Total</td>
                    <td><?php echo e($theoretical->count()); ?></td>
                    <td>Total</td>
                    <td><?php echo e($practical->count()); ?></td>
                </tr>
            </tbody>
        </table>

        <button class="print-button" onclick="window.print()">Imprimer</button>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html> <?php /**PATH D:\laravel\volt-laravel-dashboard\resources\views/pdf/courses.blade.php ENDPATH**/ ?>