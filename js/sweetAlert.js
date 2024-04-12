$(document).ready(function(){

    $(".delete").click(function (e) { 
        e.preventDefault();
        
        var id = $(this).val();

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
                // Swal.fire({
                // title: "Deleted!",
                // text: "Your file has been deleted.",
                // icon: "success"
                // });
                $.ajax({
                    method: "POST",
                    url: "../pages/delete_event.php?",
                    data: {
                        'id': id,
                        'delete': true
                    },
                    success: function (response) {
                        if(response === 200) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Event has been deleted.",
                                icon: "success"
                            });
                            $("#eventsTable").load(location.href + " #eventsTable");
                        }
                        else if(response === 500) {
                            Swal.fire({
                                title: "Error!",
                                text: "Unexpected Error Occured.",
                                icon: "error"
                            });
                        }
                    }
                });
            }
        });
    });

});