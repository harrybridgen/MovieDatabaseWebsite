document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('add-button').addEventListener('click', function () {
        toggleForm('add-form', 'remove-form');
    });

    document.getElementById('remove-button').addEventListener('click', function () {
        toggleForm('remove-form', 'add-form');
    });
});

function toggleForm(formId, otherFormId) {
    var form = document.getElementById(formId);
    var otherForm = document.getElementById(otherFormId);

    if (form.style.display === 'none') {
        form.style.display = 'block';
        otherForm.style.display = 'none';
    } else {
        form.style.display = 'none';
    }
}
