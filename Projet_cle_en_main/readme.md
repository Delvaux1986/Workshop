Partie Aleks ( +-40 min)

## Initialiser son projet

```composer create-project --prefer-dist laravel/laravel workshop```


- Initialiser un projet avec jetstream

``composer require laravel/jetstream``

``php artisan jetstream:install livewire``
- Permet de choisir son framework full-stack (choix entre livewire ou inertia)

``npm install && npm run dev``
- Pour compiler le tout

Modification du fichier *** .env *** présent à la racine de vôtre projet pour se connecter à la db

``php artissan migrate``

### Migration de datas vers la db

``php artissan serve``

### Petit tour de l'interface

*** app/config/jetstream.php ***

En decommentant
 ```PHP
   'features' => [
        // Features::profilePhotos(),
        // Features::api(),
        // Features::teams(),
    ],

];
```

1. ProfilePhotos
    - permet de charger/changer/delete une photo de profil
2. api
    - gestion de clés api


*** app/providers/JetstreamServiceProvider.php ***

  ```PHP
       Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
 ```

*** app/providers/FortifyServiceProvider.php ***
    - Empeche les connections trop rapprochés


### Partie creation des tables 

``php artisan make:model Topic -m -c -r``

*** database/migrations/Topics *** créer differentes colonnes

```PHP
$table->string('title');
$table->string('content');
$table->unsignedBigInteger('user_id');

 clé étrangère vers la table users
$table->foreign('user_id')->references('id')->on('users');
```

Migration vers la db avec 
``php artisan migrate``

### Creation des  **Routes**

```PHP
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Auth;


// On applique bien la racine à la méthode index (pour eviter de mettre localhost/topic/index)
Route::get('/', [TopicController::class, 'index'])->name('topics.index');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// On rajouts le préfix "topics" à toutes nos autres routes
// Comme ça on aura localhost/topics/create ou localhost/topics/update
Route::resource('topics', TopicController::class);
```
### **Fake informations** dans la db

- Créer une factory  
```php artisan make:factory TopicFactory```  

*** Database/factories/TopicFactory ***

```PHP    
'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'user_id' => \App\Models\User::factory(),
```
 
```composer dump-autoload```  

```php artisan tinker ``` 

``Topic::factory()->count(50)->create(); ``

### **Afficher les données** crées
- Dans le controller, methode *index*, créer la variable permettant de récup les données :
*** app/http/Controllers/TopicController ***
```PHP
$topics = Topic::latest()->paginate(10);

return view('topics.index', compact('topics'));
```
- Créer un dossier topics dans *** ressources/views *** + *index.blade.php* 
- Faire une boucle permettant d'afficher les topics avec : 
```PHP 
    @extends('layouts.app')

@section('title', 'Hello Woods! ')

@section('content')
<div class="container">
    <div class="list-group">
        @foreach ($topics as $topic)
        <div class="list-group-item">
            <h4><a href="{{ route('topics.show', $topic)}}">{{ $topic->title }}</a></h4>
            <p>{{ $topic->content }} </p>
            <div class="d-flex justify-content-between">
                <small> Posté le {{ $topic->created_at->format('d/m/Y à H:m') }}</small>
                <span class="badge badge-primary">{{ $topic->user->name }}</span>
            </div>
        </div>
        @endforeach
    </div>
    {{$topics->links()}}
</div>

@endsection
```
- Dans le **Model** User ajouter une méthode permettant pour la relation avec les users

*** app/models *** 

```PHP
    public function topics(){
        return $this->hasMany('App\Models\Topic');
    }
```
- Dans le **Model** Topic : 
```PHP
      public function user(){
        return $this->belongsTo('App\Models\User');
    }
```

<img src="https://media.tenor.com/images/f38991362a89e2113ab04f6d12427ac9/tenor.gif">


