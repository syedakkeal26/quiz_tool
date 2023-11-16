<?php

// $exe_url = "http://localhost/cv_builder_laravel/public/api/pdf/47e01e06-c67e-404a-b5ec-dfa249292f68";
// $exe_url = "http://localhost/cv_builder_laravel/public/api/pdf/a5469451-8293-4404-a518-e413df8a803a";
$exe_url = "http://localhost/Quiz-tool/public/report_download/$id";

// $exe_url = "http://localhost/pdf/pdf_page.php";


$fileName = "assets/pdf_test/".time().".pdf";

// $command = 'C:\Users\CIPL0754\wkhtmltopdf\bin\wkhtmltopdf --footer-left '.$setDateform.' -B 10 -L 0 -R 0 -T 10 --page-width 264 --page-height 347 --disable-smart-shrinking '.$exe_url.' '.$fileName;
$command = 'C:\Users\CIPL\wkhtmltopdf\bin\wkhtmltopdf --page-width 250 --page-height 300 -B 10 -L 10 -R 10 -T 10 --disable-smart-shrinking '.$exe_url.' '.$fileName;
// $command = 'C:\Users\CIPL0754\wkhtmltopdf\bin\wkhtmltopdf --page-width 264 --page-height 347 -B 10 -L 0 -R 0 -T 0 --header-html '.$bgPath.' --disable-smart-shrinking '.$exe_url.' '.$fileName;
exec($command);
echo "<a target='_blank' href='".url($fileName)."' download>Pdf link</a>";
?>
