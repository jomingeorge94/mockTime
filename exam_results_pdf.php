<?php 
    include 'core/session.php';
    require_once '/core/mpdf/mpdf.php';
    

    $retrieving_data = retrieve_exam_user_detail_basedon_student_summaryid($_GET['student_sum_id'],$_GET['quiz_id']);
    //die(var_dump($retrieving_data));
    $user_detail = getuserdetail ($retrieving_data[0]['user_id']);
    
    

    $title = $retrieving_data[0]['quiz_name'];
	$filename = $retrieving_data[0]['quiz_name'] ." - Result.pdf";
	
    // set page margins and page type
    $mpdf = new mPDF('utf-8', 'A4', 0, '', '10', '10', '25', '10', '5', '5', 'L');
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->SetTitle($title);
    

   /* $stylesheet = file_get_contents(get_site_url() . 'bootstrap/css/bootstrap_2.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $stylesheet3 = file_get_contents(get_site_url() . 'bootstrap/css/print_style.css');
    $mpdf->WriteHTML($stylesheet3, 1);*/

    // if you want to show watermark
    if (true) {
        $mpdf->SetWatermarkText('mockTime');
        $mpdf->showWatermarkText = true;
        $mpdf->watermarkTextAlpha = 0.1;
    }


    $headerHTML = '<table cellspacing="0" cellpadding="0" width="100%" style="background-color:#140D40;color:#fff;border:none;width:100%;border-collapse:collapse; margin:auto;">'
            . '<tr>'
            . '<td width="100%" valign="top" align="left"><h2>mockTime</h2><p style="font-size:12px;">Student Name : '. $user_detail[3] .' '. $user_detail[4] .' </p> </td>'
            . '</tr></table><div style="width:100%;border-top:1px solid #000;height:10px;"></div>';

    $footerHTML = '<div style="width:100%;border-top:1px solid #000;height:10px;"></div><table cellspacing="0" cellpadding="0" width="100%" style="border:none;width:100%;border-collapse:collapse; margin:auto;">'
            . '<tr>'
            . '<td width="100%" valign="middle" align="left">Generated time: ' . date("l jS \of F Y h:i:s A") . '</td>'
            . '</tr></table>';

    $mpdf->SetHTMLHeader($headerHTML);
    $mpdf->SetHTMLFooter($footerHTML);
    
    $body .= '<div class="padding30;"></div><h3 style="text-align:center">Mock Exam Result</h3><table class="table table-bordered table-condensed table-datatable table-hover">
        <tr>
          <td style="text-align: left;" width="40%">Exam Name:</td>
          <td style="text-align: left;" width="60%">'. $retrieving_data[0]["quiz_name"] .'</td>
        </tr>
         <tr>
          <td style="text-align: left;">Exam Duration:</td>
          <td style="text-align: left;">'. $retrieving_data[0]["quiz_duration"].' minutes</td>
        </tr>
        <tr>
          <td style="text-align: left;">Total Question:</td>
          <td style="text-align: left;">'. $retrieving_data[0]["total_questions"].'</td>
        </tr>
        <tr>
          <td style="text-align: left;">Correct Answers:</td>
          <td style="text-align: left;">'. $results[0]["tr_correct_answer"] .'</td>
        </tr>
        <tr>
          <td style="text-align: left;">Time Taken:</td>
          <td style="text-align: left;">'. $retrieving_data[0]["time_taken"] .'</td>
        </tr>';
    
        $v = ($results[0]["tr_correct_answer"]/$results[0]["tr_total_question"])*100; 
        
         $body .= '<tr>
          <td style="text-align: left;">Score%:</td>
          <td style="text-align: left;">'. round($v, 2).'%'.'</td>
        </tr>
      </table>';
    
    $mpdf->WriteHTML($body, 2);
    $mpdf->Output($filename, 'D');
    exit;

?>