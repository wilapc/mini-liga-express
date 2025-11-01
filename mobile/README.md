# MiniLiga Express - Mobile Ionic 8

Frontend móvil desarrollado con Ionic 8 + Angular, permite ver partidos pendientes y reportar resultados.

## 📂 Estructura principal
```bash
mobile/
├─ src/
│  ├─ app/
│  │  ├─ features/
│  │  │  ├─ games/             # Componente GamesComponent
│  │  │  └─ report-result/     # Componente ReportResultComponent
│  │  ├─ services/             # ApiService
│  │  ├─ environments/         # environment.ts
│  │  └─ app-routing.module.ts
├─ package.json
└─ README.md
```
## ⚡ Setup local

Instalar dependencias:
```bash
npm install
```

Configurar URL del backend en `src/environments/environment.ts:`
```bash
export const environment = {
  production: false,
  API_URL: 'http://127.0.0.1:8000', // backend Laravel
};
```

Levantar servidor de desarrollo:
```bash
ionic serve
```

Por defecto: `http://localhost:8100`

## 🧩 Servicios (ApiService)

`src/app/services/api.service.ts:`
```bash
@Injectable({ providedIn: 'root' })
export class ApiService {
  base = environment.API_URL;

  constructor(private http: HttpClient) {}

  getPendingMatches(): Observable<any[]> {
    return this.http.get<any[]>(`${this.base}/api/games?played=false`);
  }

  reportResult(id: number, payload: { home_score: number; away_score: number }) {
    return this.http.post(`${this.base}/api/games/${id}/result`, payload);
  }
}


getPendingMatches() → lista de partidos pendientes (sin resultado).

reportResult(id, payload) → envía el resultado de un partido al backend.
```
## 🧩 Componentes
GamesComponent

Carpeta: `features/games`

Lista partidos pendientes y permite navegar a reportar resultados.

HTML (games.component.html):
```bash
<ion-header>
  <ion-toolbar color="primary">
    <ion-title>Partidos Pendientes</ion-title>
  </ion-toolbar>
</ion-header>

<ion-content class="ion-padding">
  @if (matches$ | async; as matches) {
  <ion-list>
    @for (match of matches; track match.id) {
    <ion-item [routerLink]="['/report', match.id]">
      <ion-label>
        <h2>{{ match.home_team.name }} vs {{ match.away_team.name }}</h2>
      </ion-label>
    </ion-item>
    }
  </ion-list>
  } @else {
  <ion-spinner class="center"></ion-spinner>
  }
</ion-content>
```

TypeScript (games.component.ts):

Se suscribe automáticamente a los partidos pendientes.

Se refresca cada vez que la vista se vuelve a activar (ionViewWillEnter).

ReportResultComponent

Carpeta: `features/report-result`

Permite ingresar y enviar el resultado de un partido.

HTML (report-result.component.html):
```bash
<ion-header>
  <ion-toolbar>
    <ion-title>Reportar Resultado</ion-title>
  </ion-toolbar>
</ion-header>

<ion-content class="ion-padding">
  <form [formGroup]="form" (ngSubmit)="submit()">
    <ion-item>
      <ion-label position="stacked">Local</ion-label>
      <ion-input type="number" formControlName="home_score"></ion-input>
    </ion-item>

    <ion-item>
      <ion-label position="stacked">Visitante</ion-label>
      <ion-input type="number" formControlName="away_score"></ion-input>
    </ion-item>

    <ion-button expand="block" type="submit">Submit</ion-button>
  </form>

  <ion-button expand="block" (click)="back()">Regresar</ion-button>
</ion-content>
```

TypeScript (report-result.component.ts):

- Obtiene matchId desde la ruta.

- Envía resultado al backend usando `ApiService.reportResult()`.

- Redirige de vuelta a la lista de partidos al completar.

## 🧩 Rutas

- `/games → GamesComponent`

- `/report/:id → ReportResultComponent`

- Nota: Las rutas usan el mismo backend Laravel que la versión web.

## ⚡ Notas

- Uso de Ionic Standalone Components para cada componente `(imports: [...])`.

- Formularios con ReactiveFormsModule.

- `AsyncPipe` para suscribirse automáticamente a Observables.

- La app depende del mismo backend Laravel del proyecto web `(API_URL)`.
