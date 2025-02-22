<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="icon" href="<?php echo e(asset('logo/car.png')); ?>" type="image/x-icon">
    <style>
        * {
            margin-top: 3px;
            font-family: DejaVu Sans, sans-serif;
        }
        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="printContract()">Imprimer</button>

    <!-- First Page -->
    <table align="center" border="0" cellpadding="0" cellspacing="0" style="height:842px; width: 700px;font-size:12px; padding: 5px;">
        <tbody>
            <tr>
                <td valign="top">
                    <table width="100%" height="100" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td>
                                    <div align="center" style="font-size: 14px;font-weight: bold;">عقد التكوين بين المرشح و مؤسسة تعليم السياقة</div>
                                    <div align="center" style="font-size: 14px;font-weight: bold;">رخصةالسياقة من صنف (ب)</div><br>
                                    <div style="display: flex; flex-direction:row; justify-content: flex-end;">
                                        <p style="margin-right: 100px; font-size: 14px;font-weight: bold;">: بتاريخ</p>
                                        <p style="font-size: 14px;font-weight: bold;"> : رقم</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                            <div align="right" style="font-size: 14px;font-weight: bold;">
                                <p style="border-bottom: 2px solid black; width:60px;">: طرفى العقد</p>
                            </div><br><br>
                            <div align="right" style="font-size: 14px;">
                                <p>: هذا العقد مبرم بين</p>
                                <p>مؤسسة تعليم السياقة : <b>مؤسسة أيت امحند</b></p>
                                <p>5798 : رقم القيد في السجل التجاري (رقم الرخصة)</p>
                                <p>العنوان : مسجد بوشغل بتانوغة تاكزيرت القصيبة قرب النيميرو</p>
                                <p>44870043 : رقم القيد في سجل الضريبة المهنية</p>
                                <div style="display: flex; flex-direction:row; justify-content: flex-end;">
                                    <p style="margin-right: 100px;">المدينة : تانوغة</p>
                                    <p>9417 : رقم القيد في السجل التجاري</p>
                                </div>
                                <div style="display: flex; flex-direction:row; justify-content: flex-end;">
                                    <p style="margin-right: 100px;">الفاكس : 0665342776</p>
                                    <p>0665342776 : الهاتف</p>
                                </div>
                                <p>: البريد الإلكتروني</p>
                                <div align="left" style="font-size: 14px;font-weight: bold; margin-left: 2rem;">
                                    <p>المسماة "المؤسسة " مؤسسة أيت امحند</p>
                                </div>
                                <p>والسيد (ة) : <?php echo e($dossier->student->a_lastname); ?> <?php echo e($dossier->student->a_firstname); ?></p>
                                <div style="display: flex; flex-direction:row; justify-content: flex-end;">
                                    <p style="margin-right: 50px;">بتاريخ : <?php echo e($dossier->student->date_birth ? \Carbon\Carbon::parse($dossier->student->date_birth)->format('d/m/Y') : ''); ?></p>
                                    <p style="margin-right: 50px;">المزداد(ة) ب : <?php echo e($dossier->student->a_place_birth); ?></p>
                                    <p><?php echo e($dossier->student->cin); ?> : رقم ب.و.ت.إ</p>
                                </div>
                                <p>القاطن (ة) ب : <?php echo e($dossier->student->a_address); ?></p>
                                <p><?php echo e($dossier->ref); ?> : (Référence web) رقم تسجيل المرشح الممنوح من طرف الإدارة</p>
                                <div align="left" style="font-size: 14px;font-weight: bold; margin-left: 2rem;">
                                    <p>"المسمى(ة) "المرشح (ة)</p>
                                </div>
                                <div align="center" style="font-size: 14px;font-weight: bold;">
                                    <p>اتفـــــــق الطرفـــــــان علـــــى ما يلــــــي</p>
                                </div>
                                <div align="right" style="font-size: 14px;font-weight: bold;">
                                    <p style="border-bottom: 2px solid black; width:140px;">المادة الأولـــى : موضوع العقد</p>
                                </div>
                                <p>يهدف هذا العقد إلى تكوين المرشح وتمكينه من اكتساب المعارف والمهارات الضرورية اللازمة التي
                                    تمكنه من سياقة مركبة تتطلب قيادتها رخصة السياقة من صنف '' ب ''، طبقا للبرامج المحددة من
                                    طرف الإدارة.
                                </p>
                                <p>
                                    كما يحدد حقوق وواجبات كلا الطرفين مع مراعاة القوانين والأنظمة الجاري بها العمل في هذا
                                    الشأن.
                                </p>
                                <div align="right" style="font-size: 14px;font-weight: bold;">
                                    <p style="border-bottom: 2px solid black; width:90px;">المادة 2 : مدة العقد</p>
                                </div>
                                <p>يمتد هذا العقد لمدة ستة أشهر ابتداء من تاريخ توقيعه. ويمكن تمديده، في حالة الاتفاق بين
                                    الطرفين، لمدة لا تتعدى ثلاثة أشهر</p>
                                <div align="right" style="font-size: 14px;font-weight: bold;">
                                    <p style="border-bottom: 2px solid black; width:130px;">المادة 3 : التزامات المؤسسة</p>
                                </div>
                                <p>تلتزم المؤسسة بتكوين المرشح طبقا للبرنامج الوطني لتعليم السياقة
                                    <br>
                                    تلقن الدروس النظرية والتطبيقية، تحت إشراف مدير المؤسسة، من طرف مدرب أو مدربي تعليم
                                    السياقة مرخص لهم، تشغلهم المؤسسة لهذا الغرض وبواسطة مركبات لتعليم السياقة في ملكيتها.
                                    <br>
                                    تلتزم المؤسسة بتوفير المركبة التي يتم بواسطتها إجراء الاختبار التطبيقي.
                                    <br>
                                    لا يمكن الشروع في التكوين النظري إلا بعد حصول المرشح على رقم التسجيل الممنوح له من طرف
                                    الإدارة.
                                    <br>
                                    تلتزم المؤسسة بإخبار المرشح فورا بحصوله على هذا الرقم، كما تلتزم بتسليم المرشح شهادة
                                    نهاية التكوين فور إنهائه له.
                                </p>
                            </div>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Second Page -->
    <table align="center" border="0" cellpadding="0" cellspacing="0" style="height:842px; width:700px;font-size:12px; margin-top: 5rem; padding: 5px;">
        <tbody>
            <tr>
                <td valign="top">
                    <table width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                            <div align="right" style="font-size: 14px;">
                                <p>
                                    تحتفظ المؤسسة بحق إرجاء دروس التكوين إلى تاريخ لاحق في حالة قوة قاهرة وفي كل الحالات
                                    التي تكون فيها السلامة غير متوفرة.
                                    <br>
                                    بعد استفادة المرشح من عدد ساعات التكوين النظري والتطبيقي المتفق عليها، تلتزم المؤسسة
                                    بتقديمه لاجتياز الامتحانات لنيل رخصة السياقة في حدود المقاعد الممنوحة من طرف الإدارة.
                                </p>
                                <div align="right" style="font-size: 14px;font-weight: bold;">
                                    <p style="border-bottom: 2px solid black; width:130px;">المادة 4 : التزامات المرشح</p>
                                </div>
                                <p>
                                    إذا توقف المرشح عن التكوين، سواء بصفة مؤقتة أو نهائية، وكيفما كانت الأسباب، يلتزم بإخبار
                                    المؤسسة كتابيا،
                                    <br>
                                    في حالة التوقف لأكثر من ثلاثة (3) أشهر متتالية، يحق للمؤسسة مطالبة المرشح بأداء مبالغ
                                    الخدمات المتبقية، وغير المؤداة ؛
                                    <br>
                                    إذا انقطع المرشح عن التكوين لمدة تفوق ستة (6) أشهر، يعتبر متخليا عن التكوين ولا يحق له
                                    أن يسترجع ما دفعه من أجله.
                                    <br>
                                    إذا تخلى المرشح عن التكوين لسبب يعود له، يؤدي التعريفة كاملـة.
                                    <br>
                                    في حالة عدم النجاح في الامتحان، يلتزم المرشح بأداء مصاريف إعادة تكوينه وفقا لنفس
                                    التعريفة.
                                </p>
                                <div align="right" style="font-size: 14px;font-weight: bold;">
                                    <p style="border-bottom: 2px solid black; width:100px;">المادة 5 : مدة التكوين</p>
                                </div>
                                <p>
                                    اتفق الطرفان على تحديد عدد ساعات التكوين في 20 ساعة بالنسبة للتكوين النظري و 20 ساعة
                                    بالنسبة للتكوين التطبيقي. لا يقل هذا العدد عن العدد الأدنى المحدد بالمادة 32 من دفتر
                                    التحملات الخاص بفتح واستغلال مؤسسات تعليم السياقة.
                                </p>
                                <div align="right" style="font-size: 14px;font-weight: bold;">
                                    <p style="border-bottom: 2px solid black; width:115px;">المادة 6 : تعريفة التكوين</p>
                                </div>
                                <p>
                                    تحتسب التعريفة الإجمالية للتكوين على أساس تعريفة ساعة التكوين النظري والتطبيقي المحددة
                                    في المادة 1 من القرار الذي يحدد تعريفة ساعة التكوين النظري والتطبيقي.
                                </p>
                                <div align="right" style="font-size: 14px;font-weight: bold;">
                                    <p style="border-bottom: 2px solid black; width:110px;">المادة 7 : كيفيات الأداء</p>
                                </div>
                                <p>
                                    تسلم للمرشح فاتورة تحدد المبالغ المدفوعة للمؤسسة. تكون هذه الفاتورة مؤرخة وموقعة من طرف
                                    صاحب المؤسسة تحمل هذه الفاتورة اسم وطابع المؤسسة، وفقا للتشريعات الجاري بها العمل.
                                    <br>
                                    في حالة الاتفاق بين الطرفين، يمكن أداء مبلغ التكوين على أقساط.
                                </p>
                                <p align="center">عقد محرر في ثلاثة نظائر أصلية</p>
                                <p align="center">....................................................... في ..........................................................................بتاريخ</p>
                                <div style="display: flex; flex-direction:row; justify-content: flex-end; margin-top: 30px;">
                                    <p style="margin-right: 50px; font-size: 16px; font-weight: bold; border-bottom:2px solid black;">توقيع المرشح أو ولي أمره مصادق عليه</p>
                                    <p style="margin-right: 50px; font-size: 16px; font-weight: bold; border-bottom:2px solid black;">توقيع صاحب المؤسسة أو ممثله القانوني</p>
                                </div>
                            </div>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <script>
        function printContract() {
            document.querySelector('.print-button').style.display = 'none';
            window.print();
            setTimeout(function() {
                document.querySelector('.print-button').style.display = 'block';
            }, 100);
        }
    </script>
</body>
</html> <?php /**PATH D:\laravel\volt-laravel-dashboard\resources\views/contract/show.blade.php ENDPATH**/ ?>