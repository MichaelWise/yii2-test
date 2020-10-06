## Установка

~~~
sudo docker-compose up -d && \
sudo docker-compose run --rm php composer install && \
sudo docker-compose exec php php yii migrate  
~~~


## Doc

### Авторизация
![alt text](./docs/image/login.jpg )

При заходе на сайт если вы не авторизованы вам предложит авторизоваться, если вы уже авторизованы то в низу форму 
есть ссылка на форму регистрации

### Регистрация
![alt text](./docs/image/registration.jpg)
 
Для регистрации необходимо ввести Username английскими буква без пробелов и знаков, email - он не должен быть занят
другим пользователем, password  - не должен быть меньше 5 символов 
 
### Список контактов
![alt text](./docs/image/books_after_registration.jpg )
После регистрации вы попадаете на страницу с контактами

#### Создать контакт
![alt text](./docs/image/list_for_create.jpg )
Для того чтобы лобавить контакт необходимо нажать на кнопку `Create Book`

![alt text](./docs/image/create_book.jpg)
После откроется форма в которой обязательные поля отмеченны звездочками `*`

![alt text](./docs/image/list_for_update.jpg )
Для редактирования контакта необходимо выбрать данный значек карандаша 

![alt text](./docs/image/list_for_delete.jpg )
Для удаления контакта необходимо выбрать данный значек корзины 

![alt text](./docs/image/update.jpg )
При обновлении контакта если картинка уже была загружена хоть один раз, то ее удалить нельзя и можно только изменить новой 



