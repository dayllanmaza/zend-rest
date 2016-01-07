# zend-rest

*resources are as requested. Proper form would be*
```
/restaurant
/restaurant/:id/reservation
```

*as requested*
```
|GET|/restaurant| |Retrieve all restaurants |
|POST|/restaurant|name| Insert restaurant info into db | 
|POST|/reservation|restaurantId, reservationDate, numberOfPeople| Insert a reservation into the database|
|GET|/reservation| |Retrieve all reservations from the database|
|PATCH|/reservation/<id>|reservationDate, numberOfPeople|Update an existing reservation in the database|
|GET|/reservation/<id>| |Retrieve a reservation by a given id from the database|
|DELETE|/reservation/<id`| |Remove a reservation from the database|
```
