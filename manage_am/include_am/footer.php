<style>
    .footer {
        background-color: #5949D6;
        /* เปลี่ยนสีพื้นหลังที่นี่ */
        color: white;
        padding: 50px 0;
    }
</style>

<footer class="footer text-center">
    <div class="container">
        <h4 class="mb-0">ศูนย์ส่งเสริมการเรียนรู้ระดับอำเภอโคกโพธิ์</h4>
        <h4>License by Sirasit Suwannarat</h4>
        <!-- <h4>โทร: (123) 456-7890 </h4>
        <h4 class="mb-0"> อีเมล: example@example.com</h4> -->
    </div>
</footer>

<button type="button" class="waves-effect waves-circle btn btn-circle btn-primary btn-sm mb-5" id="btn_upto_top"><i class="ti-angle-up"></i></button>

<script>
    $(document).ready(function() {
        $(window).scroll(function() {
            if ($(window).scrollTop() > 100) {
                $('#btn_upto_top').fadeIn();
            } else {
                $('#btn_upto_top').fadeOut();
            }
        });

        // เมื่อคลิกที่ปุ่ม ให้เลื่อนขึ้นไปด้านบน
        $('#btn_upto_top').click(function() {
            $('html, body').animate({
                scrollTop: 0
            }, 'smooth');
        });
    });
</script>