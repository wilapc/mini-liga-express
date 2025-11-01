import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';
import { Observable } from 'rxjs';
import { Teams } from '../models/teams.interface';
import { Standings } from '../models/standings.interface';

@Injectable({
  providedIn: 'root',
})
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
