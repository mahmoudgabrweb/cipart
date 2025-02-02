export const handleDeleteBtn = function (mainDataTable) {
    $(document).on("click", ".delete-record", function (e) {
        e.preventDefault();
        const url = $(this).attr("data-url");
        console.log({ url });
        $.confirm({
            title: 'Delete!',
            content: 'Are you sure to delete this record!',
            buttons: {
                confirm: function () {
                    axios.delete(url, {})
                        .then(response => {
                            toastr.success(response.data.message);
                            mainDataTable.ajax.reload();
                        })
                        .catch(error => {
                            console.error(error); // Handle error
                            toastr.error('An error occurred while submitting data.');
                        });
                },
                cancel: function () {
                    toastr.info("Nothing changed!");
                }
            }
        });
    });
};
