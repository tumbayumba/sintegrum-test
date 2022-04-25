Yii 2 Minimal Application Template
================================

Yii 2 Minimal Application Template is a skeleton Yii 2 application best for
starting totally from scratch.

The template contains the basic features including user login/logout.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.


DIRECTORY STRUCTURE
-------------------

      common/                             Компоненты общего уровня приложения
          components/
              parsers/
                  TicketParser.php        Производит вычисления маршрутов
              rest/
                  RestModule.php          Предзагрузка модуля для REST API(формат входящих и данных ответа) 
          controllers/
              BaseRestController.php      Базовый контроллер. В нем реализована BearerToken аутентификация на базе модели /app/models/User 
      
      modules/                            Содержит каталоги версионности API
          v1/
              controllers/
                  FlightController.php    Контроллер, в котором реализован один экшн actionEndpoint
          v2/

REST API METHODS
-------------------
http://sintegrum-test.sr-studio.com.ua
POST /v1/flight/endpoint  -  метод получения конечной точки назначения с возможной точкой разрыва

BearerToken = gblZYh5QglOCKwy2IjOyxPaRVqBFbOmX
Accept: {application/xml | application/json}

Postman collection:
/app/sintegrum-test.postman_collection.json

Body data:
/app/routes_endpoint.xml
/app/routes_endpoint_with_breakpoint.xml

GitHub
https://github.com/tumbayumba/sintegrum-test