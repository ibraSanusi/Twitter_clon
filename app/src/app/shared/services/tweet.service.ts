import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { IUser } from '../interfaces/user.interface';
import { Observable } from 'rxjs';
import { TweetResponse } from '../interfaces/tweet.interface';

@Injectable({
  providedIn: 'root',
})
export class TweetService {
  private apiUrl = 'http://127.0.0.1:8000/';

  constructor(private http: HttpClient) {}

  getTweets(path: string): Observable<any> {
    return this.http.get<TweetResponse>(`${this.apiUrl}${path}`, {
      withCredentials: true,
    });
  }
}
