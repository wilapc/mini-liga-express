import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';
import { GamesComponent } from './feature/games/games.component';
import { ReportResultComponent } from './feature/report-result/report-result.component';
import { IonicModule } from '@ionic/angular';

const routes: Routes = [
  {
    path: '',
    redirectTo: 'games',
    pathMatch: 'full',
  },
  {
    path: 'games',
    component: GamesComponent,
  },
  {
    path: 'report/:id',
    component: ReportResultComponent,
  },
];
@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules }),
    IonicModule,
  ],
  exports: [RouterModule],
})
export class AppRoutingModule {}
