### Endpoints

```
```





## Instalação
 
Clone este repositório:
 
   ```bash
   git clone https://seurepositorio.com
   ```
Composer:
   Gerenciador de pacotes, onde podemos instalar dependências externas.

   ```bash
   # Inicializa um projeto com o composer 
   composer init
   ```

   ```bash
   #Instala uma nova dependência do projeto
   composer require nome_dependencia
   ```

   ```bash
   #remove uma dependência do projeto
   composer remove nome_dependencia
   ```

   ```bash
   #Instala uma dependência de desenvolvimento
   composer require nome_dependencia --dev
   ```

   ```bash
   #Instala todas as dependencias que estão listadas no composer.json
   composer install
   ```

   ```bash
   #Instala todas as dependencias sem o pacote de desenvolvimento
   composer install --no--dev
   ```

   ### o autoload

   ```
   "autoload": {
        "psr-4": {
            "Projetux": "src/"
        }
    },
   
   ```

   ### Toda alteração precisa ser executado o comando 

   ```bash
      composer dumpautoload
   ```
