# MiniLiga Express - Web Angular 20

Frontend desarrollado con Angular 20, mostrando equipos, clasificación y permitiendo crear nuevos equipos.

## 📂 Estructura principal
```bash
web/
├─ src/
│  ├─ app/
│  │  ├─ features/
│  │  │  ├─ teams/           # Componente Teams
│  │  │  └─ standings/       # Componente Standings
│  │  ├─ models/             # Interfaces (Teams, Standings)
│  │  ├─ services/           # ApiService
│  │  └─ app-routing.module.ts
│  ├─ environments/          # environment.ts y environment.prod.ts
│  │  └─ environment.ts      # API_URL por defecto
│  └─ main.ts
├─ package.json
└─ README.md
```

## ⚡ Setup local

Instalar dependencias:
```bash
npm install
```

Configurar URL base del backend en src/environments/environment.ts:
```bash
export const environment = {
  production: false,
  API_URL: 'http://127.0.0.1:8000', // URL del backend Laravel
};
```

Levantar servidor de desarrollo:
```bash
ng serve
```

Por defecto: http://localhost:4200

## 🧩 Servicios (ApiService)

`src/app/services/api-service.ts:`
```bash
@Injectable({ providedIn: 'root' })
export class ApiService {
  private base = environment.API_URL;

  constructor(private http: HttpClient) {}

  getTeams(): Observable<Teams[]> {
    return this.http.get<Teams[]>(`${this.base}/api/teams`);
  }

  createTeam(payload: { name: string }) {
    return this.http.post(`${this.base}/api/teams`, payload);
  }

  getStandings(): Observable<Standings[]> {
    return this.http.get<Standings[]>(`${this.base}/api/standings`);
  }
}
```
## 🧩 Modelos

`src/app/models/teams.interface.ts:`
```bash
export interface Teams {
  id: number;
  name: string;
}
```

`src/app/models/standings.interface.ts:`
```bash
export interface Standings {
  id: number;
  name: string;
  played: number;
  points: number;
  goals_for: number;
  goals_against: number;
  goal_diff: number;
  position: number;
}
```
## 🧩 Componentes
TeamsComponent

Carpeta: `features/teams`

Permite listar y crear equipos.

Actualiza la lista automáticamente después de guardar.

HTML (teams.html):
```bash
<div>
  <h1>Equipos</h1>
  <form [formGroup]="teamForm" (ngSubmit)="saveTeamName()">
    <input formControlName="name" placeholder="Nombre del equipo" />
    <button type="submit">Crear</button>
  </form>

  <ul>
    @if (teams$ | async; as teams) { @for (team of teams; track $index) {
      <li>{{ team.name }}</li>
    } }
  </ul>
</div>
```

TypeScript (teams.component.ts):
```bash
@Component({
  selector: 'app-teams',
  imports: [AsyncPipe, ReactiveFormsModule, RouterLink],
})
export class TeamsComponent {
  private api = inject(ApiService);
  teams$: Observable<Teams[]> = this.api.getTeams();

  teamForm = new FormGroup({
    name: new FormControl<string>('', { nonNullable: true }),
  });

  saveTeamName() {
    const payload = this.teamForm.value as { name: string };
    this.api.createTeam(payload).subscribe({
      next: () => {
        this.teamForm.reset();
        this.teams$ = this.api.getTeams(); // recarga lista
      },
      error: (err) => console.error('Error al crear equipo', err),
    });
  }
}
```
StandingsComponent

Carpeta: `features/standings`

Muestra la clasificación de equipos con puntos y goles.

HTML (standings.html):
```bash
<div>
  <nav><a routerLink="/teams">Equipos</a></nav>
  <h1>Clasificación</h1>

  <table border="1">
    <thead>
      <tr>
        <th>Posición</th>
        <th>Equipo</th>
        <th>Juegos</th>
        <th>Puntos</th>
        <th>G.E</th>
        <th>G.F</th>
        <th>D.G</th>
      </tr>
    </thead>
    <tbody>
      @if (teamStaning$ | async; as teamStaning) { @for (team of teamStaning; track $index) {
        <tr>
          <td>{{ team.position }}</td>
          <td>{{ team.name }}</td>
          <td>{{ team.played }}</td>
          <td>{{ team.points }}</td>
          <td>{{ team.goals_against }}</td>
          <td>{{ team.goals_for }}</td>
          <td>{{ team.goal_diff }}</td>
        </tr>
      } }
    </tbody>
  </table>
</div>
```

TypeScript (standings.component.ts):
```bash
@Component({
  selector: 'app-standings',
  imports: [AsyncPipe, RouterLink],
})
export class StandingsComponent {
  private api = inject(ApiService);
  teamStaning$: Observable<Standings[]> = this.api.getStandings();
}
```
## 🧩 Rutas

`app-routing.module.ts:`
```bash
const routes: Routes = [
  { path: '', redirectTo: 'teams', pathMatch: 'full' },
  { path: 'teams', component: TeamsComponent },
  { path: 'standings', component: StandingsComponent },
];
```
## ⚡ Notas

Se usa ReactiveFormsModule para los formularios.

Se usa AsyncPipe para suscribirse automáticamente a los Observables.

Se recarga la lista de equipos después de crear un nuevo equipo.

environment.API_URL debe apuntar al backend Laravel (por defecto http://127.0.0.1:8000).

Angular CLI does not come with an end-to-end testing framework by default. You can choose one that suits your needs.

## Additional Resources

For more information on using the Angular CLI, including detailed command references, visit the [Angular CLI Overview and Command Reference](https://angular.dev/tools/cli) page.
