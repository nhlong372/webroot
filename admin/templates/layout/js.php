<!-- Js Config -->
<script type="text/javascript">
    var PHP_VERSION = <?=PHP_VERSION_ID?>;
    var CONFIG_BASE = '<?= $configBase ?>';
    var TOKEN = '<?= TOKEN ?>';
    var ADMIN = '<?= ADMIN ?>';
    var ASSET = '<?= ASSET ?>';
    var LINK_FILTER = '<?= (!empty($linkFilter)) ? $linkFilter : '' ?>';
    var ID = <?= (!empty($id)) ? $id : 0 ?>;
    var COM = '<?= (!empty($com)) ? $com : '' ?>';
    var ACT = '<?= (!empty($act)) ? $act : '' ?>';
    var TYPE = '<?= (!empty($type)) ? $type : '' ?>';
    var HASH = '<?= $func->generateHash() ?>';
    var ACTIVE_GALLERY = <?= (!empty($flagGallery) && !empty($gallery)) ? 'true' : 'false' ?>;
    var BASE64_QUERY_STRING = '<?= base64_encode($_SERVER['QUERY_STRING']) ?>';
    var LOGIN_PAGE = <?= (empty($_SESSION[$loginAdmin]['active'])) ? 'true' : 'false' ?>;
    var MAX_DATE = '<?= date("Y/m/d", time()) ?>';
    var CHARTS = <?= (!empty($charts)) ? json_encode($charts) : '{}' ?>;
    var ADD_OR_EDIT_PERMISSIONS = <?= (!empty($com) && $com == 'user' && !empty($act) && in_array($act, array('add_permission_group', 'edit_permission_group'))) ? 'true' : 'false' ?>;
    var IMPORT_IMAGE_EXCELL = <?= (!empty($com) && $com == 'import' && !empty($config['import']['images'])) ? 'true' : 'false' ?>;
    var ORDER_ADVANCED_SEARCH = <?= (!empty($com) && $com == 'order' && !empty($config['order']['search'])) ? 'true' : 'false' ?>;
    var ORDER_MIN_TOTAL = <?= (!empty($minTotal)) ? $minTotal : 1 ?>;
    var ORDER_MAX_TOTAL = <?= (!empty($maxTotal)) ? $maxTotal : 1 ?>;
    var ORDER_PRICE_FROM = <?= (!empty($price_from)) ? $price_from : 1 ?>;
    var ORDER_PRICE_TO = <?= (!empty($price_to)) ? $price_to : ((!empty($maxTotal)) ? $maxTotal : 1) ?>;
</script>

<!-- Js Files -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<script src="assets/confirm/confirm.js"></script>
<script src="assets/select2/select2.full.js"></script>
<script src="assets/sumoselect/jquery.sumoselect.js"></script>
<script src="assets/datetimepicker/php-date-formatter.min.js"></script>
<script src="assets/datetimepicker/jquery.mousewheel.js"></script>
<script src="assets/datetimepicker/jquery.datetimepicker.js"></script>
<script src="assets/daterangepicker/daterangepicker.js"></script>
<script src="assets/rangeSlider/ion.rangeSlider.js"></script>
<script src="assets/js/priceFormat.js"></script>
<script src="assets/jscolor/jscolor.js"></script>
<script src="assets/filer/jquery.filer.js"></script>
<script src="assets/holdon/HoldOn.js"></script>
<script src="assets/sortable/Sortable.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/adminlte.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="assets/apexcharts/apexcharts.min.js"></script>
<script src="assets/simplenotify/simple-notify.js"></script>
<script src="assets/comment/comment.js"></script>
<script src="assets/js/apps.js"></script>