// Функция для отправки данных формы на сервер без перезагрузки страницы
function publishAd(event) {
    event.preventDefault(); // Предотвращаем отправку формы по умолчанию

    // Получаем значения полей формы
    var title = document.getElementById('title').value;
    var description = document.getElementById('description').value;

    // Создаем объект FormData и добавляем значения полей формы
    var formData = new FormData();
    formData.append('title', title);
    formData.append('description', description);

    // Создаем объект XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Устанавливаем обработчик события изменения состояния запроса
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Обработка успешного ответа
                var response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    alert(response.message); // Выводим сообщение об успешной публикации объявления
                    // Очистка полей формы или другие действия после успешной публикации
                } else {
                    alert('Ошибка при публикации объявления.');
                }
            } else {
                // Обработка ошибки при выполнении запроса
                alert('Произошла ошибка при отправке запроса.');
            }
        }
    };

    // Открываем соединение и отправляем запрос на сервер
    xhr.open('POST', 'publish_ad.php', true);
    xhr.send(formData);
}

// Устанавливаем обработчик события отправки формы
var publishForm = document.getElementById('publish-form');
publishForm.addEventListener('submit', publishAd);
