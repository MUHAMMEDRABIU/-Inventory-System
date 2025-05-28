<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

// Check if item number was sent via POST
if (!isset($_POST['itemDetailsItemNumber'])) {
    echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item number not provided.</div>';
    exit();
}

// Sanitize and validate input
$itemNumber = trim(htmlentities($_POST['itemDetailsItemNumber']));
$itemNumber = filter_var($itemNumber, FILTER_SANITIZE_STRING);

if (empty($itemNumber)) {
    echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter the item number.</div>';
    exit();
}

try {
    // Check if item exists in the database
    $checkSql = 'SELECT itemNumber FROM item WHERE itemNumber = :itemNumber';
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute(['itemNumber' => $itemNumber]);

    if ($checkStmt->rowCount() === 0) {
        echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item does not exist in the database. Cannot delete.</div>';
        exit();
    }

    // Proceed to delete item
    $deleteSql = 'DELETE FROM item WHERE itemNumber = :itemNumber';
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->execute(['itemNumber' => $itemNumber]);

    echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Item successfully deleted.</div>';
    exit();
} catch (PDOException $e) {
    // Log error in production
    echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Error deleting item: ' . htmlspecialchars($e->getMessage()) . '</div>';
    exit();
}
?>
