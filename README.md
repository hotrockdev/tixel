<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Pizza Restaurant Tech Challenge

The pizza restaurant tech challenge is a simple demo of how to enable real time communications between a Laravel
backend and a public facing website. This demo utilizes [Laravel Reverb](https://reverb.laravel.com) to allow for secure, 
real time communication of events between the backend and a simulated public facing website.

Please note, this demo simply outputs the event to the Javascript console as building a frontend to display the 
event data was not a requirement of this project. 

## Installation
This demo utilizes [Laravel Sail](https://laravel.com/docs/11.x/sail) to create a Docker based environment to run
the Pizza Restaurant Challenge. It is assumed that a working version of Composer and Docker is currently installed 
and properly configured on the host system. Please ensure the following ports are open and available for use, 80, 8080, 3306.

To install this application please perform the following:
- Clone the application from the repo
- Issue the following command in the root folder ``` composer install ```
- Once the dependencies have been installed, copy the sample .env.example file to .env, making any necessary changes for your particular environment
- Now the environment can be built with the following command: ```./vendor/bin/sail up -d```
- The next step is to run the database migrations. Sample orders and a default user have been configured. To run the migrations and seed the database issue the following command: ``` ./vendor/bin/sail php artisan migrate --seed ```.
- After the migrations have ran, install the required NPM dependencies ``` ./vendor/bin/sail npm install```
- With the NPM dependencies install, run the following command to compile the necessary frontend assets ``` ./vendor/bin/sail npm run build ```
- The final step is to start Reverb by entering ``` ./vendor/bin/sail php artisan reverb:start```
- At this point you can log into the app at http://localhost and use the following credentials, username: ```pizzaiolo@domain.com``` and password: ```secret```

## Reviewing the demo
Upon logging in you will be presented with a default Jetstream dashboard. This dashboard
is a placeholder for the POS system the order management module is part of. My strategy was to leverage the Laravel
Idea plugin to quickly generate Eloquent models, relationships, migrations and factories for orders and the items associated with an order.
In a real world scenario it's assumed that an order would consist of multiple items, however for the sake of this demo
each order consists of only one item, a pizza which has 4 possible states: ordered, started, cooking, completed. To view
the orders and change the status of the pizzas, use navigation menu to visit the Pizza Status page.

All pizzas start in the "ordered" state. Once the pizzaiolo begins making the pizza the status is changed to "started". Once a pizza is 
placed into the oven the status can be updated to "cooking" and once the pizza is fully cooked, the status can be changed 
to "completed" indicating it is ready for delivery or pickup.

In addition to updating the status in the database, an event is fired which broadcasts the current state of the pizza 
using Reverb. State changes can be viewed in the Javascript console of your browser's development tools window. In a production
site, the frontend would update the status of the pizza for a given order. In the event an order would contain multiple pizzas,
the status of each pizza on an order could be shown independent of the other items. 

For simplicity the Reverb configuration has not been set to utilize a private channel or SSL, both of which would be configured
when deploying to a production environment. Additionally, Laravel Sanctum could be utilized to provide an additional layer of
authentication for the websockets.

## Strategy

My strategy for this demo was to lean heavily on Laravel's ecosystem to quickly build out a robust module for managing
the state of pizzas associated with an order. This demo utilizes the TALL stack (Tailwind, Laravel, Livewire, Alpine) to 
provide basic UI functionality, Jetstream for authentication and profile management and Reverb to handle socket based communication. 
The demo consists of a single Livewire component called PizzaStatus which loads the current orders and their related items
and displays them in a table. This table leverages Tailwind's responsive styles to hide non-essential columns to provide
a functional layout on both desktop and mobile devices. 

AlpineJS is used to show the items for an order by clicking the "items" link, which expands the row immediately beneath
the order to display the items associated the order. A simple dropdown menu is shown to allow switching between the various 
states available for the pizza. When the status is changed, the setItemStatus() method is called on the PizzaStatus component
that updates the database and fires the OrderItemUpdated event. This event broadcasts the order item id and current status 
which could then be picked up by the public facing site in real time. 

