import { Component, inject } from '@angular/core';
import { ApiService } from '../../services/api-service';
import { Observable } from 'rxjs';
import { Teams } from '../../models/teams.interface';
import { AsyncPipe } from '@angular/common';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';

@Component({
  selector: 'app-teams',
  imports: [AsyncPipe, ReactiveFormsModule],
  templateUrl: './teams.html',
  styleUrl: './teams.scss',
})
export class TeamsComponent {
  private api = inject(ApiService);

  teams$: Observable<Teams[]> = this.api.getTeams();

  teamForm = new FormGroup({
    name: new FormControl<string>('', { nonNullable: true }),
  });

  saveTeamName() {
    const payload = this.teamForm.value as { name: string };
    this.api.createTeam(payload);
  }
}
