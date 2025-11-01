import { AsyncPipe } from '@angular/common';
import { Component, inject } from '@angular/core';
import { Observable } from 'rxjs';
import { Standings } from '../../models/standings.interface';
import { ApiService } from '../../services/api-service';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-standings',
  imports: [AsyncPipe, RouterLink],
  templateUrl: './standings.html',
  styleUrl: './standings.scss',
})
export class StandingsComponent {
  private api = inject(ApiService);
  teamStaning$: Observable<Standings[]> = this.api.getStandings();
}
