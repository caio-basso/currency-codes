# Currency Project

Neste projeto foi desenvolvida uma API utilizando o Laravel 10, um crawler e uma API utilizando pyhon com as bibliotecas scrapy e flask e o frontend utilizando o Nuxt 2 do framework Vue.

# Tecnologias utilizadas:
* Docker
  * Todos os serviços estão em containers com um docker-compose para diretório
* PHP
  * Laravel
  * Swagger
  * Redis
* Python
  * Flask
  * Scrapy
* Vue
  * Nuxt 2
  * Vuetify
  * Tailwind   

# Serviços
* Python Crawler e API
  * Criada uma API que possui um endpoint responsável por receber a requisição vinda do laravel e realizar o scrape da página https://pt.wikipedia.org/wiki/ISO_4217# para recuperar as informações contidas na tabela "Códigos ISO para moedas".
  * Scrape realizado utilizando seletores css e xpath em conjutno;
  * O endpoint retorna um JSON com todas as informações retornadas pelo scrape da tabela.
 
* Laravel API
  * Criada uma Route, um Controller, um Form Request, uma Rule e um Service;
  * Criado um integrator para comunicação com a API do Python;
  * Criado um endpoint responsável por receber as requests vindas do frontend e realizar o seguinte processo:
    * Verifica se as informações solicitadas se encontram no cache do Redis;
    * Caso as informações sejam encontradas no cache, elas já são imediatamente retornadas;
    * Se as informações não estiverem no cache, é enviada uma requisição para API do python através do PythonIntegrator para que as informações sejam lidas novamente na página e retornadas;
    * Essas informações são salvas novamente no cache com uma validade de 24 horas;
  * O enpoint recebe um body onde podem ser passados os códigos e números no mesmo campo, no seguinte formato:
  * 
    {
    "list": ["BRL", "USD", "008", "EUR"]
    }
  
  * Criados testes unitários para a Service e para a Controller presentes no projeto;
  * Criada documentação utilizando o swagger;
    * Documentação pode ser acessada através da URL: /api/documentation
      
      ![image](https://github.com/caio-basso/currency-codes/assets/91400047/7f51618e-f86b-4db3-a7ff-987bea82de46)

* Nuxt 2
  * Criado o front utilizando o nuxt 2 em conjunto com o tailwindcss e alguns componentes do vuetify;
  * O frontend consiste em uma página com um campo de busca onde podem ser passados os códigos ou números que deseja buscar:

     ![image](https://github.com/caio-basso/currency-codes/assets/91400047/cef0f83a-afcf-46c4-8ef9-500329191551)
    
  * São retornados cards com a informações retornadas pelo laravel:
 
    ![image](https://github.com/caio-basso/currency-codes/assets/91400047/5701f0e8-766d-444b-ae74-c6a2842cd756)

  * Caso a informação não seja encontrada é exibida uma mensagem de erro:

    ![image](https://github.com/caio-basso/currency-codes/assets/91400047/87e9f8ce-eded-49e5-8938-3c1a875e12e7)

