<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>شهادة نهاية التكوين - <?php echo e($dossier->student->lastname); ?> <?php echo e($dossier->student->firstname); ?></title>
    <link rel="icon" href="<?php echo e(asset('logo/car.png')); ?>" type="image/x-icon">
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            direction: rtl; /* Ensure Arabic text flows right-to-left */
            font-size: 12pt; /* Base font size for printing */
           
        }
        .container {
            width: 90%;
            margin: 0 auto;
            text-align: right;
            box-sizing: border-box;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 18pt;
            font-weight: bold;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .info-section p {
            margin: 5px 0;
            display: block;
        }
        .info-section span {
            display: inline-block;
            width: 100%;
            text-align: right;
        }
        .statement {
            text-align: justify;
            margin-bottom: 20px;
            font-size: 12pt;
        }
        .signature {
            text-align: center;
            margin-top: 30px;
            font-size: 14pt;
            font-weight: bold;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 12pt; /* Larger font size for printing */
            }
            .container {
                width: 100%;
                margin: 0;
            }
            .print-button, .date-input {
                display: none;
            }
            .info-section p {
                margin: 3px 0;
            }
            .statement {
                font-size: 12pt; /* Larger font size for readability */
            }
            .signature {
                font-size: 14pt;
            }
        }
    </style>
</head>
<body>
<div class="container">
        <h1 class="header">شهادة نهاية التكوين</h1>

        <!-- Main Content -->
        <div class="info-section">
            <p><span>مؤسسة تعليم السياقة  :  SOCIETE AUTO ECOLE AIT MHAND</span></p>
            <p><span>رقم الرخصة : 5798</span></p>
            <p><span>رقم القيد في السجل الوطني الخاص بمؤسسات تعليم السياقة :5798</span></p>
            <p><span>رقم القيد في سجل الضريبة المهنية : 44870043</span></p>
            <p><span>العنوان : مسجد بوشغل بتانوغة تاكزيرت القصيبة قرب النيميرو</span></p>
            <p><span>الهاتف : 0613951020</span></p>
            <p><span>البريد الإلكتروني : chakichakib@gmail.com</span></p>
            <p><span>الممثل القانوني للمؤسسة</span></p>
            <p><span>الاسم الشخصي : محمد</span></p>
            <p><span>الاسم العائلي : شكيب</span></p>
            <p><span>العنوان : دوار اغرم لعلام دير القصيبة</span></p>
            <p><span>رقم الهاتف : 0613951020</span></p>
        </div>

        <!-- Statement Section -->
        <div class="statement">
            <p>أشهد أن:</p>
            <p>السيد(ة): <?php echo e($dossier->student->lastname_ar); ?> <?php echo e($dossier->student->firstname_ar); ?></p>
            <p>الحامل (ة) للبطاقة الوطنية للتعريف رقم: <?php echo e($dossier->student->cin); ?></p>
            <p>الرقم الممنوح من طرف الإدارة web ref: 5798-<?php echo e($dossier->student->cin); ?>-<?php echo e($dossier->ref); ?></p>
            <p>بناء على عقد التكوين الموقع بين الطرفين بتاريخ: <span id="contractDatePlaceholder">..........................................................................................................</span></p>
            <p>لقى (ة) بهذه المؤسسة دروسا نظرية وتطبيقية في تعليم سياقة المركبات من صنف "B"، بما مجموعه: 20 ساعة بالنسبة للتكوين النظري و 20 ساعة بالنسبة للتكوين التطبيقي طبقا للبرنامج الوطني لتعليم السياقة.</p>
            <p>وقد أشرف على التكوين النظري المدرب الوارد اسمه بعده:</p>
            <p>اسم المدرب: الهام الراضى</p>
            <p> رقم رخصته:4208</p>
            <p>وأشرف على التكوين التطبيقي المدرب الوارد اسمه بعده:</p>
            <p>اسم المدرب: الهام الراضى</p>
            <p> رقم رخصته:4208</p>
            <p>كما تلقى (تلقت) تكوينه (ها) بواسطة المركبة من صنف "B" المسجلة تحت رقم: 61-أ-72151 في اسم المؤسسة.</p>
        </div>

        <!-- Signature Section -->
        <div class="signature">
            <p>طابع المؤسسة واسم وتوقيع الممثل القانوني للمؤسسة</p>
        </div>

        <!-- Date Input Section -->
        <div class="date-input" style="text-align: center; margin-top: 20px;">
            <label for="contractDateInput">تاريخ العقد:</label>
            <input type="date" id="contractDateInput" onchange="updateContractDate()">
        </div>

        <!-- Print Button -->
        <button class="print-button" onclick="printFiche()">طباعة</button>
    </div>

    <script>
        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        function updateContractDate() {
            const dateInput = document.getElementById('contractDateInput').value;
            const datePlaceholder = document.getElementById('contractDatePlaceholder');
            if (dateInput) {
                const formattedDate = formatDate(dateInput);
                datePlaceholder.textContent = formattedDate;
            } else {
                datePlaceholder.textContent = '..........................................................................................................';
            }
        }

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
</html><?php /**PATH D:\laravel\volt-laravel-dashboard\resources\views/pdf/finformation.blade.php ENDPATH**/ ?>