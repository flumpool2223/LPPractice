<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';
require './env.php';

$mail = new PHPMailer(true);

if($_POST["plan"] == "standard") {
    $_POST["plan"] = "スタンダードルーム";
} else if($_POST["plan"] == "deluxe") {
    $_POST["plan"] = "デラックスルーム";
} else if ($_POST["plan"] == "premier") {
    $_POST["plan"] = "プレミアスィート";
}

if(empty($_POST["request"])) {
    $_POST["request"] = "";
}

try {
    //Gmail 認証情報
    $host = SMTP_HOST;
    $username = SMTP_USER; // example@gmail.com
    $password = SMTP_PASS;

    //差出人
    $from = MAIL_FROM;
    $fromname = 'LP_Practice';

    //宛先
    $to = MAIL_FROM;
    $toname = 'テスト様';

    //件名・本文
    $subject = "{$_POST["name"]}様からご予約を承りました";
//     $body =
//     "
// 氏名：{$_POST["name"]}様
// メールアドレス：{$_POST["email"]}
// 電話番号：{$_POST['tel']}
// 郵便番号：{$_POST['address']}
// 都道府県：{$_POST['prefecture']}
// 市区町村：{$_POST['city']}
// 町域・番地、建物名：{$_POST['house_number']}
// チェックイン日：{$_POST['checkin']}
// チェックアウト日：{$_POST['checkout']}
// ご希望の宿泊プラン：{$_POST['plan']}
// 大人の人数：{$_POST['adult']}
// 子供の人数：{$_POST['kids']}
// 特別リクエスト：{$_POST['request']}
//     ";

     $body = <<<EOD
     氏名：{$_POST['name']}様
     メールアドレス：{$_POST['email']}
     電話番号：{$_POST['tel']}
     郵便番号：{$_POST['address']}
     都道府県：{$_POST['prefecture']}
     市区町村：{$_POST['city']}
     町域・番地、建物名：{$_POST['house_number']}
     チェックイン日：{$_POST['checkin']}
     チェックアウト日：{$_POST['checkout']}
     ご希望の宿泊プラン：{$_POST['plan']}
     大人の人数：{$_POST['adult']}
     子供の人数：{$_POST['kids']}
     特別リクエスト：{$_POST['request']}
EOD;


    //メール設定
    // $mail->SMTPDebug = 2; //デバッグ用
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = $host;
    $mail->Username = $username;
    $mail->Password = $password;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->CharSet = "utf-8";
    $mail->Encoding = "base64";
    $mail->setFrom($from, $fromname);
    $mail->addAddress($to, $toname);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    //メール送信
    $mail->send();
    header("Location:thanks.php");
    exit();
} catch (Exception $e) {
    echo '失敗: ', $mail->ErrorInfo;
}