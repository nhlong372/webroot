<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include_once LIBRARIES . "PHPMailer/PHPMailer.php";
include_once LIBRARIES . "PHPMailer/SMTP.php";
include_once LIBRARIES . "PHPMailer/Exception.php";

class Email
{
    private $d;
    private $data = array();
    private $company = array();
    private $optcompany = '';

    function __construct($d)
    {
        $this->d = $d;
        $this->info();
    }

    private function info()
    {
        global $configBase;

        $logo = array();
        $social = array();
        $socialString = '';
        $this->company = $this->d->rawQueryOne("select options, namevi from #_setting limit 0,1");
        $this->optcompany = json_decode($this->company['options'], true);
        $logo = $this->d->rawQueryOne("select photo from #_photo where type = ? and act = ? limit 0,1", array('logo', 'photo_static'));
        $social = $this->d->rawQuery("select photo, link from #_photo where type = ? and find_in_set('hienthi',status) order by numb,id desc", array('social'));

        if ($social && count($social) > 0) {
            foreach ($social as $value) {
                $socialString .= '<a href="' . $value['link'] . '" target="_blank"><img src="' . $configBase . UPLOAD_PHOTO_L . $value['photo'] . '" style="max-height:30px;margin:0 0 0 5px" /></a>';
            }
        }

        $this->data['email'] = ($this->optcompany['mailertype'] == 1) ? $this->optcompany['email_host'] : $this->optcompany['email_gmail'];
        $this->data['color'] = '#94130F';
        $this->data['home'] = $configBase;
        $this->data['logo'] = '<img src="' . $configBase . UPLOAD_PHOTO_L . $logo['photo'] . '" style="max-height:70px;" >';
        $this->data['social'] = $socialString;
        $this->data['datesend'] = time();
        $this->data['company'] = $this->company['namevi'];
        $this->data['company:address'] = $this->optcompany['address'];
        $this->data['company:email'] = $this->optcompany['email'];
        $this->data['company:hotline'] = $this->optcompany['hotline'];
        $this->data['company:website'] = $this->optcompany['website'];
        $this->data['company:worktime'] = '(8-21h cả T7,CN)';
    }

    public function set($key, $value)
    {
        if (!empty($key) && !empty($value)) {
            $this->data[$key] = $value;
        }
    }

    public function get($key)
    {
        return (!empty($this->data[$key])) ? $this->data[$key] : '';
    }

    public function markdown($path = '', $params = array())
    {
        $content = '';

        if (!empty($path)) {
            ob_start();
            include dirname(__DIR__) . "/sample/mail/" . $path . ".php";
            $content = ob_get_contents();
            ob_clean();
        }

        return $content;
    }

    public function defaultAttrs()
    {
        $default = array();
        $default['vars'] = array(
            '{emailColor}',
            '{emailHome}',
            '{emailLogo}',
            '{emailSocial}',
            '{emailMail}',
            '{emailDateSend}',
            '{emailCompanyName}',
            '{emailCompanyWebsite}',
            '{emailCompanyAddress}',
            '{emailCompanyMail}',
            '{emailCompanyHotline}',
            '{emailCompanyWorktime}'
        );
        $default['vals'] = array(
            $this->get('color'),
            $this->get('home'),
            $this->get('logo'),
            $this->get('social'),
            $this->get('email'),
            'Ngày ' . date('d', time()) . ' tháng ' . date('m', time()) . ' năm ' . date('Y H:i:s', time()),
            $this->get('company'),
            $this->get('company:website'),
            $this->get('company:address'),
            $this->get('company:email'),
            $this->get('company:hotline'),
            $this->get('company:worktime')
        );

        return $default;
    }

    public function addAttrs($array1 = array(), $array2 = array())
    {
        if (!empty($array1) && !empty($array2)) {
            foreach ($array2 as $k2 => $v2) {
                array_push($array1, $v2);
            }
        }

        return $array1;
    }

    public function send($owner = '', $arrayEmail = array(), $subject = "", $message = "", $file = '')
    {
        $mail = new PHPMailer(true);
        $config_host = '';
        $config_port = 0;
        $config_secure = '';
        $config_email = '';
        $config_password = '';

        if ($this->optcompany['mailertype'] == 1) {
            $config_host = $this->optcompany['ip_host'];
            $config_port = $this->optcompany['port_host'];
            $config_secure = $this->optcompany['secure_host'];
            $config_email = $this->optcompany['email_host'];
            $config_password = $this->optcompany['password_host'];

            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPDebug = false;
            $mail->SMTPSecure = $config_secure;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
        } else if ($this->optcompany['mailertype'] == 2) {
            $config_host = $this->optcompany['host_gmail'];
            $config_port = $this->optcompany['port_gmail'];
            $config_secure = $this->optcompany['secure_gmail'];
            $config_email = $this->optcompany['email_gmail'];
            $config_password = $this->optcompany['password_gmail'];
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPDebug = false;
            $mail->SMTPSecure = $config_secure;
        }

        $mail->Host = $config_host;
        if ($config_port) {
            $mail->Port = $config_port;
        }
        $mail->Username = $config_email;
        $mail->Password = $config_password;
        $mail->SetFrom($config_email, $this->company['namevi']);

        if ($owner == 'admin') {
            $mail->AddAddress($this->optcompany['email'], $this->company['namevi']);
        } else if ($owner == 'customer') {
            if ($arrayEmail && count($arrayEmail) > 0) {
                foreach ($arrayEmail as $vEmail) {
                    $mail->AddAddress($vEmail['email'], $vEmail['name']);
                }
            }
        }
        $mail->AddReplyTo($this->optcompany['email'], $this->company['namevi']);
        $mail->CharSet = "utf-8";
        $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
        if ($file != '' && isset($_FILES[$file]) && !$_FILES[$file]['error']) {
            $mail->AddAttachment($_FILES[$file]["tmp_name"], $_FILES[$file]["name"]);
        }

        if ($mail->Send()) return true;
        else return false;
    }
}
