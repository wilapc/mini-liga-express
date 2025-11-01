# MiniLiga Express - Backend API

Backend desarrollado en Laravel 12 para la gestión de equipos, partidos y resultados.

📂 Estructura principal
```bash
backend/
├─ app/
│  ├─ Actions/           # Lógica de cálculo de puntajes
│  ├─ Http/
│  │  ├─ Controllers/Api # Controladores de la API
│  │  └─ Requests/       # Validaciones (TeamRequest, GameRequest)
│  └─ Models/            # Modelos Eloquent (Team, Game)
├─ database/
│  ├─ migrations/        # Migraciones
│  └─ seeders/           # Seeders opcionales
├─ routes/
│  └─ api.php            # Rutas de la API
├─ tests/
│  └─ Feature/           # Pruebas de integración
│      └─ MiniLigaTest.php
└─ README.md
```

## ⚡ Endpoints API
| Método | Ruta |	Descripción |
| ------ | ---- | ----------- |
| GET    | `/api/teams` | Lista todos los equipos |
| POST	   | `/api/teams` | Crea un nuevo equipo (payload: `{ name: string }`) |
| GET	   | `/api/games` | Lista partidos pendientes (sin resultado) |
| POST	   | `/api/games/{id}/result` | Reporta resultado de un partido (payload: `{ home_score: number, away_score: number }`) |
| GET	   | `/api/standings` | Lista de posiciones/tablas de puntaje |

## 🔧 Setup local

Clonar el proyecto:

```bash
git clone <repo-url>
cd backend
```

Instalar dependencias:
```bash
composer install
```

Crear archivo .env basado en .env.example:
```bash
cp .env.example .env
php artisan key:generate
```

Configurar base de datos (SQLite, MySQL, etc.) en .env:
```bash
DB_CONNECTION=sqlite
DB_DATABASE=/ruta/a/tu/database.sqlite
```

Migrar y sembrar datos:
```bash
php artisan migrate
php artisan db:seed   # opcional
```

Levantar servidor:
```bash
php artisan serve
```

Por defecto: http://127.0.0.1:8000

## 🧩 Flujo de datos

TeamsController: devuelve la lista de equipos y permite crear nuevos equipos.

GameController: devuelve partidos pendientes, y permite reportar resultados. Al reportar un resultado, se ejecuta CalculateTeamScore para actualizar goles a favor/en contra.

CalculateTeamScore: acción que actualiza automáticamente los goles de los equipos después de cada partido.

## ✅ Tests automáticos

Se incluyen pruebas de feature para verificar el cálculo correcto de puntos y posiciones:

Archivo: tests/Feature/MiniLigaTest.php

Usa RefreshDatabase para resetear la base de datos entre pruebas.

Ejemplo de test:
```bash
$this->postJson("/api/games/{$match1->id}/result", [
    'home_score' => 2,
    'away_score' => 0,
])->assertOk();

$response = $this->getJson('/api/standings')->assertOk();
$standings = $response->json();

// Validaciones de puntos y goles
$dragons = collect($standings)->firstWhere('name', 'Dragons');
$this->assertEquals(4, $dragons['points']);
$this->assertEquals(3, $dragons['goals_for']);
$this->assertEquals(1, $dragons['goals_against']);
$this->assertEquals(2, $dragons['goal_diff']);
```
Ejecutar tests
```bash
php artisan test
```

Esto correrá todas las pruebas unitarias y de integración, incluyendo la validación de resultados y tabla de posiciones.
