import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';
import { Observable } from 'rxjs';

@Injectable({ providedIn: 'root' })
export class ApiService {
  base = environment.API_URL;

  constructor(private http: HttpClient) {}

  getPendingMatches(): Observable<any[]> {
    return this.http.get<any[]>(`${this.base}/api/games?played=false`);
  }

  reportResult(
    id: number,
    payload: { home_score: number; away_score: number }
  ) {
    return this.http.post(`${this.base}/api/games/${id}/result`, payload);
  }
}
