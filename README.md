# Entrega 3 Bases de Datos: Proyecto final grupo 40

Para comenzar, quisieramos recalcar que esta entrega fue realizada únicamente por los integrantes del grupo 40. Nos habíamos juntados con el grupo 69, pero estos decidieron no participar de la entrega. El trato al que llegamos con el ayudante encargado de proyecto fue que no era necesario que realizaramos la funcionalidad adicional. Sin más que agregar, comencemos.

La entrega fue realizada en su totalidad, pues todas las funcionalidades fueron logradas en la aplicación. El funcionamiento es básicamente un archivo index.php el cual contiene la lógica de la aplicación, y desde ahí se van llamando funciones de los archivos de la carpeta consultas.

## Importar Usuarios  
Esta funcionalidad se realizó mediante una función creada en un procedimiento almacenado que está en la carpeta Entrega3 como f_importar.sql, la cual en su interior posee la función importar_usuario(). Lo primero que hace la función es chequear si es que la tabla está creada o no. En caso de que lo esté, seteará todas las variable como NULL, lo que hará que no se inserte ningún valor a la tabla, porque esta ya tendrá todos los valores ingresados. En caso de que no exista la tabla, se creará y seteará todas las variables como true, con lo que se ingresará a cada bloque IF y se insertarán todos los valores necesarios en la tabla. En cuanto a las contraseñas, para las compañías aéreas va a ser un número entero aleatorio entre 100 y 1000000. Luego, para los pasajeros la contraseña será una concatenación entre: los primero n caracteres del pasaporte del pasajero y los primeros n caracteres del nombre del pasajero, siendo n en ambos casos un número aleatorio entre 0 y 10. En caso de que n sea mayor que el número de caracteres del pasaporte o del nombre, no hay problema, pues se imprimirán estos completos.

Luego fueron creados los 3 tipos de usuario con sus respectivos menús, mediante los cuales pueden realizar cada una de sus funcionalidades. 

Explicaremos un poco más en profundidad el de generar reservas, pues también se hace mediante un procedimiento almacenado:

## Generar Reserva
Esta funcionalidad se realizó mediante la función generar_reserva(), la cual está dentro del archivo f_generar_reserva.sql, también dentro de la carpeta Entrega3. Esta recibe como argumentos 4 valores. Los primeros 3 son, el pasaporte del pasajero en caso de que se haya rellenado ese hueco al generar la reserva, o '-' en caso de que el hueco del formulario haya quedado vacío a la hora de generar la reserva. El 4to es el id del vuelo al cual se deben hacer las reservas. Luego itera por cada integrante, y si el valor es distinto de '-', inserta un valor a la tabla con las reservas.

Luego se inserta también una tupla en la tabla ticket, en la que los atributos no definido se dejan como 0 o 'TBD', dependiendo del tipo de dato con el que estaba definida la tabla.

El resto creemos que es muy intuitivo de corregir! Muchas gracias por su tiempo!
