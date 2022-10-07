<?php
          require "PHPMailer-master/PHPMailer-master/src/PHPMailer.php";  //nhúng thư viện vào để dùng, sửa lại đường dẫn cho đúng nếu bạn lưu vào chỗ khác
          require "PHPMailer-master/PHPMailer-master/src/SMTP.php"; //nhúng thư viện vào để dùng
          require 'PHPMailer-master/PHPMailer-master/src/Exception.php'; //nhúng thư viện vào để dùng
if (isset($_POST)) {
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);  //true: enables exceptions
    try {
      //  $mail->SMTPDebug = 2;  // 0,1,2: chế độ debug. khi mọi cấu hình đều tớt thì chỉnh lại 0 nhé
        $mail->isSMTP();
        $mail->CharSet  = "utf-8";
        $mail->Host = 'smtp.gmail.com';  //SMTP servers
        $mail->SMTPAuth = true; // Enable authentication
        $nguoigui = 'phuongdtt.21it@vku.udn.vn';
        $matkhau = 'ksazbvfxeltfxsii'; // đã tạo ở bước 3
        $tennguoigui = 'MRS Thu Phuong';
        $mail->Username = $nguoigui; // SMTP username
        $mail->Password = $matkhau;   // SMTP password
        $mail->SMTPSecure = 'ssl';  // encryption TLS/SSL 
        $mail->Port = 465;  // port to connect to                
        $mail->setFrom($nguoigui, $tennguoigui);
        // $to = $_POST['email'];
        // $to_name = "bạn";
        $to = $_POST['email'];
        $to_name = "Thu Phuong";
		$tieude = $_POST['tieude'];

        $recipients = "dothithuphuong592003@gmail.com,thittu.21it@vku.udn.vn,dungttq.21it@vku.udn,lienntn.21it@vku.udn.vn";
        $email_array = explode(",",$recipients);
        foreach($email_array as $email)
        {
           $to      =  $email;
           $mail->addAddress($to, $to_name); 
        }
        // $mail->addAddress($to, $to_name); //mail và tên người nhận  
		// $mail->addAddress("dothithuphuong592003@gmail.com","Thuphuong");
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = $tieude;
		$noidungthu = ' <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><b>Xin chào ' . $to_name . '</b></h5>
                    <h6 class="card-subtitle mb-2 text-muted"></h6>
                    <p class="card-text">' . $_POST['content'] . '</p>
                </div>
                </div> ';
        $mail->Body =  $noidungthu;	
			if(isset($_FILES['file']['name'])) {
                $uploadfile = tempnam(sys_get_temp_dir(), sha1($_FILES['file']['name']));
                if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile))
                    $mail->addAttachment($uploadfile, $_FILES['file']['name']);

            } 
        $mail->smtpConnect(array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                    "allow_self_signed" => true
                )
            ));
        if($mail->send())
		   {
			header("Location:index1.php");
		   }
    } catch (Exception $e) {
        
        echo 'Mail không gửi được. Lỗi: ', $mail->ErrorInfo;

    }	
}
