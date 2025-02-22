<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche De Reglement</title>
    <link rel="icon" href="<?php echo e(asset('logo/car.png')); ?>" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .print-section {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin: 20px auto;
            max-width: 400px;
        }
        .print-button {
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 20px auto;
            transition: background-color 0.3s;
        }
        .print-button:hover {
            background-color: #0b5ed7;
        }
        .receipt {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }
        .input-group {
            margin: 15px 0;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #495057;
            font-weight: bold;
            font-size: 13px;
        }
        .input-group input {
            width: 100%;
            padding: 8px 12px;
            border: 2px solid #dee2e6;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        .input-group input:focus {
            outline: none;
            border-color: #0d6efd;
        }
        .store-button {
            background-color: #198754;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            width: 100%;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .store-button:hover {
            background-color: #157347;
        }
        .logo-img {
            max-width: 70px;
            height: auto;
            border-radius: 4px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #dee2e6;
        }
        .signature-section {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #dee2e6;
        }
        .price-display {
            font-weight: bold;
            color: #198754;
        }
        @media print {
            body {
                background-color: white;
                padding: 0;
            }
            .print-section, .print-button {
                display: none;
            }
            .receipt {
                break-inside: avoid;
                border: none;
                padding: 0;
                margin: 0 0 20px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Input Section -->
    <div class="print-section">
        <h3 style="text-align: center; color: #0d6efd; margin-bottom: 20px;">
            <i class="bi bi-file-text"></i> Fiche De Reglement
        </h3>
        <div class="input-group">
            <label for="priceInput">
                <i class="bi bi-currency-euro"></i> Montant:
            </label>
            <input type="number" id="priceInput" placeholder="Entrer le montant" min="0" step="0.01">
        </div>
        <div class="input-group">
            <label for="deInput">
                <i class="bi bi-person"></i> De:
            </label>
            <input type="text" id="deInput" placeholder="Entrer le nom">
        </div>
        <div class="input-group">
            <label for="aInput">
                <i class="bi bi-person"></i> A:
            </label>
            <input type="text" id="aInput" placeholder="Entrer le nom">
        </div>
        <button onclick="storePrice()" class="store-button">
            <i class="bi bi-check-circle"></i> Enregistrer
        </button>
    </div>
    <button class="print-button" onclick="printInvoice()">
        <i class="bi bi-printer"></i> Imprimer
    </button>

    <!-- First Copy -->
    <div class="receipt">
        <div class="header">
            <h3 style="margin: 0 0 10px 0;">Fiche De Reglement</h3>
            <strong>Auto Ecole Ait Mhand</strong>
        </div>
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <div>
                <?php if($dossier->student->image_url): ?>
                    <img class="logo-img" src='<?php echo e(asset("storage/" . $dossier->student->image_url)); ?>' alt="Photo"><br>
                <?php endif; ?>
                <strong>Candidat : </strong><?php echo e($dossier->student->lastname); ?> <?php echo e($dossier->student->firstname); ?><br>
                <strong>Permis :</strong> <?php echo e($dossier->category); ?>

            </div>
            <div style="text-align: right;">
                <strong>Date : </strong><?php echo e(now()->format('d/m/y')); ?>

            </div>
        </div>
        <table width="100%" cellspacing="0" cellpadding="2" border="1" style="border-collapse: collapse; margin-bottom: 20px;">
            <tr style="background-color: #f8f9fa;">
                <th style="padding: 8px;">Motif</th>
                <th style="padding: 8px;">Date</th>
                <th style="padding: 8px;">Nom du Candidat</th>
                <th style="padding: 8px;">Montant</th>
            </tr>
            <tr>
                <td style="padding: 8px;">Frais D'ecole</td>
                <td style="padding: 8px;"><?php echo e(now()->format('d/m/y')); ?></td>
                <td style="padding: 8px;"><?php echo e($dossier->student->lastname); ?> <?php echo e($dossier->student->firstname); ?></td>
                <td style="padding: 8px;" class="price-display" id="priceDisplay"></td>
            </tr>
        </table>
        <div class="signature-section">
            <div style="display: flex; justify-content: space-between;">
                <div style="text-align: center;">
                    <strong>Auto école <span id='deDisplay'></span></strong><br><br>
                    ________________________
                </div>
                <div style="text-align: center;">
                    <strong>Auto école <span id='aDisplay'></span></strong><br><br>
                    ________________________
                </div>
            </div>
        </div>
    </div>

    <!-- Second Copy -->
    <div class="receipt">
        <div class="header">
            <h3 style="margin: 0 0 10px 0;">Fiche De Reglement</h3>
            <strong>Auto Ecole Ait Mhand</strong>
        </div>
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <div>
                <?php if($dossier->student->image_url): ?>
                    <img class="logo-img" src='<?php echo e(asset("storage/" . $dossier->student->image_url)); ?>' alt="Photo"><br>
                <?php endif; ?>
                <strong>Candidat : </strong><?php echo e($dossier->student->lastname); ?> <?php echo e($dossier->student->firstname); ?><br>
                <strong>Permis :</strong> <?php echo e($dossier->category); ?>

            </div>
            <div style="text-align: right;">
                <strong>Date : </strong><?php echo e(now()->format('d/m/y')); ?>

            </div>
        </div>
        <table width="100%" cellspacing="0" cellpadding="2" border="1" style="border-collapse: collapse; margin-bottom: 20px;">
            <tr style="background-color: #f8f9fa;">
                <th style="padding: 8px;">Motif</th>
                <th style="padding: 8px;">Date</th>
                <th style="padding: 8px;">Nom du Candidat</th>
                <th style="padding: 8px;">Montant</th>
            </tr>
            <tr>
                <td style="padding: 8px;">Frais D'ecole</td>
                <td style="padding: 8px;"><?php echo e(now()->format('d/m/y')); ?></td>
                <td style="padding: 8px;"><?php echo e($dossier->student->lastname); ?> <?php echo e($dossier->student->firstname); ?></td>
                <td style="padding: 8px;" class="price-display" id="priceDisplay2"></td>
            </tr>
        </table>
        <div class="signature-section">
            <div style="display: flex; justify-content: space-between;">
                <div style="text-align: center;">
                    <strong>Auto école <span id='deDisplay2'></span></strong><br><br>
                    ________________________
                </div>
                <div style="text-align: center;">
                    <strong>Auto école <span id='aDisplay2'></span></strong><br><br>
                    ________________________
                </div>
            </div>
        </div>
    </div>

    <script>
        let storedPrice = 0;

        function storePrice() {
            const priceInput = document.getElementById("priceInput").value;
            const deInput = document.getElementById("deInput").value;
            const aInput = document.getElementById("aInput").value;

            if (!priceInput || isNaN(priceInput)) {
                alert("Veuillez entrer un montant valide.");
                return;
            }
            if (!deInput.trim()) {
                alert("Veuillez entrer le nom 'De'.");
                return;
            }
            if (!aInput.trim()) {
                alert("Veuillez entrer le nom 'A'.");
                return;
            }

            storedPrice = parseFloat(priceInput);
            
            // Update all displays
            document.getElementById("priceDisplay").innerText = `${storedPrice} DH`;
            document.getElementById("priceDisplay2").innerText = `${storedPrice} DH`;
            document.getElementById("deDisplay").innerText = deInput;
            document.getElementById("deDisplay2").innerText = deInput;
            document.getElementById("aDisplay").innerText = aInput;
            document.getElementById("aDisplay2").innerText = aInput;

            // Show success message
            alert(`✅ Informations enregistrées avec succès!\n\nMontant: ${storedPrice} DH\nDe: ${deInput}\nA: ${aInput}`);
        }

        function printInvoice() {
            if (!storedPrice) {
                alert("Veuillez d'abord enregistrer les informations avant d'imprimer.");
                return;
            }
            window.print();
        }

        // Add input validation
        document.getElementById("priceInput").addEventListener("input", function(e) {
            if (e.target.value < 0) e.target.value = 0;
        });
    </script>
</body>
</html> <?php /**PATH D:\laravel\volt-laravel-dashboard\resources\views/pdf/external-payment.blade.php ENDPATH**/ ?>