$(document).ready(function () {
    $('#tutor, #auditory, #head, #recordSelect, #building' ).select2({
        width: '100%', // Делает поле поиска адаптивным
        minimumResultsForSearch: 0
    });
});

$(function () {
    $('#example2').DataTable({
        "paging": true,
        "lengthChange": true,
        "lengthMenu": [10, 25, 50, 100, 200, 500],
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "stateSave": true,
        "deferRender": true,
        "language": {
            "lengthMenu": "Показать _MENU_ записей на странице",
            "zeroRecords": "Записи не найдены",
            "info": "Показаны записи с _START_ по _END_ из _TOTAL_",
            "infoEmpty": "Нет данных",
            "infoFiltered": "(отфильтровано из _MAX_ записей)"
        },
    });

});

    function readURL(input) {
    if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
    $('#image')
    .attr('src', e.target.result)
    .width(80)
    .height(80);
};
    reader.readAsDataURL(input.files[0]);
}
}
    document.addEventListener('DOMContentLoaded', function() {
    var id_name = document.getElementById('id_name');
    id_name.addEventListener('change', function() {
    var selectedProductId = this.value;
    fetchForm(selectedProductId);
});
});
function fetchForm(id_name) {
    fetch('/get-product-form/' + id_name)
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('product-form-container');
            container.innerHTML = ''; // Очищаем контейнер перед добавлением нового содержимого

            // Создаем массив для хранения id_characteristic
            let idCharacteristics = [];

            // Добавляем каждый id_characteristic в массив и в DOM
            data.forms.forEach(form => {
                const formContainer = document.createElement('div');
                formContainer.innerHTML = form.input_characteristic;
                container.appendChild(formContainer);

                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'id_characteristic[]'; // Обратите внимание на квадратные скобки []
                hiddenInput.value = form.id_characteristic;
                formContainer.appendChild(hiddenInput);

                // Добавляем id_characteristic в массив
                idCharacteristics.push(form.id_characteristic);
            });

            // Выводим данные в консоль (можно удалить в продакшене)
            console.log('ID Characteristics:', idCharacteristics);
        })
        .catch(error => console.error('Ошибка при загрузке формы:', error));
}

// Обработка отправки формы
document.getElementById('myForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Останавливаем стандартное поведение формы

    // Собираем данные из формы
    const formData = new FormData(this);

    fetch(this.action, {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Данные успешно сохранены!');
                // Можно выполнить перенаправление или другие действия
            } else {
                alert('Ошибка при сохранении данных.');
            }
        })
        .catch(error => console.error('Ошибка при отправке формы:', error));
});
document.getElementById('myForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const values = formData.getAll('values[]');

    fetch('/dit_create/addAll', {
    method: 'POST',
    headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': csrfToken // CSRF токен Laravel
},
    body: JSON.stringify({ values })
})
    .then(response => response.json())
    .then(data => console.log(data))
    .catch(error => console.error('Ошибка:', error));
});
    document.getElementById('searchInput').addEventListener('input', function() {
    var searchQuery = this.value.toLowerCase();
    var selectElement = document.getElementById('mySelect');
    var options = selectElement.options;

    for (var i = 0; i < options.length; i++) {
    var option = options[i];
    var optionText = option.text.toLowerCase();
    var isMatch = optionText.indexOf(searchQuery) >= 0;
    option.style.display = isMatch ? '' : 'none';
}
});



