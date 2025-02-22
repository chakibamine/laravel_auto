<!DOCTYPE html>
<html>
<head>
    <title>Facture</title>
    <link rel="icon" href="<?php echo e(asset('logo/car.png')); ?>" type="image/x-icon">
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
                                <?php if($dossier->student->image_url): ?>
                                    <img style='width:70px;' src='<?php echo e(asset("storage/" . $dossier->student->image_url)); ?>'><br>
                                <?php endif; ?>
                                <strong>Facture pour : </strong><?php echo e($dossier->student->lastname); ?> <?php echo e($dossier->student->firstname); ?><br>
                                <strong>Permis :</strong> <?php echo e($dossier->category); ?><br>
                            </td>
                            <td valign="top" width="35%">
                            </td>
                            <td valign="top" width="30%" style="font-size:12px;">
                                Date de facturation: <?php echo e(now()->format('d/m/y')); ?><br>
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
                        <?php $__currentLoopData = $reglements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td valign='top' style='font-size:12px;'><?php echo e($reg->motif); ?></td>
                            <td valign='top' style='font-size:12px;'><?php echo e($reg->date_reg->format('d/m/Y')); ?></td>
                            <td valign='top' style='font-size:12px;'><?php echo e($reg->nom_du_payeur); ?></td>
                            <td valign='top' style='font-size:12px;'><?php echo e($reg->price); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                            <td align="right" style="font-size:12px;"><b><?php echo e($totalPaid); ?></b></td>
                                        </tr>
                                        <tr>
                                            <td align="right" style="font-size:12px;"><b>Reste</b></td>
                                            <td align="right" style="font-size:12px;"><b><?php echo e($remaining); ?></b></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <?php if($reglements->count() == 1 && $reglements->first()->motif == "Free inscription"): ?>
                                    <p><strong>ملحوظة :</strong> مبلغ التسبيق غير قابل للاسترداد</p>
                                <?php endif; ?>
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
</html> <?php /**PATH D:\laravel\volt-laravel-dashboard\resources\views/pdf/invoice.blade.php ENDPATH**/ ?>