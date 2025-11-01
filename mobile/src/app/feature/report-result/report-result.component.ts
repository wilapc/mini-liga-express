import { Component, inject, OnInit } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import {
  IonButton,
  IonContent,
  IonHeader,
  IonInput,
  IonItem,
  IonLabel,
  IonTitle,
  IonToolbar,
} from '@ionic/angular/standalone';
import { ApiService } from 'src/app/services/api.service';

@Component({
  selector: 'app-report-result',
  templateUrl: './report-result.component.html',
  styleUrls: ['./report-result.component.scss'],
  imports: [
    ReactiveFormsModule,
    IonLabel,
    IonItem,
    IonButton,
    IonHeader,
    IonToolbar,
    IonTitle,
    IonInput,
    IonContent,
  ],
  standalone: true,
})
export class ReportResultComponent implements OnInit {
  private api = inject(ApiService);
  private route = inject(ActivatedRoute);
  private router = inject(Router);

  matchId = Number(this.route.snapshot.paramMap.get('id'));

  form = new FormGroup({
    home_score: new FormControl(0, { nonNullable: true }),
    away_score: new FormControl(0, { nonNullable: true }),
  });

  back() {
    this.router.navigateByUrl('/games');
  }

  submit() {
    this.api.reportResult(this.matchId, this.form.getRawValue()).subscribe({
      next: () => {
        this.router.navigateByUrl('/games');
      },
      error: (err) => console.error('Error reporting result', err),
    });
  }

  constructor() {}

  ngOnInit() {}
}
