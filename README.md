Задача: Показать работу с иерархическим списком новостных рубрик. Сделать Rest Api.

common/helpers - хэлперы

common/models/db - модели таблиц бд

common/modules/api - Api проекта

console/migrations - миграции

frontend/controllers - контроллеры проекта

frontend/web/js/ - javascript

Примеры обращения к API:
Получение новостей:

http://asfalt7.online/api/v1/catalog/get-news/

http://asfalt7.online/api/v1/catalog/get-news/?rubric_id=6

http://asfalt7.online/api/v1/catalog/get-news/?rubric_id=10

Получение рубрик:
http://asfalt7.online/api/v1/catalog/get-rubrics/

http://asfalt7.online/api/v1/catalog/get-rubrics/?rubric_id=6

http://asfalt7.online/api/v1/catalog/get-rubrics/?rubric_id=0

http://asfalt7.online/api/v1/catalog/get-rubrics/?rubric_id=10


=== Доступ к новостям ===
http://asfalt7.online/news
