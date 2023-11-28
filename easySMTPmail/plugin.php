<?php

class EasySMTPmail extends Plugin
{
    public function init()
    {
        $this->dbFields = array(
            'host' => '',
            'SMTPAuth' => '',
            'Username' => '',
            'Password' => '',
            'SMTPSecure' => '',
            'Port' => '',
            'subject' => '',
            'setFrom' => '',
            'addAddress' => '',
            'secretKey' => '',
            'siteKey' => '',
            'success' => '',
            'error' => '',
            'lang-name' => '',
            'lang-email' => '',
            'lang-phone' => '',
            'lang-message' => '',
            'lang-privacy' => '',
            'lang-submit' => '',
            'mailorsmtp' => 'smtp',
        );
    }

    public function form()
    {

        include($this->phpPath() . '/PHP/settings.php');

        echo "
        <div style='box-sizing:border-box; display:grid; align-items:center;width:100%;grid-template-columns:1fr auto; padding:10px !important;background:#fafafa;border:solid 1px #ddd;margin-top:20px;'>
        <b>Support my work:) Buy me coffe!:)</b>
            <script type='text/javascript' src='https://storage.ko-fi.com/cdn/widget/Widget_2.js'></script><script type='text/javascript'>kofiwidget2.init('Support Me on Ko-fi', '#29abe0', 'I3I2RHQZS');kofiwidget2.draw();</script> ";
    }


    public function showForm($match = '')
    {
        if (isset($_POST['send-easySMTPmail'])) {


            // Autoload PHPMailer classes if not using Composer
            require $this->phpPath() . 'PHP/src/Exception.php';
            require $this->phpPath() . 'PHP/src/PHPMailer.php';
            require $this->phpPath() . 'PHP/src/SMTP.php';

            // Your reCAPTCHA secret key
            $recaptchaSecretKey = $this->getValue('secretKey');

            // Verify reCAPTCHA
            if (isset($_POST['g-recaptcha-response'])) {
                $recaptchaResponse = $_POST['g-recaptcha-response'];
                $recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecretKey}&response={$recaptchaResponse}";
                $recaptchaData = json_decode(file_get_contents($recaptchaUrl));

                if (!$recaptchaData->success) {
                    $_POST['info'] = '<div class="easySMTPerror">reCAPTCHA error</div>';
                }
            } else {
                $_POST['info'] = '<div class="easySMTPerror">reCAPTCHA error</div>';
            }


            if (!isset($_POST['info'])) {
                // Get form data
                $name = $_POST['name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');


                // Create a PHPMailer object
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                try {
                    // Server settings

                    if ($this->getValue('mailorsmtp') == 'smtp') {
                        $mail->isSMTP();
                        $mail->Host = $this->getValue('host'); // Change this to your SMTP server
                        $mail->SMTPAuth = (bool)$this->getValue('SMTPAuth');
                        $mail->Username = $this->getValue('Username'); // Change this to your SMTP username
                        $mail->Password = $this->getValue('Password'); // Change this to your SMTP password
                        $mail->SMTPSecure = $this->getValue('SMTPSecure');
                        $mail->Port = intval($this->getValue('Port'));
                    } else {
                        $mail->IsMail();
                    };

                    $mail->CharSet = 'UTF-8';
                    $mail->IsHTML(true);
                    $mail->ContentType = 'text/html; charset=UTF-8';


                    // Recipients
                    $mail->setFrom($this->getValue('setFrom')); // Change this to your email and name
                    $mail->addAddress($this->getValue('addAddress')); // Change this to the recipient's email and name

                    $mail->addReplyTo($email, $name);

                    // Content
                    $mail->isHTML(false);
                    $mail->Subject = $this->getValue('subject');
                    $mail->Body = "Name: $name\nEmail: $email\nPhone: $phone\n\n$message";

                    // Send the email
                    $mail->send();
                    $_POST['info'] = '<div class="easySMTPsuccess">' . $this->getValue('success') . '</div>';
                } catch (Exception $e) {
                    $_POST['info'] = '<div class="easySMTPerror">' . $this->getValue('error') . ' ' . $mail->ErrorInfo . '</div>';
                };
            };
        };

        $html = '
        <link rel="stylesheet" href="' . DOMAIN_PLUGINS . 'easySMTPmail/css/style.css">
        
        <form method="post" class="easySMTPform">
            <label for="name">';

        if ($this->getValue('lang-name') !== '') {

            $html .= $this->getValue('lang-name');
        } else {
            $html .= 'Name:';
        };

        $html .= '  </label>
                <input type="text" name="name" required>
            
                <label for="email">';


        if ($this->getValue('lang-email') !== '') {
            $html .= $this->getValue('lang-email');
        } else {
            $html .= 'E-mail:';
        };


        $html .= '  </label>
            <input type="email" name="email" required>
        
            <label for="phone">';

        if ($this->getValue('lang-phone') !== '') {
            $html .= $this->getValue('lang-phone');
        } else {
            $html .=  'Phone:';
        };

        $html .= '</label>
        <input type="tel" name="phone">
        
        <label for="message">';

        if ($this->getValue('lang-message') !== '') {
            $html .= $this->getValue('lang-message');
        } else {
            $html .= ' Message:';
        };
        $html .= '</label>
        <textarea name="message" rows="4" required></textarea>
        
        <label for=""><input type="checkbox" required>';


        if ($this->getValue('lang-privacy') !== '') {
            $html .=  $this->getValue('lang-privacy');
        } else {
            $html .= 'I accept the privacy policy';
        };

        $html .= '</label>
        <div class="g-recaptcha" data-sitekey="';

        if ($this->getValue('siteKey') !== '') {
            $html .= $this->getValue('siteKey');
        };

        $html .= '"></div>
        <input type="submit" name="send-easySMTPmail" value="';

        if ($this->getValue('lang-submit') !== '') {
            $html .= $this->getValue('lang-submit');
        } else {
            $html .= 'Send Message';
        };

        $html .= '">';
        if (isset($_POST['info'])) {
            echo $_POST['info'];
        };

        $html .= '</form>
        
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>';

        return $html;
    }


    public function pageBegin()
    {

        global $page;

        $newcontent = preg_replace_callback(
            '/\\[% easySMTPmail %\\]/i',
            [$this, 'showForm'],
            $page->content()
        );


        global $page;
        $page->setField('content', $newcontent);
    }
};


function easySMTPmail()
{

    $smtpMail = new EasySMTPmail();
    $smtpMail->showform();
};
