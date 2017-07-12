# code-project
Repositório para envio do sistema CodeProject da Code Education

Este é a entrega da primeira fase do projeto.
Fiz um resumo dos passos para se chegar ao resultado final.
Segue então os passos para implementação do projeto:

1.	composer create-project laravel/laravel sysproject “5.1.*”

2.	Criar o Model e a Migration:
    
    php artisan make:model Client –m

3.	Configurar o arquivo .env => (DB_DATABASE, DB_USERNAME, DB_PASSWORD)

4.	Criar database: 
    
    mysql –u root –p | create database sysproject

5.	Definir campos da tabela “Clients” na classe: 
  
    “CreateClientsTable” no arquivo: “create_clients_table.php”:

      Schema::create('clients', function (Blueprint $table) {
    
      public function up(){
    
      $table->increment(“id”);      
    
      $table->string(“name”);
    
      $table->string(“responsible”);
    
      $table->string(“email”);
    
      $table->string(“phone”);
    
      $table->text(“address”);
    
      $table->text(“obs”);
    
      $table->timestamps();  
    }
   }

6.	php artisan migrate

7.	(Brincar com Tinker)

8.	Configurar a questão MassAssignment no model Client:

    protected $fillable = [‘name’,’responsible’,’email’, ‘phone’, ‘address’, ‘obs’];

9.	Definir uma nova Factory no arquivo: ModelFactory.php

    $factory->define(App\Client::class, function (Faker\Generator $faker) {
    
    return [
    
      'name' => $faker->name,
      
      'responsible' => $faker->name,
      
      'email' => $faker->safeEmail,
      
      'phone' => $faker->phoneNumber,
      
      'address' => $faker->address,
      
      'obs'	=> $faker->sentence,
    
    ];

    });

10.	Criar o Seeder:

  php artisan make:seeder ClientTableSeeder

  No método run() da classe ClientTableSeeder:

   factory(\App\Client::class, 10)->create();

11.	MANIPULAR OS DADOS PELO POSTMAN (API RESTful):

  11.1.	Criar o Controller  
      php artisan make:controller ClientController  
  
  11.2.	 LISTAR TODOS OS CLIENTES:    
    
    11.2.1.	Configurar rotas (route.php)
    Route::get(‘/client’,’ClientController@index’);    
    
    11.2.2.	Implementar o método index(): 
    return response()->json(['clients'=>Client::all()]);

  11.3.	CRIAR UM NOVO CLIENTE:    
    
    11.3.1.	Configurar Rota: 
    Route::post(‘/client’,’ClientController@store’);    
    
    11.3.2.	Implementar método store($request): 
    return response()->json(['client'=>Client::create($request->all())]);    
    
    11.3.3.	Configurar o CSRF:
    $middleware (tirar)
    $routeMiddleware (colocar)
    ‘csrf’ => \App\Http\Middleware\VerifyCsrfToken::class,

  11.4.	ATUALIZAR UM CLIENTE EXISTENTE:    
    
    11.4.1.	Configurar Rota:
    Route::put(‘/cliente/{id}’, ‘ClientController@update’);      
    
    11.4.2.	Implementar o método update($request, $id): 
    $client = Client::find($id);
    $status = $client->update($request->all());
    return response()->json(['status'=>$status]);

  11.5	EXIBIR UM DETERMINADO CLIENTE:   
    
    11.5.1.	Configurar Rota: 
    Route::get(‘/client/{id}’, ‘ClientController@show’);   
    
    11.5.2.	Implementar o método show($id): 
    $client = Client::find($id);
    return response()->json(['client'=>$client']);
    
  11.6.	EXCLUIR UM DETERMINADO CLIENTE:   
    
    11.6.1. Configurar Rota:
    Route::delete(‘/cliente/{id}’, ‘ClientController@destroy’);   
    
    11.6.2.	Implementar o método: destroy($id):   
    $client = Client::find($id);
    $status = $client->delete();   
    return response()->json(['status'=>$status]);
