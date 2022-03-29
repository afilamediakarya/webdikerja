@if(session()->has('Alert'))

<script>

    swal.fire({
        text: "All is cool! Now you submit this form",
        icon: "success",
        buttonsStyling: false,
        confirmButtonText: "Ok, got it!",
        customClass: {
            confirmButton: "btn font-weight-bold btn-light-primary"
        }
    })
</script>
@endif