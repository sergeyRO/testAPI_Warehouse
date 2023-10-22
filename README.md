## API для тестового задания Склад
Перед работой необходимо выполнить:
1. php artisan migrate - Добавить в БД таблицы
2. php artisan db:seed - Заполнить БД случайными значениями

Описание методов:
1. /api/warehouses - Просмотреть список складов (метод GET)

2. /api/products - Просмотреть список товаров с их остатками по складам (метод GET)

3. /api/orders - Получить список заказов (с фильтрами и настраиваемой пагинацией) (метод GET) 
   ######Пример: api/orders?limit=20&status=canceled
   ####Пояснение:
         page - страница
         limit - количество заказов на странице
         status - статус заказа (active,comleted,canceled)
         customer - покупатель
         created_at - дата создания заказа
         completed_at - дата выполнения заказа
         warehouse_id - Id-склада
         
4. /api/orders - создание заказа (метод POST) в Headers(Content-Type:application/json)
    ####Пример:
            {   
            "customer":"Иванов И.И.",	
        	"products":[
        			{
        				"product_id":1,
        				"count":100
        			},
        			{
        				"product_id":2,
        				"count":10
        			},
        			{
        				"product_id":3,
        				"count":55
        			}
        		]
        		}
    ####Пояснение:
          customer - покупатель
          product_id - Id-продукта
          count - количество 
          
5. /api/orders/{id} - изменение заказа (метод PUT) в Headers(Content-Type:application/json), где {id} - Id-заказа
    ####Пример:
         {
         	"customer":"Петров И.Ию",
         	"products":[
         			{
         				"product_id":1,
         				"count":55
         			},
         			{
         				"product_id":2,
         				"count":44
         			},
         			{
         				"product_id":3,
         				"count":22
         			},
         			{
         				"product_id":4,
         				"count":15
         			}
         		]
         		}   
    ####Пояснение:
        customer - покупатель
        product_id - Id-продукта
        count - количество 
        
6. /api/orders/{id}/state - изменить статус заказа (метод PATCH) в Headers(Content-Type:application/json), где {id} - Id-заказа 
    ####Пример:
         {
         	"status":"active"
         }
    ####Пояснение:
        status - Статус заказа для изменения (active,completed,canceled)
        
7. /api/motions - просмотра историй изменения остатков товаров (метод GET)
    #####Пример: /api/motions?limit=20&page=2
    ####Пояснение:
            page - страница
            limit - количество заказов на странице
            order_id - Id-заказа
            product_id - Id-продукта
            created_at - дата создания записи
            action - действие с товаром в заказе (Возврат,В обработке,Выполнен)
            warehouse_id - Id-склада
            remain - остаток на складе