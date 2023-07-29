<?php include 'config/db.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $noteId = $_POST['noteId'];
  $toggled = $_POST['toggled'];
  var_dump($noteId);
  var_dump($toggled);

  if ($toggled === '1') {
    $sql = "UPDATE notes SET isdone = 1 WHERE id = $noteId";
  } 
  if($toggled === '2'){
    $sql = "UPDATE notes SET isdone = 2 WHERE id = $noteId";
  }  

  if (mysqli_query($conn, $sql)) {
    http_response_code(200); 
    echo 'Note status updated successfully.';
  } else {
    http_response_code(500); 
    echo 'Error updating note status.';
  }
}
?>