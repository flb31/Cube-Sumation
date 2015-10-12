#Cube Summation


> Autor: Fabian Luna Barrios

> Correo: flb031@gmail.com

> Info: https://www.hackerrank.com/challenges/cube-summation

###Caracteristicas
El método de entrada de los comandos es diferente a como se maneja en el ejercicio, Cada comando se va ingresando de 1 en 1, no lee un lote de comandos.

#####Comando adicional:
`reset`: Reinicia la aplicación para iniciar desde T ( Numero de casos a testear ).

###Requerimientos
* PHP >= 5.3.0

###Descripción de clases


* **App/**
    
    * **Cube.php:** Clase principal de la aplicación, mantiene la lógica general.

    * **Config/** 
        
        * **Config.php:** Clase que lleva las variables globales de configuración de la aplicación.

    * **Helpers/**
        
        * **Extractor.php:** Se encarga de extraer los digitos de los comandos de entrada.

        * **Persistence.php:** Se encarga de llevar el control de los datos en sesión.

        * **Sequencer.php:** Lleva el control de los comandos que deben ser ejecutados en su momento.

    * **Rules/**
        
        * **Policy.php:** Lleva las restricciones de datos como la dimensión del cubo, limite de operaciones a ejecutar, ect.

        * **Validator.php:** Encargado de verificar que los comandos de entrada cumplan con la sintaxis correcta.
        
* **public/**
    * **index.html:** Interfaz de la aplicación.
    * **assets/:** Contiene los archivos .css y .js para el template.
    * **process.php:** Realiza peticiones a la aplicación del cubo.
    
