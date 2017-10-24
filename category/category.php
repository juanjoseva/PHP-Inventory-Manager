<?php
$page_title = 'All categories';
require_once('../includes/load.php');
validate_access_level(1);

$all_categories = get_all_from_table('categories')
?>
<?php
if (isset($_POST['add_cat'])) {

    $req_field = array('category-name');
    validate_fields($req_field);
    $cat_name = make_HTML_compliant($db->escape($_POST['category-name']));

    if (empty($errors)) {
        $sql = "INSERT INTO categories (name)";
        $sql .= " VALUES ('{$cat_name}')";
        if ($db->query($sql)) {
            $session->msg("s", "Successfully Added Category");
            redirect_to_page('category.php', false);
        } else {
            $session->msg("d", "Sorry Failed to insert.");
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
</div>
<div class="row">
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Add New Category</span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="category.php">
                    <div class="form-group">
                        <input type="text" class="form-control" name="category-name" placeholder="Category Name">
                    </div>
                    <button type="submit" name="add_cat" class="btn btn-primary">Add category</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>All Categories</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th>Categories</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($all_categories as $cat): ?>
                        <tr>
                            <td class="text-center"><?php echo count_id(); ?></td>
                            <td><?php echo make_HTML_compliant(ucfirst($cat['name'])); ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="edit_category.php?id=<?php echo (int)$cat['id']; ?>"
                                       class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                    <a href="delete_category.php?id=<?php echo (int)$cat['id']; ?>"
                                       class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<?php include_once('../footer.php'); ?>
