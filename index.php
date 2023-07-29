<?php include 'inc-files/header.php'; ?>

<?php 
    $sql = 'SELECT * FROM notes';
    $result = mysqli_query($conn, $sql);
    $notes = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!-- Add note -->
<?php
    $note = '';
    $notesErr = '';

    if(isset($_POST['submit'])){
        if(empty($_POST['text-input'])){
            $notesErr = 'Text is required';
        } else{
            $note = filter_input(INPUT_POST, 'text-input', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
    
    // echo $note;
    if(empty($notesErr)){
        $sql = "INSERT INTO notes (notes) VALUES ('$note')";

        if(mysqli_query($conn, $sql)){
            header('Location: index.php');
    } else{
        echo 'Error:' . mysqli_error($conn);
    }
    }
}
?>

<!-- Delete note -->
<?php
    if (isset($_POST['delete'])) {
        $noteId = $_POST['noteId-d'];
        $sql = "DELETE FROM notes WHERE id = $noteId";
    
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
        } else {
            echo 'Error:' . mysqli_error($conn);
        }
    }
?>



<div class="container">
    <div class="todo-app">
        <h2>To-do List <i class="fas fa-sticky-note"></i></h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="row">
            <input type="text" id="input-box" placeholder="Add a note" name="text-input">
            <button type="submit" name="submit" value="Send" class="button">Add</button>
        </div>
        </form>
        
        <div class=".err-msg">
                <?php echo $notesErr; ?>
        </div>

        <ul class="listContainer">
           <?php foreach($notes as $item): ?> 
            <li class="itemRow <?php echo $item['isdone'] == 1 ? 'checked' : ''?>" data-node-id="<?php echo $item['id']; ?>" data-toggle="<?php echo $item['isdone'];?>">
                <p class="listItem" data-node-id="<?php echo $item['id']; ?>" data-toggle="<?php echo $item['isdone'];?>"><?php echo $item['notes']?></p>
                <form method="post">
                  <input type="hidden" name="noteId-d" value="<?php echo $item['id']; ?>">
                  <span><button type="submit" name="delete" class="delete-btn">x</button></span>
                </form>
            </li>
           <?php endforeach; ?> 
           </ul>

            <script>
                const listItems = document.querySelectorAll('.itemRow');
                listItems.forEach(item => {
                    item.addEventListener('click', function() {
                    const noteId = this.getAttribute('data-node-id');
                    var toggled = this.getAttribute('data-toggle');
                    item.classList.toggle('checked');
                    console.log(toggled);
                    if(toggled === '1'){
                        toggled = 2;
                    } 
                    if(toggled === '2'){
                        toggled = 1;
                    }
                    console.log(toggled);
                    console.log(noteId);
                    updateNoteStatus(noteId, toggled);
                });
                });

                function updateNoteStatus(noteId, toggled) {
                    const formData = new FormData();
                    formData.append('noteId', noteId);
                    formData.append('toggled', toggled);
                fetch('update_task_status.php', {
                method: 'POST',
                body: formData
                }).then(response => {
                if (response.ok) {
                console.log('success');
                } else {
                console.log('Error updating note status.');
                }
                }).catch(error => {
                console.log('Error:', error);
                });
                }
            </script>
            
    </div>
</div>


<?php include 'inc-files/footer.php'; ?>
