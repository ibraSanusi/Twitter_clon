import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { IUser } from '../interfaces/user.interface';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private apiUrl = 'http://127.0.0.1:8000/';

  constructor(private http: HttpClient) {}

  post(body: IUser): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
    });

    return this.http.post<any>(this.apiUrl, body, { headers });
  }

  login(body: IUser, path: string): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json' as const,
      Accept: 'application/json' as const,
    });

    return this.http.post(`${this.apiUrl}${path}`, body, {
      headers,
      withCredentials: true,
      responseType: 'json' as const,
    });
  }
}
