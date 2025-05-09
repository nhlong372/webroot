<?php
class Comments
{
    public $total;
    public $total_star;
    public $count_star;
    public $star;
    public $limitParentShow = 2;
    public $limitParentGet = 1;
    public $limitChildShow = 2;
    public $limitChildGet = 1;
    public $lists = [], $params = [];
    public $hasMedia;
    private $d;
    private $func;
    private $id_variant;
    private $type;
    private $errors = [], $response = [];

    public function __construct($d, $func, $id = 0, $type = '', $is_admin = false)
    {
        $this->d = $d;
        $this->func = $func;
        $this->hasMedia = true;

        if (!empty($id) && !empty($type)) {
            $this->id_variant = $id;
            $this->type = $type;
            $this->total = $this->total($is_admin);
            $this->count_star = $this->countStar();
            $this->star = (!empty($this->count_star)) ? json_decode($this->count_star, true) : null;
            $this->total_star = $this->totalStar();
            $this->lists = $this->lists($is_admin);
        }
    }

    private function response()
    {
        if (!empty($this->errors)) {
            $response['errors'] = $this->errors;
        } else {
            $response['success'] = true;
        }

        return json_encode($response);
    }

    public function countStar()
    {
        $count = array();

        for ($i = 1; $i <= 5; $i++) {
            $count[$i] = $this->getStar($i);
        }

        return json_encode($count);
    }

    private function getStar($star = 1)
    {
        $row = $this->d->rawQueryOne("select count(id) as num from #_comment where find_in_set('hienthi',status) and id_variant = ? and type = ? and star = ?", array($this->id_variant, $this->type, $star));
        return (!empty($row)) ? $row['num'] : 0;
    }

    private function totalStar()
    {
        $row = $this->d->rawQueryOne("select sum(star) as total_star from #_comment where find_in_set('hienthi',status) and id_variant = ? and type = ?", array($this->id_variant, $this->type));
        return $row['total_star'];
    }

    private function total($is_admin = false)
    {
        $where = (!empty($is_admin)) ? "" : "find_in_set('hienthi',status) and";
        $rows = $this->d->rawQuery("select * from #_comment where $where id_parent = 0 and id_variant = ? and type = ? order by date_posted desc", array($this->id_variant, $this->type));
        return (!empty($rows)) ? count($rows) : 0;
    }

    public function totalByID($id_variant = 0, $type = '', $is_admin = false)
    {
        $where = (!empty($is_admin)) ? "" : "find_in_set('hienthi',status) and";
        $row = $this->d->rawQueryOne("select count(id) as num from #_comment where $where id_parent = 0 and id_variant = ? and type = ?", array($id_variant, $type));
        return (!empty($row)) ? $row['num'] : 0;
    }

    public function newPost($id_variant = 0, $type = '', $status = '')
    {
        $row = $this->d->rawQuery("select id_variant from #_comment where id_variant = ? and type = ? and find_in_set(?,status)", array($id_variant, $type, $status));
        return (!empty($row)) ? count($row) : 0;
    }

    public function lists($is_admin = false)
    {
        $where = (!empty($is_admin)) ? "" : "find_in_set('hienthi',status) and";
        $rows = $this->d->rawQuery("select * from #_comment where $where id_parent = 0 and id_variant = ? and type = ? order by date_posted desc limit 0,$this->limitParentShow", array($this->id_variant, $this->type));
        return $rows;
    }

