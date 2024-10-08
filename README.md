# Тестовое задание на позицию веб-разработчик

## Условия:
В базе данных присутствует несколько компаний. Каждой компании соответствует информационная страница.

## Поля:
- Название 
- ИНН
- Общая информация
- Генеральный директор
- Адрес
- Телефон

К каждому полю каждой компании пользователь имеет возможность оставить заметки (комментарии). 
Также можно оставить комментарий к компании целиком. 
Можно оставлять больше одного комментария, они выводятся списком, с временем добавления.
Подразумевается, что эти комментарии не общедоступны, то есть это не публичное обсуждение компании всеми со всеми, это заметки пользователя для себя и, возможно, его коллег.

## Технологии:
Laravel 10, Inertia, Vue 3, mySQL, tailwind.

## Задание:
Примерный макет https://i.imgur.com/Ii7efIL.png - это примерный макет, а не готовый дизайн, но структура должна оставаться как в макете.
1.	Адаптивная верстка для всех разрешений экрана.
2.	Cоздать таблицы в БД для хранения компаний и комментариев
3.	Базовая верстка страниц:
    - список компаний,
    - информационная страница компании.
4.	С серверной стороны реализовать вывод данных из БД на соответствующие страницы .
5.	реализовать интерактивность добавления комментария (поле ввода по умолчанию должно быть скрыто, открываться по желанию пользователя, закрываться после сохранения, ожидается логичное дружественное для пользователя поведение).
6.	реализовать регистрацию, авторизацию.
7.	Уделить особое внимание архитектуре базы.