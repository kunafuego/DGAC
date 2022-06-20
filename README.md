# E3_BBD

El procedimiento almacenado utilizado para importar a los usuarios se encuentra dentro de la carpeta sql/funciones, y
tiene como nombre f_importar.sql. Para crear las contraseñas se utlizaron las siguientes convenciones:

* Para las compañías aéreas, la contraseña será un número aleatorio entre 10.000.000 y 999.999.999, por lo que será
basicamente un número aleatorio de entre 8 y 9 dígitos.

* Para el caso de los pasajeros, su contraseña va a ser el largo de su pasaporte repetido un número aleatorio de veces (entre 0 y 9), concatenado con el largo de su nombre repetido un número aleatorio de veces (nuevamente, entre 0 y 9).