    public function limitLists()
    {
        /* Request data */
        $limitFrom = (!empty($_GET['limitFrom'])) ? $this->func->sanitize($_GET['limitFrom']) : 0;
        $limitGet = (!empty($_GET['limitGet'])) ? $this->func->sanitize($_GET['limitGet']) : 0;
        $is_admin = (!empty($_GET['isAdmin'])) ? true : false;
        $this->id_variant = (!empty($_GET['idVariant'])) ? $this->func->sanitize($_GET['idVariant']) : 0;
        $this->type = (!empty($_GET['type'])) ? $this->func->sanitize($_GET['type']) : '';
        $markdownType = (!empty($is_admin)) ? 'admin' : 'customer';

        /* Get data */
        $where = (!empty($is_admin)) ? "" : "find_in_set('hienthi',status) and";
        $rows = $this->d->rawQuery("select * from #_comment where $where id_parent = 0 and id_variant = ? and type = ? order by date_posted desc limit $limitFrom,$limitGet", array($this->id_variant, $this->type));

        /* Export data */
        $result = array();
        $result['data'] = '';
        $result['total'] = $this->total($is_admin);

        if (!empty($rows)) {
            foreach ($rows as $k => $v) {
                /* Params data */
                $this->params = array();
                $this->params['id_variant'] = $this->id_variant;
                $this->params['type'] = $this->type;
                $this->params['is_admin'] = $is_admin;
                $this->params['lists'] = $v;
                $this->params['lists']['photo'] = $this->photo($v['id']);
                $this->params['lists']['video'] = $this->video($v['id']);
                $this->params['lists']['replies'] = $this->replies($v['id'], $this->id_variant, $this->type, $is_admin);

                /* Get template */
                $result['data'] .= $this->markdown($markdownType . '/lists', $this->params);
            }
        }

        echo json_encode($result);
        exit();
    }

    public function photo($id_parent = 0)
    {
        $rows = $this->d->rawQuery("select id, photo from #_comment_photo where id_parent = ?", array($id_parent));
        return $rows;
    }

    public function video($id_parent = 0)
    {
        $row = $this->d->rawQueryOne("select id, photo, video from #_comment_video where id_parent = ? limit 0,1", array($id_parent));
        return $row;
    }

    public function replies($id_parent = 0, $id_variant = 0, $type = '', $is_admin = false)
    {
        $where = (!empty($is_admin)) ? "" : "find_in_set('hienthi',status) and";
        $rows = $this->d->rawQuery("select * from #_comment where $where id_parent = ? and id_variant = ? and type = ? order by date_posted desc limit 0,$this->limitChildShow", array($id_parent, $id_variant, $type));

        return $rows;
    }

    public function limitReplies()
    {
        /* Request data */
        $limitFrom = (!empty($_GET['limitFrom'])) ? $this->func->sanitize($_GET['limitFrom']) : 0;
        $limitGet = (!empty($_GET['limitGet'])) ? $this->func->sanitize($_GET['limitGet']) : 0;
        $id_parent = (!empty($_GET['idParent'])) ? $this->func->sanitize($_GET['idParent']) : 0;
        $id_variant = (!empty($_GET['idVariant'])) ? $this->func->sanitize($_GET['idVariant']) : 0;
        $type = (!empty($_GET['type'])) ? $this->func->sanitize($_GET['type']) : '';
        $is_admin = (!empty($_GET['isAdmin'])) ? true : false;
        $markdownType = (!empty($is_admin)) ? 'admin' : 'customer';

        /* Get data */
        $where = (!empty($is_admin)) ? "" : "find_in_set('hienthi',status) and";
        $rows = $this->d->rawQuery("select * from #_comment where $where id_parent = ? and id_variant = ? and type = ? order by date_posted desc limit $limitFrom,$limitGet", array($id_parent, $id_variant, $type));

        /* Export data */
        $result = array();
        $result['data'] = '';
        $result['total'] = $this->totalReplies($id_parent, $id_variant, $type, $is_admin);

        if (!empty($rows)) {
            /* Params data */
            $this->params = array();
            $this->params['replies'] = $rows;

            /* Get template */
            $result['data'] .= $this->markdown($markdownType . '/replies', $this->params);
        }

        echo json_encode($result);
        exit();
    }

    public function totalReplies($id_parent = 0, $id_variant = 0, $type = '', $is_admin = false)
    {
        $where = (!empty($is_admin)) ? "" : "find_in_set('hienthi',status) and";
        $row = $this->d->rawQueryOne("select count(id) as num from #_comment where $where id_parent = ? and id_variant = ? and type = ? order by date_posted desc", array($id_parent, $id_variant, $type));

        return (!empty($row)) ? $row['num'] : 0;
    }

