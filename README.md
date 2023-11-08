# REST API for yesim test task
## Task description
Цель:
- Разработать REST API (CRUD) сервис.
- Создание элементов
- Обновление элементов
- Удаление элементов
- Получение информации о элементе
- Валидацию полей сущности
- Тестами покрывается и функционал и БД
- Использование token для доступа к данным
- История изменений сущности

Вводные данные:\
Сущность: Item\
Поля сущности:\
id - int автоинкремент\
name - char(255)\
phone - char(15)\
key - char(25) not null\
created_at - datetime - дата создания элемента\
updated_at - datetime - дата обновления элемента\
\
Стек технологий: PHP5.6, PHP8(без использования фреймворков)\
\
Тестовое задание необходимо выложить на репозитории, GitHub дать доступ, если приватный репозиторий.

## Database structure
```sql
CREATE TABLE `item` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `key` varchar(25) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `item`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

CREATE TABLE `logger_table` (
  `id` int NOT NULL,
  `action_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `entity` varchar(512) NOT NULL,
  `item_id` int NOT NULL,
  `changes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `logger_table`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `logger_table`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
```
## Usage

See `public/api/index.php` for usage example.
```php
$app = new ApiApp();
$app->initDatabase(PDO_DSN, PDO_USERNAME, PDO_PASSWORD, true);

$auth = $app->getAuth();

if(!$auth->check()) {
    $view = $app->getView("403", ["error" => "Authentication required"]);
    $view->writeError();
    exit();
}

try {
    $controller = $app->getController($uri[0]);
    $controller->execute($uri, $_SERVER["REQUEST_METHOD"]);
    $view = $app->getView($controller->getStatus(), $controller->getData());
    $view->write();
} catch(Exception $e) {
    $view = $app->getView("500", ["error" => $e->getMessage()]);
    $view->writeError();
}
```