<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active news */
if (isset($config['news'])) {
    $arrCheck = array();
    foreach ($config['news'] as $k => $v) $arrCheck[] = $k;
    if (!count($arrCheck) || !in_array($type, $arrCheck)) $func->transfer("Trang không tồn tại", "index.php", false);
} else {
    $func->transfer("Trang không tồn tại", "index.php", false);
}

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$arrUrl = array('id_list', 'id_cat', 'id_item', 'id_sub', 'id_brand');
if (isset($_POST['data'])) {
    $dataUrl = isset($_POST['data']) ? $_POST['data'] : null;
    if ($dataUrl) {
        foreach ($arrUrl as $k => $v) {
            if (isset($dataUrl[$arrUrl[$k]])) $strUrl .= "&" . $arrUrl[$k] . "=" . htmlspecialchars($dataUrl[$arrUrl[$k]]);
        }
    }
} else {
    foreach ($arrUrl as $k => $v) {
        if (isset($_REQUEST[$arrUrl[$k]])) $strUrl .= "&" . $arrUrl[$k] . "=" . htmlspecialchars($_REQUEST[$arrUrl[$k]]);
    }

    if (!empty($_REQUEST['comment_status'])) $strUrl .= "&comment_status=" . htmlspecialchars($_REQUEST['comment_status']);
    if (isset($_REQUEST['keyword'])) $strUrl .= "&keyword=" . htmlspecialchars($_REQUEST['keyword']);
}

switch ($act) {
        /* Man */
    case "man":
        viewMans();
        $template = "news/man/mans";
        break;
    case "add":
        $template = "news/man/man_add";
        break;
    case "edit":
    case "copy":
        if ((!isset($config['news'][$type]['copy']) || $config['news'][$type]['copy'] == false) && $act == 'copy') {
            $template = "404";
            return false;
        }
        editMan();
        $template = "news/man/man_add";
        break;
    case "save":
    case "save_copy":
        saveMan();
        break;
    case "delete":
        deleteMan();
        break;

        /* List */
    case "man_list":
        viewLists();
        $template = "news/list/lists";
        break;
    case "add_list":
        $template = "news/list/list_add";
        break;
    case "edit_list":
        editList();
        $template = "news/list/list_add";
        break;
    case "save_list":
        saveList();
        break;
    case "delete_list":
        deleteList();
        break;

        /* Cat */
    case "man_cat":
        viewCats();
        $template = "news/cat/cats";
        break;
    case "add_cat":
        $template = "news/cat/cat_add";
        break;
    case "edit_cat":
        editCat();
        $template = "news/cat/cat_add";
        break;
    case "save_cat":
        saveCat();
        break;
    case "delete_cat":
        deleteCat();
        break;

        /* Item */
    case "man_item":
        viewItems();
        $template = "news/item/items";
        break;
    case "add_item":
        $template = "news/item/item_add";
        break;
    case "edit_item":
        editItem();
        $template = "news/item/item_add";
        break;
    case "save_item":
        saveItem();
        break;
    case "delete_item":
        deleteItem();
        break;

        /* Sub */
    case "man_sub":
        viewSubs();
        $template = "news/sub/subs";
        break;
    case "add_sub":
        $template = "news/sub/sub_add";
        break;
    case "edit_sub":
        editSub();
        $template = "news/sub/sub_add";
        break;
    case "save_sub":
        saveSub();
        break;
    case "delete_sub":
        deleteSub();
        break;

        /* Gallery */
    case "man_photo":
    case "add_photo":
    case "edit_photo":
    case "save_photo":
    case "delete_photo":
        include "gallery.php";
        break;

    default:
        $template = "404";
}

/* View man */
function viewMans()
{
    global $d, $func, $comment, $strUrl, $curPage, $items, $paging, $type;

    $where = "";
    $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
    $idcat = (isset($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
    $iditem = (isset($_REQUEST['id_item'])) ? htmlspecialchars($_REQUEST['id_item']) : 0;
    $idsub = (isset($_REQUEST['id_sub'])) ? htmlspecialchars($_REQUEST['id_sub']) : 0;
    $comment_status = (!empty($_REQUEST['comment_status'])) ? htmlspecialchars($_REQUEST['comment_status']) : '';

    if ($idlist) $where .= " and id_list=$idlist";
    if ($idcat) $where .= " and id_cat=$idcat";
    if ($iditem) $where .= " and id_item=$iditem";
    if ($idsub) $where .= " and id_sub=$idsub";
    if ($comment_status == 'new') {
        $comment = $d->rawQuery("select distinct id_variant from #_comment where type = ? and find_in_set('new-admin',status)", array($type));
        $idcomment = (!empty($comment)) ? $func->joinCols($comment, 'id_variant') : 0;
        $where .= " and id in ($idcomment)";
    }
    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_news where type = ? $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($type));
    $sqlNum = "select count(*) as 'num' from #_news where type = ? $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=news&act=man" . $strUrl . "&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);

    /* Comment */
    $comment = new Comments($d, $func);
}

/* Edit man */
function editMan()
{
    global $d, $strUrl, $func, $curPage, $item, $gallery, $type, $com, $act;

    if (!empty($_GET['id'])) $id = htmlspecialchars($_GET['id']);
    else if (!empty($_GET['id_copy'])) $id = htmlspecialchars($_GET['id_copy']);
    else $id = 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from #_news where id = ? and type = ? limit 0,1", array($id, $type));

        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
        } else {
            /* Get gallery */
            if ($act != 'copy') {
                $gallery = $d->rawQuery("select * from #_gallery where id_parent = ? and com = ? and type = ? and kind = ? and val = ? order by numb,id desc", array($id, $com, $type, 'man', $type));
            }
        }
    }
}