    public function perScore($num = 1)
    {
        return (!empty($this->total)) ? round(($this->star[$num] * 100) / $this->total, 1) : 0;
    }

    public function avgPoint()
    {
        return (!empty($this->total)) ? round((($this->total_star) / $this->total), 1) : 0;
    }

    public function avgStar()
    {
        return (!empty($this->total)) ? ($this->total_star * 100) / ($this->total * 5) : 0;
    }

    public function scoreStar($star = 0)
    {
        return (!empty($star)) ? ($star * 100) / 5 : 0;
    }

    public function subName($str = '')
    {
        $result = '';

        if (!empty($str)) {
            $arr = explode(' ', $str);

            if (count($arr) > 1) {
                $result = substr($arr[0], 0, 1) . substr(end($arr), 0, 1);
            } else {
                $result = substr($arr[0], 0, 1);
            }
        }

        return $result;
    }

    public function add()
    {
        global $config;

        $data = (!empty($_POST['dataReview'])) ? $_POST['dataReview'] : null;
        $dataPhoto = $this->func->listsGallery('review-file-photo');

        if (!empty($data)) {
            foreach ($data as $column => $value) {
                $data[$column] = htmlspecialchars($this->func->sanitize($value));
            }

            $data['status'] = 'new-admin';
            $data['date_posted'] = time();

            /* Valid data */
            if (isset($data['star']) && empty($data['star'])) {
                $this->errors[] = 'Chưa chọn đánh giá sao';
            }

            if (isset($data['star']) && !empty($data['star']) && !$this->func->isNumber($data['star'])) {
                $this->errors[] = 'Đánh giá sao không hợp lệ';
            }

            if (isset($data['title']) && empty($data['title'])) {
                $this->errors[] = 'Chưa nhập tiêu đề đánh giá';
            }

            if (empty($data['content']) || (!empty($data['fullname_parent']) && trim($data['content']) == $data['fullname_parent'])) {
                $this->errors[] = 'Chưa nhập nội dung đánh giá';
            } else {
                unset($data['fullname_parent']);
            }

            if (isset($data['fullname']) && empty($data['fullname'])) {
                $this->errors[] = 'Chưa nhập họ tên liên hệ';
            }

            if (isset($data['phone']) && empty($data['phone'])) {
                $this->errors[] = 'Chưa nhập số điện thoại liên hệ';
            }

            if (isset($data['phone']) && !empty($data['phone']) && !$this->func->isPhone($data['phone'])) {
                $this->errors[] = 'Số điện thoại không hợp lệ';
            }

            if (isset($data['email']) && empty($data['email'])) {
                $this->errors[] = 'Chưa nhập email liên hệ';
            }

            if (isset($data['email']) && !empty($data['email']) && !$this->func->isEmail($data['email'])) {
                $this->errors[] = 'Email không hợp lệ';
            }

            if (!empty($dataPhoto) && count($dataPhoto) > 3) {
                $this->errors[] = 'Hình ảnh không được vượt quá 3 hình';
            }

            if ($this->func->hasFile('review-file-video') && !$this->func->hasFile('review-poster-video')) {
                $this->errors[] = 'Hình đại diện video không được trống';
            }

            if (!$this->func->hasFile('review-file-video') && $this->func->hasFile('review-poster-video')) {
                $this->errors[] = 'Tập tin video không được trống';
            }

            if (!$this->func->checkExtFile('review-file-video')) {
                $this->errors[] = 'Chi cho phép tập tin video với định dạng: ' . implode(",", $config['website']['video']['extension']);
            }

            if (!$this->func->checkFile('review-file-video')) {
                $sizeVideo = $this->func->formatBytes($config['website']['video']['max-size']);
                $this->errors[] = 'Tập tin video không được vượt quá ' . $sizeVideo['numb'] . ' ' . $sizeVideo['ext'];
            }

            if (empty($this->errors)) {
                if ($this->d->insert('comment', $data)) {
                    $id_insert = $this->d->getLastInsertId();

                    /* Photo */
                    if (!empty($dataPhoto)) {
                        $myFile = $_FILES['review-file-photo'];
                        $fileCount = count($myFile["name"]);

                        for ($i = 0; $i < $fileCount; $i++) {
                            if (in_array($myFile["name"][$i], $dataPhoto, true)) {
                                $_FILES['file-uploader-temp'] = array(
                                    'name' => $myFile['name'][$i],
                                    'type' => $myFile['type'][$i],
                                    'tmp_name' => $myFile['tmp_name'][$i],
                                    'error' => $myFile['error'][$i],
                                    'size' => $myFile['size'][$i]
                                );
                                $file_name = $this->func->uploadName($myFile["name"][$i]);

                                if ($photo = $this->func->uploadImage("file-uploader-temp", '.jpg|.png|.jpeg', ROOT . UPLOAD_PHOTO_L, $file_name)) {
                                    $dataTemp = array();
                                    $dataTemp['id_parent'] = $id_insert;
                                    $dataTemp['photo'] = $photo;
                                    $this->d->insert('comment_photo', $dataTemp);
                                }
                            }
                        }
                    }

                    /* Video */
                    if ($this->func->hasFile("review-file-video")) {
                        $dataTemp = array();

                        /* Poster */
                        $file_name = $this->func->uploadName($_FILES["review-poster-video"]["name"]);

                        if ($photo = $this->func->uploadImage("review-poster-video", $config['website']['video']['poster']['extension'], ROOT . UPLOAD_PHOTO_L, $file_name)) {
                            $dataTemp['photo'] = $photo;
                        }

                        /* File */
                        $file_name = $this->func->uploadName($_FILES["review-file-video"]["name"]);

                        if ($video = $this->func->uploadImage("review-file-video", implode("|", $config['website']['video']['extension']), ROOT . UPLOAD_VIDEO_L, $file_name)) {
                            $dataTemp['video'] = $video;
                        }

                        /* Save video */
                        $dataTemp['id_parent'] = $id_insert;
                        $this->d->insert('comment_video', $dataTemp);
                    }
                }
            }
        } else {
            $this->errors[] = 'Dữ liệu không hợp lệ';
        }

        return $this->response();
    }

