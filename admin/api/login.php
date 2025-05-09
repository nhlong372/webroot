<?php
session_start();
define('LIBRARIES', '../../libraries/');

require_once LIBRARIES . "config.php";
require_once LIBRARIES . 'autoload.php';
new AutoLoad();
$injection = new AntiSQLInjection();
$d = new PDODb($config['database']);
$cache = new Cache($d);
$func = new Functions($d, $cache);

$username = (!empty($_POST['username'])) ? $_POST['username'] : '';
$password = (!empty($_POST['password'])) ? $_POST['password'] : '';
$error = "";
$success = "";
$login_failed = false;

/* Kiểm tra đăng nhập tài khoản sai theo số lần */
$ip = $func->getRealIPAddress();
$row = $d->rawQuery("select id, login_ip, login_attempts, attempt_time, locked_time from #_user_limit WHERE login_ip = ? order by id desc limit 1", array($ip));

if (!empty($row) && count($row) == 1) {
    $id_login = $row[0]['id'];
    $time_now = time();
    if ($row[0]['locked_time'] > 0) {
        $locked_time = $row[0]['locked_time'];
        $delay_time = $config['login']['delay'];
        $interval = $time_now  - $locked_time;

        if ($interval <= $delay_time * 60) {
            $time_remain = $delay_time * 60 - $interval;
            $error = "Xin lỗi..! Vui lòng thử lại sau " . round($time_remain / 60) . " phút..!";
        } else {
            $d->rawQuery("update #_user_limit set login_attempts = 0, attempt_time = ?, locked_time = 0 where id = ?", array($time_now, $id_login));
        }
    }
}

/* Còn số lần đăng nhập */
if ($error == '') {
    /* Kiểm tra thông tin đăng nhập */
    if ($username == '' && $password == '') {
        $error = "Chưa nhập tên đăng nhập và mật khẩu";
    } else if ($username == '') {
        $error = "Chưa nhập tên đăng nhập";
    } else if ($password == '') {
        $error = "Chưa nhập mật khẩu";
    } else {
        /* Kiểm tra đăng nhập */
        $row = $d->rawQueryOne("select * from #_user where username = ? and find_in_set('hienthi',status) limit 0,1", array($username));

        if (!empty($row['id'])) {
            if (($row['password'] == $func->encryptPassword($config['website']['secret'], $password, $config['website']['salt']))) {
                $timenow = time();
                $id_user = $row['id'];
                $ip = $func->getRealIPAddress();
                $token = md5(time());
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                $sessionhash = md5(sha1($row['password'] . $row['username']));

                /* Ghi log truy cập thành công */
                $d->rawQuery("insert into #_user_log (id_user, ip, timelog, user_agent) values (?,?,?,?)", array($id_user, $ip, $timenow, $user_agent));

                /* Tạo log và login session */
                $d->rawQuery("update #_user set login_session = ?, lastlogin = ?, user_token = ? where id = ?", array($sessionhash, $timenow, $token, $id_user));

                /* Khởi tạo Session để kiểm tra số lần đăng nhập */
                $d->rawQuery("update #_user set login_session = ?, lastlogin = ? where id = ?", array($sessionhash, $timenow, $id_user));

                /* Reset số lần đăng nhập và thời gian đăng nhập */
                $limitlogin = $d->rawQuery("select id, login_ip, login_attempts, attempt_time, locked_time from #_user_limit where login_ip = ? order by id desc", array($ip));

                if (count($limitlogin) == 1) {
                    $id_login = $limitlogin[0]['id'];
                    $d->rawQuery("update #_user_limit set login_attempts = 0, locked_time = 0 where id = ?", array($id_login));
                }

                /* Tạo Session login */
                $_SESSION[$loginAdmin]['active'] = true;
                $_SESSION['isLoggedIn'] = $token;
                $_SESSION[$loginAdmin]['id'] = $row['id'];
                $_SESSION[$loginAdmin]['username'] = $row['username'];
                $_SESSION[$loginAdmin]['fullname'] = $row['fullname'];
                $_SESSION[$loginAdmin]['phone'] = $row['phone'];
                $_SESSION[$loginAdmin]['email'] = $row['email'];
                $_SESSION[$loginAdmin]['role'] = $row['role'];
                $_SESSION[$loginAdmin]['secret_key'] = $row['secret_key'];
                $_SESSION[$loginAdmin]['token'] = $sessionhash;
                $_SESSION[$loginAdmin]['password'] = $row['password'];
                $_SESSION[$loginAdmin]['login_session'] = $sessionhash;
                $_SESSION[$loginAdmin]['login_token'] = $token;
                $_SESSION['ckfinderkey'] = $config['website']['ckfinderkey'][$_SERVER['SERVER_NAME']];
                /* Tạo Session Token Website */
                $_SESSION[TOKEN] = true;

                /* Cập nhật quyền của user đăng nhập */
                $secret_key = $_SESSION[$loginAdmin]['token'];
                $d->rawQuery("update #_user set secret_key = ? where id = ?", array($secret_key, $row['id']));

                $success = "Đăng nhập thành công";
            } else {
                $login_failed = true;
                $error = "Mật khẩu không chính xác";
            }
        } else {
            $login_failed = true;
            $error = "Tên đăng nhập không tồn tại";
        }

        /* Xử lý khi đăng nhập thất bại */
        if ($login_failed) {
            $ip = $func->getRealIPAddress();
            $row = $d->rawQuery("select id,login_ip,login_attempts,attempt_time,locked_time from #_user_limit where login_ip = ? order by id desc limit 1", array($ip));

            if (count($row) == 1) {
                $id_login = $row[0]['id'];
                $attempt = $row[0]['login_attempts'];
                $noofattmpt = $config['login']['attempt'];
                if ($attempt < $noofattmpt) {
                    $attempt = $attempt + 1;

                    /* Cập nhật số lần đăng nhập sai */
                    $d->rawQuery("update #_user_limit set login_attempts = ? where id = ?", array($attempt, $id_login));

                    $no_ofattmpt = $noofattmpt + 1;
                    $remain_attempt = $no_ofattmpt - $attempt;
                    $error = 'Sai thông tin. Còn ' . $remain_attempt . ' lần thử';
                } else {
                    if ($row[0]['locked_time'] == 0) {
                        $attempt = $attempt + 1;
                        $timenow = time();

                        /* Cập nhật số lần đăng nhập sai */
                        $d->rawQuery("update #_user_limit set login_attempts = ?, locked_time = ? where id = ?", array($attempt, $timenow, $id_login));
                    } else {
                        $attempt = $attempt + 1;

                        /* Cập nhật số lần đăng nhập sai */
                        $d->rawQuery("update #_user_limit set login_attempts = ? where id = ?", array($attempt, $id_login));
                    }
                    $delay_time = $config['login']['delay'];
                    $error = "Bạn đã hết lần thử. Vui lòng thử lại sau " . $delay_time . " phút";
                }
            } else {
                $timenow = time();

                /* Cập nhật thông tin đăng nhập sai */
                $d->rawQuery("insert into #_user_limit (login_ip, login_attempts, attempt_time, locked_time) values (?,?,?,?)", array($ip, 1, $timenow, 0));

                $remain_attempt = $config['login']['attempt'];
                $error = 'Sai thông tin. Còn ' . $remain_attempt . ' lần thử';
            }
        }
    }
}

$data = array('success' => $success, 'error' => $error);
echo json_encode($data);