/* Save man */
function saveMan()
{
    global $d, $strUrl, $func, $flash, $curPage, $config, $com, $act, $type, $setting, $configBase;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
    }
    $id_opt = (isset($id)) ? htmlspecialchars($id) : 0;
    $row_opt = $d->rawQueryOne("select id, options from #_news where id = ? and type = ? limit 0,1",array($id_opt, $type));
    $option = json_decode($row_opt['options'],true);

    $row_opt2 = $d->rawQueryOne("select id, options2 from #_news where id = ? and type = ? limit 0,1",array($id_opt, $type));
    $option2 = json_decode($row_opt2['options2'],true);

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $savehere = (isset($_POST['save-here'])) ? true : false;
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = !empty($_POST['data']) ? $_POST['data'] : null;
    $dataTags = (!empty($_POST['dataTags'])) ? $_POST['dataTags'] : null;
    $buildSchema = (isset($_POST['build-schema'])) ? true : false;

    if ($data) {
        foreach ($data as $column => $value) {
            if(is_array($value))
            {
                foreach($value as $k2 => $v2) $option[$k2] = $v2;
                $data[$column] = json_encode($option);

                foreach($value as $k2 => $v2) $option2[$k2] = $v2;
                $data[$column] = json_encode($option2);
            }
            else
            {
                if (strpos($column, 'content') !== false || strpos($column, 'desc') !== false) {
                    $data[$column] = htmlspecialchars($func->sanitize($value, 'iframe'));
                } else {
                    $data[$column] = htmlspecialchars($func->sanitize($value));
                }
            }
        }

        if (!empty($config['news'][$type]['slug'])) {
            if (!empty($_POST['slugvi'])) $data['slugvi'] = $func->changeTitle(htmlspecialchars($_POST['slugvi']));
            else $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
            if (!empty($_POST['slugen'])) $data['slugen'] = $func->changeTitle(htmlspecialchars($_POST['slugen']));
            else $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
        }

        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }

        $data['type'] = $type;
    }

    /* Post seo */
    if (isset($config['news'][$type]['seo']) && $config['news'][$type]['seo'] == true) {
        $dataSeo = (isset($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;
        if ($dataSeo) {
            foreach ($dataSeo as $column => $value) {
                $dataSeo[$column] = htmlspecialchars($func->sanitize($value));
            }
        }
    }

    /* Valid data */
    $checkTitle = $func->checkTitle($data);

    if (!empty($checkTitle)) {
        foreach ($checkTitle as $k => $v) {
            $response['messages'][] = $v;
        }
    }

    if (!empty($config['news'][$type]['slug'])) {
        foreach ($config['website']['slug'] as $k => $v) {
            $dataSlug = array();
            $dataSlug['slug'] = $data['slug' . $k];
            $dataSlug['id'] = $id;
            $dataSlug['copy'] = ($act == 'save_copy') ? true : false;
            $checkSlug = $func->checkSlug($dataSlug);

            if ($checkSlug == 'exist') {
                $response['messages'][] = 'Đường dẫn (' . $v . ') đã tồn tại';
            } else if ($checkSlug == 'empty') {
                $response['messages'][] = 'Đường dẫn (' . $v . ') không được trống';
            }
        }
    }

    if (!empty($response)) {
        /* Flash data */
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        if (!empty($dataSeo)) {
            foreach ($dataSeo as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);

        if ($id || $act == 'save_copy') {
            if ($act == 'save_copy') {
                $func->redirect("index.php?com=news&act=copy&type=" . $type . "&p=" . $curPage . $strUrl . "&id_copy=" . $id);
            } else {
                $func->redirect("index.php?com=news&act=edit&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id);
            }
        } else {
            $func->redirect("index.php?com=news&act=add&type=" . $type . "&p=" . $curPage . $strUrl);
        }
    }

    /* Save data */
    if ($id && $act != 'save_copy') {
        $data['date_updated'] = time();

        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('news', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['news'][$type]['img_type'], UPLOAD_NEWS, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_news where id = ? and type = ? limit 0,1", array($id, $type));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_NEWS . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('news', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 2*/
            if ($func->hasFile("file2")) {
                $photoUpdate2 = array();
                $file_name2 = $func->uploadName($_FILES["file2"]["name"]);

                if ($photo2 = $func->uploadImage("file2", $config['news'][$type]['img_type'], UPLOAD_NEWS, $file_name2)) {
                    $row2 = $d->rawQueryOne("select id, photo2 from #_news where id = ? and type = ? limit 0,1", array($id, $type));
                    if (!empty($row2)) {
                        $func->deleteFile(UPLOAD_NEWS . $row2['photo']);
                    }
                    $photoUpdate2['photo2'] = $photo2;
                    $d->where('id', $id);
                    $d->update('news', $photoUpdate2);
                    unset($photoUpdate2);
                }
            }

            /* File */
            if ($func->hasFile("file_attach")) {
                $fileUpdate = array();
                
                $file_name3 = $func->uploadName($_FILES["file_attach"]["name"]);
                
                if ($file_attach = $func->uploadImage("file_attach", $config['news'][$type]['file_type'], UPLOAD_FILE, $file_name3)) {
                    $row = $d->rawQueryOne("select id, file_attach from #_news where type = ? limit 0,1", array($type));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_FILE . $row['file_attach']);
                    }

                    $fileUpdate['file_attach'] = $file_attach;
                    $d->where('id', $id);
                    $d->update('news', $fileUpdate);
                    unset($fileUpdate);
                }
            } 

            /* Video mp4 */
            if ($func->hasFile("videomp4")) {
                $videomp4Update = array();
                $file_name_video = $func->uploadName($_FILES["videomp4"]["name"]);
                if ($videomp4 = $func->uploadImage("videomp4", $config['news'][$type]['videomp4_type'], UPLOAD_VIDEO, $file_name_video))
                {
                    
                    $rowvid = $d->rawQueryOne("select id, videomp4 from #_news where id = ? and type = ? limit 0,1", array($id,$type));
                    
                    if (!empty($rowvid)) {
                        $func->deleteFile(UPLOAD_VIDEO . $rowvid['videomp4']);
                    }
                    
                    $videomp4Update['videomp4'] = $videomp4;
                    $d->where('id', $id);
                    $d->update('news', $videomp4Update);
                    unset($videomp4Update);
                }
            }

            /* SEO */
            if (isset($config['news'][$type]['seo']) && $config['news'][$type]['seo'] == true) {
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man', $type));

                $dataSeo['id_parent'] = $id;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }

            /* Schema */
            if (isset($config['news'][$type]['schema']) && $config['news'][$type]['schema'] == true) {
                if ($buildSchema) {
                    foreach ($config['website']['seo'] as $k => $v) {
                        if ($k == 'vi' || $k == 'en') {
                            $url_news = $configBase . $data['slug' . $k];
                        } else {
                            $url_news = $configBase . $data['slugvi'];
                        }
                        $detail_news = $d->rawQueryOne("select photo,date_created from #_news where id = ? and type = ? limit 0,1", array($id, $type));
                        $logo = $d->rawQueryOne("select photo from #_photo where type = ? and act = ? limit 0,1", array('logo', 'photo_static'));
                        if (@$data['photo'] != '') {
                            $url_img_news = $configBase . UPLOAD_NEWS_L . $data['photo'];
                        } else {
                            $url_img_news = $configBase . UPLOAD_NEWS_L . $detail_news['photo'];
                        }
                        $dataSchema['schema' . $k] = $func->buildSchemaArticle($id, $data['name' . $k], $url_img_news, $detail_news['date_created'], $data['date_updated'], $setting['name' . $k], $url_news, $configBase . UPLOAD_PHOTO_L . @$logo['photo'], $configBase);
                    }
                } else {
                    $dataSchema = (isset($_POST['dataSchema'])) ? $_POST['dataSchema'] : null;
                    if ($dataSchema) {
                        foreach ($dataSchema as $column => $value) {
                            $dataSchema[$column] = htmlspecialchars($value);
                        }
                    }
                }
                $d->where('id_parent', $id);
                $d->where('com', $com);
                $d->where('act', 'man');
                $d->where('type', $type);
                $d->update('seo', $dataSchema);
            }

            /* Tags */
            if (isset($config['news'][$type]['tags']) && $config['news'][$type]['tags'] == true) {
                if ($dataTags) {
                    $d->rawQuery("delete from #_news_tags where id_parent = ?", array($id));
                    foreach ($dataTags as $v) {
                        $dataTag = array();
                        $dataTag['id_parent'] = $id;
                        $dataTag['id_tags'] = $v;
                        $d->insert('news_tags', $dataTag);
                    }
                } else {
                    $d->rawQuery("delete from #_news_tags where id_parent = ?", array($id));
                }
            }

            if ($savehere) {
                $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=news&act=edit&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id);
            } else {
                $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl);
            }
        } else {
            if ($savehere) {
                $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=news&act=edit&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id, false);
            } else {
                $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
            }
        }
    } else {
        $data['date_created'] = time();
        /*lay stt*/
        /*$sott = $d->rawQuery("select numb from #_news where type = ? order by numb desc ",array($type));
        $sottmoi = $sott[0]['numb']+1;*/
        if ($d->insert('news', $data)) {
            $id_insert = $d->getLastInsertId();
            /*update stt*/
            //$d->rawQuery("update #_news set numb = ? where id = ".$id_insert,array($sottmoi));
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);
                
                if ($photo = $func->uploadImage("file", $config['news'][$type]['img_type'], UPLOAD_NEWS, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('news', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 2*/
            if ($func->hasFile("file2")) {
                $photoUpdate2 = array();
                $file_name2 = $func->uploadName($_FILES['file2']["name"]);

                if ($photo = $func->uploadImage("file2", $config['news'][$type]['img_type'], UPLOAD_NEWS, $file_name2)) {
                    $photoUpdate2['photo2'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('news', $photoUpdate2);
                    unset($photoUpdate2);
                }
            }

            /* File */
            if ($func->hasFile("file_attach")) {
                $fileUpdate = array();
                
                $file_name3 = $func->uploadName($_FILES["file_attach"]["name"]);
                
                if ($file_attach = $func->uploadImage("file_attach", $config['news'][$type]['file_type'], UPLOAD_FILE, $file_name3)) {
                    $row = $d->rawQueryOne("select id, file_attach from #_news where type = ? limit 0,1", array($type));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_FILE . $row['file_attach']);
                    }

                    $fileUpdate['file_attach'] = $file_attach;
                    $d->where('id', $id_insert);
                    $d->update('news', $fileUpdate);
                    unset($fileUpdate);
                }
            }

            /* Video Mp4 */
            if ($func->hasFile("videomp4")) {
                $videomp4Update = array();
                $file_name_video = $func->uploadName($_FILES["videomp4"]["name"]);

                if ($videomp4 = $func->uploadImage("videomp4", $config['news'][$type]['videomp4_type'], UPLOAD_VIDEO, $file_name_video)) {
                    $videomp4Update['videomp4'] = $videomp4;
                    $d->where('id', $id_insert);
                    $d->update('news', $videomp4Update);
                    unset($videomp4Update);
                }
            }

            /* SEO */
            if (isset($config['news'][$type]['seo']) && $config['news'][$type]['seo'] == true) {
                $dataSeo['id_parent'] = $id_insert;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }

            /* Schema */
            if (isset($config['news'][$type]['schema']) && $config['news'][$type]['schema'] == true) {
                if ($buildSchema) {
                    foreach ($config['website']['seo'] as $k => $v) {
                        if ($k == 'vi' || $k == 'en') {
                            $url_news = $configBase . $data['slug' . $k];
                        } else {
                            $url_news = $configBase . $data['slugvi'];
                        }
                        $logo = $d->rawQueryOne("select photo from #_photo where type = ? and act = ? limit 0,1", array('logo', 'photo_static'));
                        $dataSchema['schema' . $k] = $func->buildSchemaArticle($id_insert, $data['name' . $k], $configBase . UPLOAD_NEWS_L . @$photo, $data['date_created'], $data['date_created'], $setting['name' . $k], $url_news, $configBase . UPLOAD_PHOTO_L . @$logo['photo'], $configBase);
                    }
                } else {
                    $dataSchema = (isset($_POST['dataSchema'])) ? $_POST['dataSchema'] : null;
                    if ($dataSchema) {
                        foreach ($dataSchema as $column => $value) {
                            $dataSchema[$column] = htmlspecialchars($value);
                        }
                    }
                }
                $d->where('id_parent', $id_insert);
                $d->where('com', $com);
                $d->where('act', 'man');
                $d->where('type', $type);
                $d->update('seo', $dataSchema);
            }

            /* Tags */
            if (isset($config['news'][$type]['tags']) && $config['news'][$type]['tags'] == true) {
                if ($dataTags) {
                    foreach ($dataTags as $v) {
                        $dataTag = array();
                        $dataTag['id_parent'] = $id_insert;
                        $dataTag['id_tags'] = $v;
                        $d->insert('news_tags', $dataTag);
                    }
                }
            }

            /* Cập nhật hash khi upload multi */
            $hash = (isset($_POST['hash']) && $_POST['hash'] != '') ? addslashes($_POST['hash']) : null;
            if ($hash) {
                $d->rawQuery("update #_gallery set hash = ?, id_parent = ? where hash = ?", array('', $id_insert, $hash));
            }

            if ($act == 'save_copy') {
                if ($savehere) {
                    $func->transfer("Sao chép dữ liệu thành công", "index.php?com=news&act=edit&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id_insert);
                } else {
                    $func->transfer("Sao chép dữ liệu thành công", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl);
                }
            } else {
                if ($savehere) {
                    $func->transfer("Lưu dữ liệu thành công", "index.php?com=news&act=edit&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id_insert);
                } else {
                    $func->transfer("Lưu dữ liệu thành công", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl);
                }
            }
        } else {
            if ($act == 'save_copy') {
                $func->transfer("Sao chép dữ liệu bị lỗi", "index.php?com=news&act=copy&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id, false);
            } else {
                $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=news&act=copy&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id, false);
            }
        }
    }
}

/* Delete man */
function deleteMan()
{
    global $d, $strUrl, $func, $curPage, $com, $type;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from #_news where id = ? and type = ? limit 0,1", array($id, $type));

        if (!empty($row)) {
            /* Xóa chính */
            $func->deleteFile(UPLOAD_NEWS . $row['photo']);
            $d->rawQuery("delete from #_news where id = ?", array($id));

            /* Xóa SEO */
            $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man', $type));

            /* Xóa Tags */
            $d->rawQuery("delete from #_news_tags where id_parent = ?", array($id));

            /* Xóa gallery */
            $row = $d->rawQuery("select id, photo, file_attach from #_gallery where id_parent = ? and kind = ? and com = ?", array($id, 'man', $com));

            if (count($row)) {
                foreach ($row as $v) {
                    $func->deleteFile(UPLOAD_NEWS . $v['photo']);
                    $func->deleteFile(UPLOAD_FILE . $v['file_attach']);
                }

                $d->rawQuery("delete from #_gallery where id_parent = ? and kind = ? and com = ?", array($id, 'man', $com));
            }

            /* Xóa comment */
            $rowComment = $d->rawQuery("select id, id_parent from #_comment where id_variant = ? and type = ?", array($id, $type));

            if (!empty($rowComment)) {
                foreach ($rowComment as $v) {
                    if ($v['id_parent'] == 0) {
                        /* Xóa comment photo */
                        $rowCommentPhoto = $d->rawQuery("select photo from #_comment_photo where id_parent = ?", array($v['id']));

                        if (!empty($rowCommentPhoto)) {
                            /* Xóa image */
                            foreach ($rowCommentPhoto as $v_photo) {
                                $func->deleteFile(UPLOAD_PHOTO . $v_photo['photo']);
                            }

                            /* Xóa photo */
                            $d->rawQuery("delete from #_comment_photo where id_parent = ?", array($v['id']));
                        }

                        /* Xóa comment video */
                        $rowCommentVideo = $d->rawQueryOne("select photo, video from #_comment_video where id_parent = ? limit 0,1", array($v['id']));

                        if (!empty($rowCommentVideo)) {
                            $func->deleteFile(UPLOAD_PHOTO . $rowCommentVideo['photo']);
                            $func->deleteFile(UPLOAD_VIDEO . $rowCommentVideo['video']);
                            $d->rawQuery("delete from #_comment_video where id_parent = ?", array($v['id']));
                        }

                        /* Xóa child */
                        $d->rawQuery("delete from #_comment where id_parent = ? and type = ?", array($v['id'], $type));
                    }

                    /* Xóa comment main */
                    $d->rawQuery("delete from #_comment where id = ? and type = ?", array($v['id'], $type));
                }
            }

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);

            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from #_news where id = ? and type = ? limit 0,1", array($id, $type));

            if (!empty($row)) {
                /* Xóa chính */
                $func->deleteFile(UPLOAD_NEWS . $row['photo']);
                $d->rawQuery("delete from #_news where id = ?", array($id));

                /* Xóa SEO */
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man', $type));

                /* Xóa Tags */
                $d->rawQuery("delete from #_news_tags where id_parent = ?", array($id));

                /* Xóa gallery */
                $row = $d->rawQuery("select id, photo, file_attach from #_gallery where id_parent = ? and kind = ? and com = ?", array($id, 'man', $com));

                if (count($row)) {
                    foreach ($row as $v) {
                        $func->deleteFile(UPLOAD_NEWS . $v['photo']);
                        $func->deleteFile(UPLOAD_FILE . $v['file_attach']);
                    }

                    $d->rawQuery("delete from #_gallery where id_parent = ? and kind = ? and com = ?", array($id, 'man', $com));
                }

                /* Xóa comment */
                $rowComment = $d->rawQuery("select id, id_parent from #_comment where id_variant = ? and type = ?", array($id, $type));

                if (!empty($rowComment)) {
                    foreach ($rowComment as $v) {
                        if ($v['id_parent'] == 0) {
                            /* Xóa comment photo */
                            $rowCommentPhoto = $d->rawQuery("select photo from #_comment_photo where id_parent = ?", array($v['id']));

                            if (!empty($rowCommentPhoto)) {
                                /* Xóa image */
                                foreach ($rowCommentPhoto as $v_photo) {
                                    $func->deleteFile(UPLOAD_PHOTO . $v_photo['photo']);
                                }

                                /* Xóa photo */
                                $d->rawQuery("delete from #_comment_photo where id_parent = ?", array($v['id']));
                            }

                            /* Xóa comment video */
                            $rowCommentVideo = $d->rawQueryOne("select photo, video from #_comment_video where id_parent = ? limit 0,1", array($v['id']));

                            if (!empty($rowCommentVideo)) {
                                $func->deleteFile(UPLOAD_PHOTO . $rowCommentVideo['photo']);
                                $func->deleteFile(UPLOAD_VIDEO . $rowCommentVideo['video']);
                                $d->rawQuery("delete from #_comment_video where id_parent = ?", array($v['id']));
                            }

                            /* Xóa child */
                            $d->rawQuery("delete from #_comment where id_parent = ? and type = ?", array($v['id'], $type));
                        }

                        /* Xóa comment main */
                        $d->rawQuery("delete from #_comment where id = ? and type = ?", array($v['id'], $type));
                    }
                }
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
    }
}

/* View list */
function viewLists()
{
    global $d, $func, $strUrl, $curPage, $items, $paging, $type;

    $where = "";

    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_news_list where type = ? $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($type));
    $sqlNum = "select count(*) as 'num' from #_news_list where type = ? $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=news&act=man_list&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit list */
function editList()
{
    global $d, $strUrl, $func, $curPage, $item, $gallery, $type, $com;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from #_news_list where id = ? and type = ? limit 0,1", array($id, $type));

        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=news&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl, false);
        } else {
            /* Get gallery */
            $gallery = $d->rawQuery("select * from #_gallery where id_parent = ? and com = ? and type = ? and kind = ? and val = ? order by numb,id desc", array($id, $com, $type, 'man_list', $type));
        }
    }
}

