<?php
require_once '../../config.php';
require_once 'product_functions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    deleteProduct($id);
}

header('Location: product_list.php');
exit();