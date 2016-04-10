$(function () {
    $('#delete-entity').click(function (event) {
        event.preventDefault();
        if (confirm("Вы уверены?")) {
            location.href = $(this).data('url');
        }
    });
});