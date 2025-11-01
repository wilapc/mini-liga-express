import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';
import { GamesComponent } from './feature/games/games.component';
import { ReportResultComponent } from './feature/report-result/report-result.component';

const routes: Routes = [
  {
    path: '',
    redirectTo: 'games',
    pathMatch: 'full',
  },
  {
    path: 'games',
    loadComponent: () =>
      import('./feature/games/games.component').then((m) => m.GamesComponent),
  },
  {
    path: 'report/:id',
    loadComponent: () =>
      import('./feature/report-result/report-result.component').then(
        (m) => m.ReportResultComponent
      ),
  },
];
@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules }),
  ],
  exports: [RouterModule],
})
export class AppRoutingModule {}