/* Save list */
function saveList()
{
    global $d, $strUrl, $func, $flash, $curPage, $config, $com, $type;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            if (strpos($column, 'content') !== false || strpos($column, 'desc') !== false) {
                $data[$column] = htmlspecialchars($func->sanitize($value, 'iframe'));
            } else {
                $data[$column] = htmlspecialchars($func->sanitize($value));
            }
        }

        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }

        if (!empty($config['news'][$type]['slug_list'])) {
            if (!empty($_POST['slugvi'])) $data['slugvi'] = $func->changeTitle(htmlspecialchars($_POST['slugvi']));
            else $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
            if (!empty($_POST['slugen'])) $data['slugen'] = $func->changeTitle(htmlspecialchars($_POST['slugen']));
            else $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
        }

        $data['type'] = $type;
    }

    /* Post seo */
    if (isset($config['news'][$type]['seo_list']) && $config['news'][$type]['seo_list'] == true) {
        $dataSeo = (isset($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;
        if ($dataSeo) {
            foreach ($dataSeo as $column => $value) {
                $dataSeo[$column] = htmlspecialchars($func->sanitize($value));
            }
        }
    }

    /* Valid data */
    $checkTitle = $func->checkTitle($data);

    if (!empty($checkTitle)) {
        foreach ($checkTitle as $k => $v) {
            $response['messages'][] = $v;
        }
    }

    if (!empty($config['news'][$type]['slug_list'])) {
        foreach ($config['website']['slug'] as $k => $v) {
            $dataSlug = array();
            $dataSlug['slug'] = $data['slug' . $k];
            $dataSlug['id'] = $id;
            $dataSlug['copy'] = false;
            $checkSlug = $func->checkSlug($dataSlug);

            if ($checkSlug == 'exist') {
                $response['messages'][] = 'Đường dẫn (' . $v . ') đã tồn tại';
            } else if ($checkSlug == 'empty') {
                $response['messages'][] = 'Đường dẫn (' . $v . ') không được trống';
            }
        }
    }

    if (!empty($response)) {
        /* Flash data */
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        if (!empty($dataSeo)) {
            foreach ($dataSeo as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);

        if ($id) {
            $func->redirect("index.php?com=news&act=edit_list&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=news&act=add_list&type=" . $type . "&p=" . $curPage . $strUrl);
        }
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('news_list', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['news'][$type]['img_type_list'], UPLOAD_NEWS, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_news_list where id = ? and type = ? limit 0,1", array($id, $type));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_NEWS . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('news_list', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* SEO */
            if (isset($config['news'][$type]['seo_list']) && $config['news'][$type]['seo_list'] == true) {
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_list', $type));

                $dataSeo['id_parent'] = $id;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man_list';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=news&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=news&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    } else {
        $data['date_created'] = time();

        if ($d->insert('news_list', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo = $func->uploadImage("file", $config['news'][$type]['img_type_list'], UPLOAD_NEWS, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('news_list', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* SEO */
            if (isset($config['news'][$type]['seo_list']) && $config['news'][$type]['seo_list'] == true) {
                $dataSeo['id_parent'] = $id_insert;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man_list';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }

            /* Cập nhật hash khi upload multi */
            $hash = (isset($_POST['hash']) && $_POST['hash'] != '') ? addslashes($_POST['hash']) : null;
            if ($hash) {
                $d->rawQuery("update #_gallery set hash = ?, id_parent = ? where hash = ?", array('', $id_insert, $hash));
            }

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=news&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=news&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Delete list */
function deleteList()
{
    global $d, $strUrl, $func, $curPage, $com, $type;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from #_news_list where id = ? and type = ? limit 0,1", array($id, $type));

        if (!empty($row)) {
            /* Xóa chính */
            $func->deleteFile(UPLOAD_NEWS . $row['photo']);
            $d->rawQuery("delete from #_news_list where id = ?", array($id));

            /* Xóa SEO */
            $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_list', $type));

            /* Xóa gallery */
            $row = $d->rawQuery("select id, photo, file_attach from #_gallery where id_parent = ? and kind = ? and com = ?", array($id, 'man_list', $com));

            if (count($row)) {
                foreach ($row as $v) {
                    $func->deleteFile(UPLOAD_NEWS . $v['photo']);
                    $func->deleteFile(UPLOAD_FILE . $v['file_attach']);
                }

                $d->rawQuery("delete from #_gallery where id_parent = ? and kind = ? and com = ?", array($id, 'man_list', $com));
            }

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=news&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);

            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from #_news_list where id = ? and type = ? limit 0,1", array($id, $type));

            if (!empty($row)) {
                /* Xóa chính */
                $func->deleteFile(UPLOAD_NEWS . $row['photo']);
                $d->rawQuery("delete from #_news_list where id = ?", array($id));

                /* Xóa SEO */
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_list', $type));

                /* Xóa gallery */
                $row = $d->rawQuery("select id, photo, file_attach from #_gallery where id_parent = ? and kind = ? and com = ?", array($id, 'man_list', $com));

                if (count($row)) {
                    foreach ($row as $v) {
                        $func->deleteFile(UPLOAD_NEWS . $v['photo']);
                        $func->deleteFile(UPLOAD_FILE . $v['file_attach']);
                    }

                    $d->rawQuery("delete from #_gallery where id_parent = ? and kind = ? and com = ?", array($id, 'man_list', $com));
                }
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl, false);
    }
}

/* View cat */
function viewCats()
{
    global $d, $func, $strUrl, $curPage, $items, $paging, $type;

    $where = "";
    $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;

    if ($idlist) $where .= " and id_list=$idlist";
    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_news_cat where type = ? $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($type));
    $sqlNum = "select count(*) as 'num' from #_news_cat where type = ? $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=news&act=man_cat" . $strUrl . "&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit cat */
function editCat()
{
    global $d, $strUrl, $func, $curPage, $item, $type;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from #_news_cat where id = ? and type = ? limit 0,1", array($id, $type));

        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=news&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Save cat */
function saveCat()
{
    global $d, $strUrl, $func, $flash, $curPage, $config, $com, $type;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            if (strpos($column, 'content') !== false || strpos($column, 'desc') !== false) {
                $data[$column] = htmlspecialchars($func->sanitize($value, 'iframe'));
            } else {
                $data[$column] = htmlspecialchars($func->sanitize($value));
            }
        }

        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }

        if (!empty($config['news'][$type]['slug_cat'])) {
            if (!empty($_POST['slugvi'])) $data['slugvi'] = $func->changeTitle(htmlspecialchars($_POST['slugvi']));
            else $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
            if (!empty($_POST['slugen'])) $data['slugen'] = $func->changeTitle(htmlspecialchars($_POST['slugen']));
            else $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
        }

        $data['type'] = $type;
    }

    /* Post seo */
    if (isset($config['news'][$type]['seo_cat']) && $config['news'][$type]['seo_cat'] == true) {
        $dataSeo = (isset($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;
        if ($dataSeo) {
            foreach ($dataSeo as $column => $value) {
                $dataSeo[$column] = htmlspecialchars($func->sanitize($value));
            }
        }
    }

    /* Valid data */
    $checkTitle = $func->checkTitle($data);

    if (!empty($checkTitle)) {
        foreach ($checkTitle as $k => $v) {
            $response['messages'][] = $v;
        }
    }

    if (!empty($config['news'][$type]['slug_cat'])) {
        foreach ($config['website']['slug'] as $k => $v) {
            $dataSlug = array();
            $dataSlug['slug'] = $data['slug' . $k];
            $dataSlug['id'] = $id;
            $dataSlug['copy'] = false;
            $checkSlug = $func->checkSlug($dataSlug);

            if ($checkSlug == 'exist') {
                $response['messages'][] = 'Đường dẫn (' . $v . ') đã tồn tại';
            } else if ($checkSlug == 'empty') {
                $response['messages'][] = 'Đường dẫn (' . $v . ') không được trống';
            }
        }
    }

    if (!empty($response)) {
        /* Flash data */
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        if (!empty($dataSeo)) {
            foreach ($dataSeo as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);

        if ($id) {
            $func->redirect("index.php?com=news&act=edit_cat&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=news&act=add_cat&type=" . $type . "&p=" . $curPage . $strUrl);
        }
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('news_cat', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['news'][$type]['img_type_cat'], UPLOAD_NEWS, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_news_cat where id = ? and type = ? limit 0,1", array($id, $type));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_NEWS . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('news_cat', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* SEO */
            if (isset($config['news'][$type]['seo_cat']) && $config['news'][$type]['seo_cat'] == true) {
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_cat', $type));

                $dataSeo['id_parent'] = $id;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man_cat';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=news&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=news&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    } else {
        $data['date_created'] = time();

        if ($d->insert('news_cat', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo = $func->uploadImage("file", $config['news'][$type]['img_type_cat'], UPLOAD_NEWS, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('news_cat', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* SEO */
            if (isset($config['news'][$type]['seo_cat']) && $config['news'][$type]['seo_cat'] == true) {
                $dataSeo['id_parent'] = $id_insert;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man_cat';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }
            $func->transfer("Lưu dữ liệu thành công", "index.php?com=news&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=news&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Delete cat */
function deleteCat()
{
    global $d, $strUrl, $func, $curPage, $com, $type;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from #_news_cat where id = ? and type = ? limit 0,1", array($id, $type));

        if (!empty($row)) {
            /* Xóa chính */
            $func->deleteFile(UPLOAD_NEWS . $row['photo']);
            $d->rawQuery("delete from #_news_cat where id = ?", array($id));

            /* Xóa SEO */
            $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_cat', $type));

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=news&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);

            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from #_news_cat where id = ? and type = ? limit 0,1", array($id, $type));

            if (!empty($row)) {
                /* Xóa chính */
                $func->deleteFile(UPLOAD_NEWS . $row['photo']);
                $d->rawQuery("delete from #_news_cat where id = ?", array($id));

                /* Xóa SEO */
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_cat', $type));
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl, false);
    }
}

/* View item */
function viewItems()
{
    global $d, $func, $strUrl, $curPage, $items, $paging, $type;

    $where = "";
    $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
    $idcat = (isset($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;

    if ($idlist) $where .= " and id_list=$idlist";
    if ($idcat) $where .= " and id_cat=$idcat";
    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_news_item where type = ? $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($type));
    $sqlNum = "select count(*) as 'num' from #_news_item where type = ? $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=news&act=man_item" . $strUrl . "&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit item */
function editItem()
{
    global $d, $strUrl, $func, $curPage, $item, $type;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from #_news_item where id = ? and type = ? limit 0,1", array($id, $type));

        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=news&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Save item */
function saveItem()
{
    global $d, $strUrl, $func, $flash, $curPage, $config, $com, $type;

    /* check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            if (strpos($column, 'content') !== false || strpos($column, 'desc') !== false) {
                $data[$column] = htmlspecialchars($func->sanitize($value, 'iframe'));
            } else {
                $data[$column] = htmlspecialchars($func->sanitize($value));
            }
        }

        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }

        if (!empty($config['news'][$type]['slug_item'])) {
            if (!empty($_POST['slugvi'])) $data['slugvi'] = $func->changeTitle(htmlspecialchars($_POST['slugvi']));
            else $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
            if (!empty($_POST['slugen'])) $data['slugen'] = $func->changeTitle(htmlspecialchars($_POST['slugen']));
            else $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
        }

        $data['type'] = $type;
    }

    /* Post seo */
    if (isset($config['news'][$type]['seo_item']) && $config['news'][$type]['seo_item'] == true) {
        $dataSeo = (isset($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;
        if ($dataSeo) {
            foreach ($dataSeo as $column => $value) {
                $dataSeo[$column] = htmlspecialchars($func->sanitize($value));
            }
        }
    }

    /* Valid data */
    $checkTitle = $func->checkTitle($data);

    if (!empty($checkTitle)) {
        foreach ($checkTitle as $k => $v) {
            $response['messages'][] = $v;
        }
    }

    if (!empty($config['news'][$type]['slug_item'])) {
        foreach ($config['website']['slug'] as $k => $v) {
            $dataSlug = array();
            $dataSlug['slug'] = $data['slug' . $k];
            $dataSlug['id'] = $id;
            $dataSlug['copy'] = false;
            $checkSlug = $func->checkSlug($dataSlug);

            if ($checkSlug == 'exist') {
                $response['messages'][] = 'Đường dẫn (' . $v . ') đã tồn tại';
            } else if ($checkSlug == 'empty') {
                $response['messages'][] = 'Đường dẫn (' . $v . ') không được trống';
            }
        }
    }

    if (!empty($response)) {
        /* Flash data */
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        if (!empty($dataSeo)) {
            foreach ($dataSeo as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);

        if ($id) {
            $func->redirect("index.php?com=news&act=edit_item&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=news&act=add_item&type=" . $type . "&p=" . $curPage . $strUrl);
        }
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('news_item', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['news'][$type]['img_type_item'], UPLOAD_NEWS, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_news_item where id = ? and type = ? limit 0,1", array($id, $type));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_NEWS . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('news_item', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* SEO */
            if (isset($config['news'][$type]['seo_item']) && $config['news'][$type]['seo_item'] == true) {
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_item', $type));

                $dataSeo['id_parent'] = $id;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man_item';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=news&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl);
        } else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=news&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl, false);
    } else {
        $data['date_created'] = time();

        if ($d->insert('news_item', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo = $func->uploadImage("file", $config['news'][$type]['img_type_item'], UPLOAD_NEWS, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('news_item', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* SEO */
            if (isset($config['news'][$type]['seo_item']) && $config['news'][$type]['seo_item'] == true) {
                $dataSeo['id_parent'] = $id_insert;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man_item';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=news&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl);
        } else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=news&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl, false);
    }
}

/* Delete item */
function deleteItem()
{
    global $d, $strUrl, $func, $curPage, $com, $type;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from #_news_item where id = ? and type = ? limit 0,1", array($id, $type));

        if (!empty($row)) {
            /* Xóa chính */
            $func->deleteFile(UPLOAD_NEWS . $row['photo']);
            $d->rawQuery("delete from #_news_item where id = ?", array($id));

            /* Xóa SEO */
            $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_item', $type));

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl);
        } else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=news&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl, false);
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);

            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from #_news_item where id = ? and type = ? limit 0,1", array($id, $type));

            if (!empty($row)) {
                /* Xóa chính */
                $func->deleteFile(UPLOAD_NEWS . $row['photo']);
                $d->rawQuery("delete from #_news_item where id = ?", array($id));

                /* Xóa SEO */
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_item', $type));
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl);
    } else $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl, false);
}

/* View sub */
function viewSubs()
{
    global $d, $func, $strUrl, $curPage, $items, $paging, $type;

    $where = "";

    $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
    $idcat = (isset($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
    $iditem = (isset($_REQUEST['id_item'])) ? htmlspecialchars($_REQUEST['id_item']) : 0;

    if ($idlist) $where .= " and id_list=$idlist";
    if ($idcat) $where .= " and id_cat=$idcat";
    if ($iditem) $where .= " and id_item=$iditem";
    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_news_sub where type = ? $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($type));
    $sqlNum = "select count(*) as 'num' from #_news_sub where type = ? $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=news&act=man_sub" . $strUrl . "&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit sub */
function editSub()
{
    global $d, $strUrl, $func, $curPage, $item, $type;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from #_news_sub where id = ? and type = ? limit 0,1", array($id, $type));

        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=news&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Save sub */
function saveSub()
{
    global $d, $strUrl, $func, $flash, $curPage, $config, $com, $type;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            if (strpos($column, 'content') !== false || strpos($column, 'desc') !== false) {
                $data[$column] = htmlspecialchars($func->sanitize($value, 'iframe'));
            } else {
                $data[$column] = htmlspecialchars($func->sanitize($value));
            }
        }

        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }

        if (!empty($config['news'][$type]['slug_sub'])) {
            if (!empty($_POST['slugvi'])) $data['slugvi'] = $func->changeTitle(htmlspecialchars($_POST['slugvi']));
            else $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
            if (!empty($_POST['slugen'])) $data['slugen'] = $func->changeTitle(htmlspecialchars($_POST['slugen']));
            else $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
        }

        $data['type'] = $type;
    }

    /* Post seo */
    if (isset($config['news'][$type]['seo_sub']) && $config['news'][$type]['seo_sub'] == true) {
        $dataSeo = (isset($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;
        if ($dataSeo) {
            foreach ($dataSeo as $column => $value) {
                $dataSeo[$column] = htmlspecialchars($func->sanitize($value));
            }
        }
    }

    /* Valid data */
    $checkTitle = $func->checkTitle($data);

    if (!empty($checkTitle)) {
        foreach ($checkTitle as $k => $v) {
            $response['messages'][] = $v;
        }
    }

    if (!empty($config['news'][$type]['slug_sub'])) {
        foreach ($config['website']['slug'] as $k => $v) {
            $dataSlug = array();
            $dataSlug['slug'] = $data['slug' . $k];
            $dataSlug['id'] = $id;
            $dataSlug['copy'] = false;
            $checkSlug = $func->checkSlug($dataSlug);

            if ($checkSlug == 'exist') {
                $response['messages'][] = 'Đường dẫn (' . $v . ') đã tồn tại';
            } else if ($checkSlug == 'empty') {
                $response['messages'][] = 'Đường dẫn (' . $v . ') không được trống';
            }
        }
    }

    if (!empty($response)) {
        /* Flash data */
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        if (!empty($dataSeo)) {
            foreach ($dataSeo as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);

        if ($id) {
            $func->redirect("index.php?com=news&act=edit_sub&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=news&act=add_sub&type=" . $type . "&p=" . $curPage . $strUrl);
        }
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('news_sub', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['news'][$type]['img_type_sub'], UPLOAD_NEWS, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_news_sub where id = ? and type = ? limit 0,1", array($id, $type));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_NEWS . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('news_sub', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* SEO */
            if (isset($config['news'][$type]['seo_sub']) && $config['news'][$type]['seo_sub'] == true) {
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_sub', $type));

                $dataSeo['id_parent'] = $id;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man_sub';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=news&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=news&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    } else {
        $data['date_created'] = time();

        if ($d->insert('news_sub', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo = $func->uploadImage("file", $config['news'][$type]['img_type_sub'], UPLOAD_NEWS, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('news_sub', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* SEO */
            if (isset($config['news'][$type]['seo_sub']) && $config['news'][$type]['seo_sub'] == true) {
                $dataSeo['id_parent'] = $id_insert;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man_sub';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=news&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=news&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Delete sub */
function deleteSub()
{
    global $d, $strUrl, $func, $curPage, $com, $type;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from #_news_sub where id = ? and type = ? limit 0,1", array($id, $type));

        if (!empty($row)) {
            /* Xóa chính */
            $func->deleteFile(UPLOAD_NEWS . $row['photo']);
            $d->rawQuery("delete from #_news_sub where id = ?", array($id));

            /* Xóa SEO */
            $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_sub', $type));

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl);
        } else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=news&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl, false);
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);

            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from #_news_sub where id = ? and type = ? limit 0,1", array($id, $type));

            if (!empty($row)) {
                /* Xóa chính */
                $func->deleteFile(UPLOAD_NEWS . $row['photo']);
                $d->rawQuery("delete from #_news_sub where id = ?", array($id));

                /* Xóa SEO */
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_sub', $type));
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl, false);
    }
}
