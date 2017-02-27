// запуск веб-сервера 
php app/console server:run

// виводить список маршрутів
php app/console router:debug

// Для створення звязку між таблицями необхідно спочатку сторити індекси чи первинні ключі в таблицях в phpmyadmin і там же створити між ними звязок
// Далі сторити мапінг, на його основі сутності та добавити гетери, сетери

// очистити кеш
php app/console cache:clear --env=prod
php app/console cache:clear --env=dev



// ствоити базу даних з параметрами з parameters.yml
// по замовчуванню база створюється в кодуванні latin
// для створення в UTF8 або ж utf8mb4 потрібно корегувати файл конфігурації mysql
// добаваити в файл my.ini параметри створення по-замовчуванню:
// collation-server = utf8mb4_general_ci
// character-set-server = utf8mb4
php app/console doctrine:database:create

// видалити базу даних
php app/console doctrine:database:drop --force

// створює пакет з іменем AcmeTestBundle
php app/console generate:bundle --namespace=Acme/MobileBundle

// створює маппінг кожної таблиці на відповідний клас
php app/console doctrine:mapping:import AсmeMobileBundle

// добавляє гетери/сетери до класу
php app/console doctrine:generate:entities AppBundle/Entity/Product

// добавляє гетрери/сетери до всіх класів в папці Entities пакету AppBundle, створює відсутні класи
php app/console doctrine:generate:entities ACmeMobileBundle

// сторити таблиці в БД на основі класів з папки Entity
php app/console doctrine:schema:update --force

// конвертує створенні маппінги з xml|yml в анотації
php app/console doctrine:mapping:convert annotation ./src

// doctrine використовує тільки один тип маппінгу. Обовязково видаляти інший тип за наявності.
// тобто якщо використовуємо анотації, обовязково видалити xml|yml
// для створення репозиторія з мапінг-типом анотації необхідно:
// - створити мапінг для всіх таблиць php app/console doctrine:mapping:import AppBundle
// - створити ентіті класи для всіх таблиць php app/console doctrine:generate:entities AppBundle
// - конвертувати мапінг в анотації php bin/console doctrine:mapping:convert annotation ./src
// - видалити мапінг xml|yml обовзяково
// - добавити в потрібний клас анотацію @ORM\Entity(repositoryClass="AppBundle\Entity\ArticlesRepository")
// - повторно створити ентіті класи php app/console doctrine:generate:entities AppBundle