    public function addAdmin()
    {
        global $loginAdmin;

        $data = (!empty($_POST['dataReview'])) ? $_POST['dataReview'] : null;

        if (!empty($data)) {
            foreach ($data as $column => $value) {
                $data[$column] = htmlspecialchars($this->func->sanitize($value));
            }

            $data['fullname'] = (!empty($_SESSION[$loginAdmin]['fullname'])) ? $_SESSION[$loginAdmin]['fullname'] : '';
            $data['phone'] = (!empty($_SESSION[$loginAdmin]['phone'])) ? $_SESSION[$loginAdmin]['phone'] : '';
            $data['email'] = (!empty($_SESSION[$loginAdmin]['email'])) ? $_SESSION[$loginAdmin]['email'] : '';
            $data['status'] = 'hienthi';
            $data['date_posted'] = time();

            /* Valid data */
            if (empty($data['content']) || (!empty($data['fullname_parent']) && trim($data['content']) == $data['fullname_parent'])) {
                $this->errors[] = 'Chưa nhập nội dung đánh giá';
            } else {
                unset($data['fullname_parent']);
            }

            if (empty($this->errors)) {
                if (!$this->d->insert('comment', $data)) {
                    $this->errors[] = 'Phản hồi thất bại. Vui lòng thử lại sau';
                }
            }
        } else {
            $this->errors[] = 'Dữ liệu không hợp lệ';
        }

        return $this->response();
    }

