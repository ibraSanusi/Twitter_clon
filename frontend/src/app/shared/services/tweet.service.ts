import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { IUser } from '../interfaces/user.interface';
import { Observable } from 'rxjs';
import { Like, TweetResponse } from '../interfaces/tweet.interface';

@Injectable({
  providedIn: 'root',
})
export class TweetService {
  private apiUrl = 'http://127.0.0.1:8000/';

  constructor(private http: HttpClient) {}

  get(path: string): Observable<any> {
    return this.http.get<TweetResponse>(`${this.apiUrl}${path}`, {
      withCredentials: true,
    });
  }

  post(body: any, path: string): Observable<any> {
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

  delete(body: any, path: string): Observable<any> {
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
}
