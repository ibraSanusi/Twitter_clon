import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { IUser } from '@core/models/user.interface';
import { TweetResponse } from '@core/models/tweet.interface';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private apiUrl = 'http://127.0.0.1:8000';

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

    return this.http.post<any>(`${this.apiUrl}${path}`, body, {
      headers,
      withCredentials: true,
      responseType: 'json' as const,
    });
  }

  logout(path: string): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json' as const,
      Accept: 'application/json' as const,
    });

    return this.http.post<any>(`${this.apiUrl}${path}`, {
      headers,
      withCredentials: true,
      responseType: 'json' as const,
    });
  }

  checkSession(path: string): Observable<any> {
    return this.http.get<TweetResponse>(`${this.apiUrl}${path}`, {
      withCredentials: true,
    });
  }

  getAllTweets(path: string) {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json' as const,
      Accept: 'application/json' as const,
    });

    return this.http.get<any>(`${this.apiUrl}${path}`, {
      headers,
      withCredentials: true,
      responseType: 'json' as const,
    });
  }
}