    public function status()
    {
        /* Request data */
        $id = (!empty($_POST['id'])) ? $this->func->sanitize($_POST['id']) : 0;
        $status = (!empty($_POST['status'])) ? $this->func->sanitize($_POST['status']) : '';

        /* Get detail */
        if (!empty($id)) {
            $row = $this->d->rawQueryOne("select id, status from #_comment where id = ? limit 0,1", array($id));

            /* Check detail */
            if (!empty($row['id'])) {
                $status_array = (!empty($row['status'])) ? explode(',', $row['status']) : array();

                if (array_search($status, $status_array) !== false) {
                    $key = array_search($status, $status_array);
                    unset($status_array[$key]);
                } else {
                    array_push($status_array, $status);
                }

                /* Unset status new for admin */
                if (array_search('new-admin', $status_array) !== false) {
                    unset($status_array[array_search('new-admin', $status_array)]);
                }

                /* Update status */
                $data = array();
                $data['status'] = (!empty($status_array)) ? implode(',', $status_array) : "";
                $this->d->where('id', $id);
                if (!$this->d->update('comment', $data)) {
                    $this->errors[] = 'Cập nhật trạng thái thất bại. Vui lòng thử lại sau';
                }
            } else {
                $this->errors[] = 'Dữ liệu không hợp lệ';
            }
        } else {
            $this->errors[] = 'Dữ liệu không hợp lệ';
        }

        return $this->response();
    }

    public function delete()
    {
        /* Request data */
        $id = (!empty($_POST['id'])) ? $this->func->sanitize($_POST['id']) : 0;

        /* Get detail */
        if (!empty($id)) {
            $row = $this->d->rawQueryOne("select id, id_parent from #_comment where id = ? limit 0,1", array($id));

            /* Check detail */
            if (!empty($row['id'])) {
                if ($row['id_parent'] == 0) {
                    /* Delete photo */
                    $photo = $this->photo($row['id']);

                    if (!empty($photo)) {
                        /* Delete photo image */
                        foreach ($photo as $v) {
                            $this->func->deleteFile(ROOT . UPLOAD_PHOTO_L . $v['photo']);
                        }

                        /* Delete photo data */
                        $this->d->rawQuery("delete from #_comment_photo where id_parent = ?", array($row['id']));
                    }

                    /* Delete video */
                    $video = $this->video($row['id']);

                    if (!empty($video)) {
                        $this->func->deleteFile(ROOT . UPLOAD_PHOTO_L . $video['photo']);
                        $this->func->deleteFile(ROOT . UPLOAD_VIDEO_L . $video['video']);
                        $this->d->rawQuery("delete from #_comment_video where id_parent = ?", array($row['id']));
                    }

                    /* Delete child */
                    $result = $this->d->rawQuery("delete from #_comment where id_parent = ?", array($id));
                }

                /* Delete main */
                $result = $this->d->rawQuery("delete from #_comment where id = ?", array($id));

                if (!empty($result)) {
                    $this->errors[] = 'Xóa bình luận thất bại. Vui lòng thử lại sau';
                }
            } else {
                $this->errors[] = 'Dữ liệu không hợp lệ';
            }
        } else {
            $this->errors[] = 'Dữ liệu không hợp lệ';
        }

        return $this->response();
    }

    public function markdown($path = '', $params = array())
    {
        $content = '';

        if (!empty($path)) {
            ob_start();
            include dirname(__DIR__) . "/sample/comment/" . $path . ".php";
            $content = ob_get_contents();
            ob_clean();
        }

        return $content;
    }

    public function timeAgo($time = 0)
    {
        $result = '';
        $lang = [
            'now' => 'Vài giây trước',
            'ago' => 'trước',
            'vi' => [
                'y' => 'năm',
                'm' => 'tháng',
                'd' => 'ngày',
                'h' => 'giờ',
                'm' => 'phút',
                's' => 'giây'
            ]
        ];

        $ago = time() - $time;

        if ($ago < 1) {
            $result = $lang['now'];
        } else {
            $unit = [
                365 * 24 * 60 * 60  =>  'y',
                30 * 24 * 60 * 60  =>  'm',
                24 * 60 * 60  =>  'd',
                60 * 60  =>  'h',
                60  =>  'm',
                1  =>  's'
            ];

            foreach ($unit as $secs => $key) {
                $time = $ago / $secs;

                if ($time >= 1) {
                    $time = round($time);
                    $result = $time . ' ' . ($time > 1 ? $lang['vi'][$key] : $lang['vi'][$key]) . ' ' . $lang['ago'];
                    break;
                }
            }
        }

        return $result;
    }
}
