<?php
$page_title = 'Edit category';
require_once('../includes/load.php');

validate_access_level(1);
?>
<?php

$category = find_record_by_id('category', (int)$_GET['id']);
if (!$category) {
    $session->msg("d", "Missing category id.");
    redirect_to_page('category.php');
}
?>

<?php
if (isset($_POST['edit_cat'])) {

    $req_field = array('category-name');
    validate_fields($req_field);
    $cat_name = make_HTML_compliant($db->escape($_POST['category-name']));

    if (empty($errors)) {
        $sql = "UPDATE categories SET name='{$cat_name}'";
        $sql .= " WHERE id='{$category['id']}'";
        $result = $db->query($sql);

        if ($result && $db->affected_rows() === 1) {
            $session->msg("s", "Successfully updated Category");
            redirect_to_page('category.php', false);
        } else {
            $session->msg("d", "Sorry! Failed to Update");
            redirect_to_page('category.php', false);
        }

    } else {
        $session->msg("d", $errors);
        redirect_to_page('category.php', false);
    }
}
?>
<?php include_once('../header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo make_alert_msg($msg); ?>
    </div>
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Editing <?php echo make_HTML_compliant(ucfirst($category['name'])); ?></span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_category.php?id=<?php echo (int)$category['id']; ?>">
                    <div class="form-group">
                        <input type="text" class="form-control" name="categorie-name"
                               value="<?php echo make_HTML_compliant(ucfirst($category['name'])); ?>">
                    </div>
                    <button type="submit" name="edit_cat" class="btn btn-primary">Update categorie</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include_once('../footer.php'); ?>