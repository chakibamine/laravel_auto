<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        * {
            margin-top: 3px;
            font-family: DejaVu Sans, sans-serif;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .font-bold {
            font-weight: bold;
        }
        .border-bottom {
            border-bottom: 2px solid black;
        }
        .mt-4 {
            margin-top: 1rem;
        }
        .flex-row {
            display: flex;
            justify-content: flex-end;
        }
        .mr-100 {
            margin-right: 100px;
        }
    </style>
</head>
<body>
    <table align="center" style="width: 700px; font-size: 12px; padding: 5px;">
        <tr>
            <td>
                <div class="text-center font-bold" style="font-size: 14px;">
                    عقد التكوين بين المرشح و مؤسسة تعليم السياقة
                </div>
                <div class="text-center font-bold" style="font-size: 14px;">
                    رخصةالسياقة من صنف (ب)
                </div>
                <div class="flex-row">
                    <p class="mr-100 font-bold">: بتاريخ</p>
                    <p class="font-bold">: رقم</p>
                </div>

                <div class="text-right font-bold">
                    <p class="border-bottom" style="width: 60px;">: طرفى العقد</p>
                </div>

                <div class="text-right" style="font-size: 14px;">
                    <p>: هذا العقد مبرم بين</p>
                    <p>مؤسسة تعليم السياقة : <b>مؤسسة أيت امحند</b></p>
                    <p>5798 : رقم القيد في السجل التجاري (رقم الرخصة)</p>
                    <p>العنوان : مسجد بوشغل بتانوغة تاكزيرت القصيبة قرب النيميرو</p>
                    <p>44870043 : رقم القيد في سجل الضريبة المهنية</p>
                    
                    <div class="flex-row">
                        <p class="mr-100">المدينة : تانوغة</p>
                        <p>9417 : رقم القيد في السجل التجاري</p>
                    </div>
                    
                    <div class="flex-row">
                        <p class="mr-100">الفاكس : 0665342776</p>
                        <p>0665342776 : الهاتف</p>
                    </div>

                    <p>: البريد الإلكتروني</p>
                    
                    <div style="text-align: left; font-weight: bold; margin-left: 2rem;">
                        <p>المسماة "المؤسسة " مؤسسة أيت امحند</p>
                    </div>

                    <p>والسيد (ة) : <?php echo e($dossier->student->lastname); ?> <?php echo e($dossier->student->firstname); ?></p>
                    
                    <div class="flex-row">
                        <p style="margin-right: 50px;">بتاريخ : <?php echo e($dossier->student->date_birth ? \Carbon\Carbon::parse($dossier->student->date_birth)->format('d/m/Y') : ''); ?></p>
                        <p style="margin-right: 50px;">المزداد(ة) ب : <?php echo e($dossier->student->place_birth); ?></p>
                        <p><?php echo e($dossier->student->cin); ?> : رقم ب.و.ت.إ</p>
                    </div>

                    <p>القاطن (ة) ب : <?php echo e($dossier->student->address); ?></p>
                    <p><?php echo e($dossier->ref); ?> : (Référence web) رقم تسجيل المرشح الممنوح من طرف الإدارة</p>

                    <!-- Continue with the rest of the contract content -->
                    <!-- ... -->
                </div>
            </td>
        </tr>
    </table>
</body>
</html> <?php /**PATH D:\laravel\volt-laravel-dashboard\resources\views/pdf/contract.blade.php ENDPATH**/ ?>