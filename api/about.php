<?php session_start();?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title> عن المتجر </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/about.css">
</head>
<body>
<?php require "./php/header.php" ?>
<section class="faq_section container">


    <div class="section_title text-center">
        <h2>عن المتجر </h2>
        <div class="brand_border">
            <i class="fa fa-minus" aria-hidden="true"></i>
            <i class="fas fa-info-circle"></i>
            <i class="fa fa-minus" aria-hidden="true"></i>
        </div>
        <p>اكتشف موقع قطعتي لبيع قطع غيار السيارات بأسعار معقولة وجودة عالية، يقدم قطعًا مستعملة ومجددة لمختلف أنواع
            السيارات.</p>
    </div>
    <div class="section_title text-center">
        <h2> معلومات حول متجر قطعتي</h2>
    </div>


    <div class="accordion">
        <!-- السؤال 1 -->
        <div class="accordion-item">
            <button id="accordion-button-1" aria-expanded="false"><span class="accordion-title">ما هي أنواع قطع الغيار التي يقدمها المتجر؟</span><span
                        class="icon" aria-hidden="true"></span></button>
            <div class="accordion-content">
                <p>يوفر متجرنا مجموعة واسعة من قطع الغيار المستعملة والجديدة لمختلف أنواع وموديلات السيارات، بما في ذلك
                    القطع النادرة والصعبة العثور عليها.</p>
            </div>
        </div>
        <!-- السؤال 2 -->
        <div class="accordion-item">
            <button id="accordion-button-2" aria-expanded="false"><span class="accordion-title">كيف يمكن التأكد من جودة القطع المستعملة؟</span><span
                        class="icon" aria-hidden="true"></span></button>
            <div class="accordion-content">
                <p>نلتزم في متجرنا بمعايير صارمة لفحص واختبار القطع المستعملة لضمان جودتها وأدائها، ونوفر ضماناً على
                    القطع لتأكيد ثقتنا بما نقدمه.</p>
            </div>
        </div>
        <!-- السؤال 3 -->
        <div class="accordion-item">
            <button id="accordion-button-3" aria-expanded="false"><span class="accordion-title">هل يمكن شحن قطع الغيار إلى مواقع خارج المدينة؟</span><span
                        class="icon" aria-hidden="true"></span></button>
            <div class="accordion-content">
                <p>نعم، نقدم خدمات شحن لجميع أنحاء المملكة وبعض الدول المجاورة بأسعار معقولة، مع توفير خيارات شحن سريعة
                    وآمنة.</p>
            </div>
        </div>
        <!-- السؤال 4 -->
        <div class="accordion-item">
            <button id="accordion-button-4" aria-expanded="false"><span class="accordion-title">ما هي سياسة الإرجاع والاستبدال في المتجر؟</span><span
                        class="icon" aria-hidden="true"></span></button>
            <div class="accordion-content">
                <p>نوفر سياسة إرجاع مرنة تتيح استبدال القطع أو استرداد المال خلال فترة محددة في حال لم تلبِ القطعة
                    توقعات العميل أو كانت بها عيوب تصنيع.</p>
            </div>
        </div>
        <!-- السؤال 5 -->
        <div class="accordion-item">
            <button id="accordion-button-5" aria-expanded="false"><span class="accordion-title">كيف يمكن التواصل مع خدمة العملاء للاستفسار أو الشكوى؟</span><span
                        the="icon" aria-hidden="true"></span></button>
            <div class="accordion-content">
                <p>يمكن للعملاء التواصل معنا عبر الهاتف، البريد الإلكتروني، أو من خلال زيارة المتجر مباشرة. فريق خدمة
                    العملاء لدينا مستعد دائماً لمساعدتكم والرد على جميع استفساراتكم.</p>
            </div>
        </div>
    </div>
    <br>
    <div class="section_title text-center">
        <h2>الشروط والأحكام الخاصة بكل من المستخدم والبائع</h2>
    </div>
    <div class="accordion">
        <!-- السؤال 1 -->
        <div class="accordion-item">
            <button id="accordion-button-1" aria-expanded="false"><span class="accordion-title">ما هي شروط استخدام متجر قطعتي للمستخدمين والبائعين؟</span><span
                        class="icon" aria-hidden="true"></span></button>
            <div class="accordion-content">
                <p>الشروط والأحكام المعمول بها في متجر قطعتي تشمل الالتزام بالقوانين المحلية وأنظمة المملكة العربية
                    السعودية، ويجب على كل مستخدم أو بائع الالتزام بالمعايير المحددة في اتفاقية الاستخدام قبل التسجيل أو
                    استخدام المنصة.</p>
            </div>
        </div>
        <!-- السؤال 2 -->
        <div class="accordion-item">
            <button id="accordion-button-2" aria-expanded="false"><span class="accordion-title">كيف تحمي المنصة حقوق المستخدمين والبائعين؟</span><span
                        class="icon" aria-hidden="true"></span></button>
            <div class="accordion-content">
                <p>متجر قطعتي يحمي حقوق جميع الأطراف من خلال الفحص الدقيق للمحتوى والإعلانات وضمان الالتزام بالمعايير
                    الأخلاقية والقانونية، بما في ذلك حقوق الملكية الفكرية والتجارية.</p>
            </div>
        </div>
        <!-- السؤال 3 -->
        <div class="accordion-item">
            <button id="accordion-button-3" aria-expanded="false"><span class="accordion-title">ما هي الإجراءات المتبعة في حالة المخالفات؟</span><span
                        class="icon" aria-hidden="true"></span></button>
            <div class="accordion-content">
                <p>في حالة وجود أي مخالفات لشروط الاستخدام، يحق لمتجر قطعتي اتخاذ الإجراءات اللازمة بما في ذلك حجب
                    العضوية، إحالة المخالفات للجهات المختصة، وفرض العقوبات المناسبة حسب الحاجة.</p>
            </div>
        </div>
        <!-- السؤال 4 -->
        <div class="accordion-item">
            <button id="accordion-button-4" aria-expanded="false"><span class="accordion-title">كيف يمكن للمستخدمين والبائعين تحديث بياناتهم ومعلومات العضوية؟</span><span
                        class="icon" aria-hidden="true"></span></button>
            <div class="accordion-content">
                <p>يجب على المستخدمين والبائعين في متجر قطعتي تحديث بياناتهم ومعلومات العضوية بشكل دوري لضمان الدقة
                    والتحديث، ويمكن القيام بذلك من خلال الإعدادات الخاصة بالحساب في المنصة.</p>
            </div>
        </div>
    </div>

</section>
<?php require "./php/footer.php" ?>

<script>

    const items = document.querySelectorAll(".accordion button");

    function toggleAccordion() {
        const itemToggle = this.getAttribute('aria-expanded');

        for (i = 0; i < items.length; i++) {
            items[i].setAttribute('aria-expanded', 'false');
        }

        if (itemToggle === 'false') {
            this.setAttribute('aria-expanded', 'true');
        }
    }

    items.forEach(item => item.addEventListener('click', toggleAccordion));
</script>
</body>
</html>
