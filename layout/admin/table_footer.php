
<script>
$(document).ready(function() {
  <?php if(isset($success) && $success == true): ?>
    Swal.fire({
      icon: 'success',
      title: 'Success',
      text: '<?php echo addslashes($success_message); ?>',
    });
  <?php endif; ?>

  <?php if(isset($error) && $error == true): ?>
    Swal.fire({
      icon: 'error',
      title: 'Oh No!',
      text: '<?php echo addslashes($error_message); ?>',
    });
  <?php endif; ?>
});

function confirmDelete(deleteUrl) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            // If confirmed, redirect to the specified delete URL
            window.location.href = deleteUrl;
        }
    });
}
</script>