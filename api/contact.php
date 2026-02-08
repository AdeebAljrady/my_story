<?php session_start();?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تواصل معنا</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/contact.css">

</head>
<body>
<?php require "./php/header.php" ?>
<section class="contact" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section_title text-center">
                    <h2>تواصل معنا</h2>
                    <div class="brand_border">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                        <i class="fas fa-envelope"></i>
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </div>
                    <p>
                        نحن هنا لمساعدتكم! يُمكنكم التواصل مع فريقنا للحصول على المساعدة أو لطرح الاستفسارات حول خدماتنا، فرص الشراكة، والمزيد. نتطلع إلى سماع أفكاركم واقتراحاتكم لتقديم أفضل ما لدينا.                    </p>
                </div>
            </div>
        </div>

        <div class="row row-form ">
            <div class="col-md-5">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>الوقت</th>
                                        <th>الرد</th>
                                        <th>الاستفسارات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>من الأحد إلى الخميس</td>
                                        <td>8 صباحًا - 5 مساءً</td>
                                        <td>9 صباحًا - 4 مساءً</td>
                                    </tr>
                                    <tr>
                                        <td>الجمعة والسبت</td>
                                        <td>مغلق</td>
                                        <td>مغلق</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <!-- Info-1 -->
                    <div class="info">
                        <i class="fab fa-whatsapp"></i>
                        <h4 class="d-inline-block">واتس اب  :
                            <br>
                            <span><a href="">+966 123 123 </a></span></h4>
                    </div>
                    <!-- Info-2 -->
                    <div class="info">
                        <i class="far fa-envelope"></i>
                        <h4 class="d-inline-block">الايميل :
                            <br>
                            <span> <a href="">example@example.com</a> </span></h4>
                    </div>
                    <!-- Info-3 -->
                    <div class="info">
                        <i class="fab fa-twitter"></i>
                        <h4 class="d-inline-block">تويتر :<br>
                            <span><a href="">https://twitter.com/exampl@example.com</a></span></h4>
                    </div>
                </div>
            </div>

            <div class="col-md-7">

                <form>
                    <div class="row ">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" placeholder="الاسم">
                        </div>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" placeholder="البريد الإلكتروني">
                        </div>
                        <div class="col-sm-12">
                            <textarea class="form-control" rows="5" placeholder="الرسالة"></textarea>
                        </div>
                        <div class="col-md-12">
                            <form action="upload.php" method="post" enctype="multipart/form-data">
                                <div class="form-control">
                                    <label for="file-upload"> </label>
                                    <input type="file" id="file-upload" name="file-upload">
                                </div>
                        
                            </form>
                        </div>
                        
                    </div>

                    <button class="btn btn-block" type="submit"   onclick="showAlert()">إرسال  </button>
                </form>
            </div>
        </div>
        
    </div>  
</section>

<?php require "./php/footer.php" ?>

<script>
  
    function showAlert() {
        alert("سنقوم بالرد عليك في أقرب وقت");
    }
</script>
</body>
</html>
