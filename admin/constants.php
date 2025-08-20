<?php
if($_SERVER['HTTP_HOST'] == 'localhost'){
    define("BASE_URL", "http://localhost/examPaperEvaluation/admin/");
}
else{
    define("BASE_URL", "http://localhost/examPaperEvaluation/admin/");
}
?>
<script>
    var BASEURL = '<?php echo BASE_URL?>';
</script>