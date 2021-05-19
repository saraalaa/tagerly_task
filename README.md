
[![Build Status](https://travis-ci.com/saraalaa/tagerly_task.svg?branch=master)](https://travis-ci.com/saraalaa/tagerly_task)
[![Maintainability](https://api.codeclimate.com/v1/badges/464629e05e6b86f6a6e2/maintainability)](https://codeclimate.com/github/saraalaa/tagerly_task/maintainability)
## Tagerly Task

This task has one api that display all products in inventory applying filter on them
by hit this get url:

 ["http://127.0.0.1:8000/api/products?product_name=suscipit&vendor_name=Zu&min_price=100&max_price=900&sort_by=selling"](https://laravel.com/docs/routing).
- product_name to search about all products that their name contain its value 'not case-sensitive'.
- vendor_name to search about all products that their vendor name contain its value 'not case-sensitive'.
- min_price to search about all products that their price greater than or equal its value.
- max_price to search about all products that their price less than or equal its value.
- sort_by (which accept only: 'selling' or 'price' or 'votes') to sort products by most selling, or lowest price, or most voted according to its value.

** NOTE : All Filters are Optional.


## Running Project

- A : clone project in any directory . 
- B : Go inside cloned project and run command "composer install" in terminal.
- C : Rename .env.example to .env 
- D : Run command "php artisan key:generate" in terminal.
- E : Make sure to add project absolute-path inside .env in key : DB_DATABASE.
- F : Run command "php artisan serve".


## Running Test

This project include test cases for filter criteria, you can run all of them by run command: 

"php artisan test"
