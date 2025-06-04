document.addEventListener('DOMContentLoaded', function () {
    const deleteLinks = document.querySelectorAll('.delete-funcionario');

    deleteLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const confirmDelete = confirm('Tem certeza que deseja excluir esse funcionário?');

            if (confirmDelete) {
                window.location.href = link.href;
            }
        });
    });
});